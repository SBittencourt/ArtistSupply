<?php

namespace App\Http\Controllers;

use App\Models\ActiveEvent;
use App\Models\Product;
use App\Models\Event;
use Illuminate\Http\Request;

class ActiveEventController extends Controller
{
    // Inicia um novo evento ativo
    public function startEvent($eventId)
    {
        $event = Event::findOrFail($eventId);

        // Verifica se o evento pertence ao usuário logado
        if ($event->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para iniciar este evento.'], 403);
        }

        $activeEvent = ActiveEvent::create([
            'event_id' => $eventId,
            'user_id' => auth()->id(),
            'start_time' => now(),
        ]);

        return redirect()->route('activeEvents.show', $activeEvent->id);
    }

    // Termina um evento ativo
    public function endEvent($activeEventId)
    {
        $activeEvent = ActiveEvent::findOrFail($activeEventId);

        // Verifica se o evento pertence ao usuário logado
        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para finalizar este evento.'], 403);
        }

        $activeEvent->end_time = now();
        $activeEvent->total_profit = $activeEvent->total_gross - $activeEvent->total_expense;
        $activeEvent->save();

        return view('activeEvents.summary', compact('activeEvent'));
    }

    // Vender produto e atualizar o evento ativo
    public function sellProduct(Request $request, $activeEventId, $productId)
    {
        $activeEvent = ActiveEvent::findOrFail($activeEventId);
        $product = Product::findOrFail($productId);

        // Verifica se o produto e o evento pertencem ao usuário logado
        if ($activeEvent->user_id !== auth()->id() || $product->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para realizar esta venda.'], 403);
        }

        $quantitySold = $request->input('quantity');
        $product->quantia -= $quantitySold;
        $product->save();

        $totalValue = $quantitySold * $product->preco;

        $activeEvent->products()->attach($productId, [
            'quantity_sold' => $quantitySold,
            'total_value' => $totalValue,
        ]);

        $activeEvent->total_gross += $totalValue;
        $activeEvent->save();

        return redirect()->route('activeEvents.show', $activeEvent->id);
    }

    // Adiciona gastos ao evento ativo
    public function addExpense(Request $request, $activeEventId)
    {
        $activeEvent = ActiveEvent::findOrFail($activeEventId);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para adicionar gastos a este evento.'], 403);
        }

        $expenseAmount = $request->input('expense');
        $activeEvent->total_expense += $expenseAmount;
        $activeEvent->save();

        return redirect()->route('activeEvents.show', $activeEvent->id);
    }

    // Exibe os detalhes do evento ativo
    public function show($id)
    {
        $activeEvent = ActiveEvent::findOrFail($id);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para visualizar este evento.'], 403);
        }

        $products = Product::where('user_id', auth()->id())->get();
        return view('activeEvents.show', compact('activeEvent', 'products'));
    }
}
