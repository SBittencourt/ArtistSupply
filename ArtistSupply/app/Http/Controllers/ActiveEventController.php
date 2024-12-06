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
    
        // Verifique se o evento já tem um evento ativo não finalizado
        $activeEvent = $event->activeEvent()->whereNull('end_time')->first();
    
        if ($activeEvent) {
            // Redireciona para a visualização do evento ativo, se já estiver em andamento
            return redirect()->route('activeEvents.show', $activeEvent->id);
        }
    
        // Caso contrário, cria um novo evento ativo
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
    
        return redirect()->route('activeEvents.summary', $activeEvent->id);
    }
    

    public function summary($activeEventId)
    {
        $activeEvent = ActiveEvent::findOrFail($activeEventId);
    
        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para visualizar este resumo.'], 403);
        }
    
        $soldProducts = $activeEvent->products;
    
        return view('activeEvents.summary', compact('activeEvent', 'soldProducts'));
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

    public function index(Request $request)
    {
        $eventId = $request->input('event_id');
        $search = $request->input('search');
    
        $activeEvents = ActiveEvent::with('event')
            ->where('user_id', auth()->id())
            ->when($eventId, function ($query) use ($eventId) {
                $query->where('event_id', $eventId); 
            })
            ->whereHas('event', function($query) use ($search) {
                if ($search) {
                    $query->where('nome', 'like', '%' . $search . '%'); 
                }
            })
            ->get();
    
        return view('activeEvents.index', compact('activeEvents'));
    }
    
    public function destroy($id)
    {
        $activeEvent = ActiveEvent::findOrFail($id);

        if ($activeEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Você não tem permissão para excluir este evento.'], 403);
        }

        $activeEvent->delete(); 

        return redirect()->route('activeEvents.index')->with('success', 'Evento ativo excluído com sucesso.');
    }

    public function generalReport()
    {
        $userId = auth()->id();
        
        // Obtendo os produtos vendidos e agrupando por categoria e produto
        $soldProducts = \DB::table('active_event_product')
            ->join('products', 'active_event_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.user_id', $userId)
            ->select(
                'products.nome as product_name',
                'categories.nome as category_name',
                \DB::raw('COALESCE(SUM(active_event_product.quantity_sold), 0) as total_quantity'),
                \DB::raw('COALESCE(SUM(active_event_product.total_value), 0) as total_value')
            )
            ->groupBy('products.id', 'products.nome', 'categories.id', 'categories.nome')
            ->get();
    
        // Agrupando dados por categoria para os gráficos
        $categoriesData = $soldProducts->groupBy('category_name')->map(function ($group) {
            return $group->sum('total_value');
        });
    
        // Agrupando as vendas por mês (valor total vendido por mês)
        $salesOverTime = \DB::table('active_event_product')
            ->join('active_events', 'active_event_product.active_event_id', '=', 'active_events.id')
            ->join('products', 'active_event_product.product_id', '=', 'products.id')
            ->where('products.user_id', $userId)
            ->select(
                \DB::raw('DATE_FORMAT(active_events.start_time, "%Y-%m") as month_year'),  // Formatação para ano-mês
                \DB::raw('COALESCE(SUM(active_event_product.total_value), 0) as total_value')
            )
            ->groupBy(\DB::raw('DATE_FORMAT(active_events.start_time, "%Y-%m")'))  // Agrupando por ano-mês
            ->orderBy(\DB::raw('DATE_FORMAT(active_events.start_time, "%Y-%m")'), 'ASC')  // Ordenando por mês e ano
            ->get();
    
        // Preparando dados para o gráfico de vendas por mês
        $monthsData = $salesOverTime->pluck('total_value', 'month_year');
    
        // Preparando dados para os gráficos
        $chartData = [
            'quantities' => $soldProducts->pluck('total_quantity', 'product_name'),
            'values' => $soldProducts->pluck('total_value', 'product_name'),
            'categories' => $categoriesData,
            'months' => $monthsData,  // Dados para o gráfico mensal
        ];
    
        return view('reports.general', compact('chartData', 'soldProducts', 'monthsData'));
    }
    
}
