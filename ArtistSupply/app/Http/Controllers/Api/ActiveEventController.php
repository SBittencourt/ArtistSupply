<?php

namespace App\Http\Controllers\Api;

use App\Models\ActiveEvent;
use App\Models\Product;
use App\Models\Event;
use Illuminate\Http\Request;

class ActiveEventController extends Controller
{
    public function startEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        $activeEvent = $event->activeEvent()->whereNull('end_time')->first();

        if ($activeEvent) {
            return response()->json($activeEvent, 200);
        }

        $activeEvent = ActiveEvent::create([
            'event_id' => $eventId,
            'user_id' => auth()->id(),
            'start_time' => now(),
        ]);

        return response()->json($activeEvent, 201);
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

        return response()->json($activeEvent);
    }

    public function summary($activeEventId)
    {
        $activeEvent = ActiveEvent::findOrFail($activeEventId);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para visualizar este resumo.'], 403);
        }

        $soldProducts = $activeEvent->products;

        return response()->json([
            'activeEvent' => $activeEvent,
            'soldProducts' => $soldProducts,
        ]);
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

        return response()->json($activeEvent);
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

        return response()->json($activeEvent);
    }

    public function show($id)
    {
        $activeEvent = ActiveEvent::findOrFail($id);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para visualizar este evento.'], 403);
        }

        $products = Product::where('user_id', auth()->id())->get();
        $soldProducts = $activeEvent->products;

        return response()->json([
            'activeEvent' => $activeEvent,
            'products' => $products,
            'soldProducts' => $soldProducts,
        ]);
    }

    public function index(Request $request)
    {
        $eventId = $request->input('event_id');
        $search = $request->input('search');

        $activeEvents = ActiveEvent::with('event')
            ->where('user_id', auth()->id())
            ->when($eventId, function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            })
            ->whereHas('event', function ($query) use ($search) {
                if ($search) {
                    $query->where('nome', 'like', '%' . $search . '%');
                }
            })
            ->get();

        return response()->json($activeEvents);
    }

    public function destroy($id)
    {
        $activeEvent = ActiveEvent::findOrFail($id);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para excluir este evento.'], 403);
        }

        $activeEvent->delete();

        return response()->json(['message' => 'Evento ativo excluído com sucesso.']);
    }
}
