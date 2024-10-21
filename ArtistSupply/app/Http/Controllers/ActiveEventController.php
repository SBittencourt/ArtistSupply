<?php

namespace App\Http\Controllers;

use App\Models\ActiveEvent;
use App\Models\Product;
use App\Models\Event;
use Illuminate\Http\Request;

class ActiveEventController extends Controller
{
    public function startEvent($eventId)
    {
        $event = Event::findOrFail($eventId);

        $activeEvent = ActiveEvent::create([
            'event_id' => $eventId,
            'user_id' => auth()->id(),
            'start_time' => now(),
        ]);

        return redirect()->route('activeEvents.show', $activeEvent->id);
    }

    public function endEvent($activeEventId)
    {
        $activeEvent = ActiveEvent::findOrFail($activeEventId);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para finalizar este evento.'], 403);
        }

        $activeEvent->end_time = now(); 
        $activeEvent->total_profit = $activeEvent->total_gross - $activeEvent->total_expense;
        $activeEvent->save();

        return view('activeEvents.summary', compact('activeEvent'));
    }

    public function sellProduct(Request $request, $activeEventId, $productId)
    {
        $activeEvent = ActiveEvent::findOrFail($activeEventId);
        $product = Product::findOrFail($productId);

        if ($activeEvent->user_id !== auth()->id() || $product->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para realizar esta venda.'], 403);
        }

        $quantitySold = $request->input('quantity');
        if ($quantitySold > $product->quantia) {
            return response()->json(['error' => 'Quantidade insuficiente no estoque.'], 400);
        }

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

    public function show($id)
    {
        $activeEvent = ActiveEvent::findOrFail($id);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para visualizar este evento.'], 403);
        }

        $products = Product::where('user_id', auth()->id())->get();
        $soldProducts = $activeEvent->products;

        return view('activeEvents.show', compact('activeEvent', 'products', 'soldProducts'));
    }
}
