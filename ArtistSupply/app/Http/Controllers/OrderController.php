<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $orders = Order::where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', '%' . $search . '%');
            })
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantia' => 'required|integer|min:1',
            'preco' => 'required|numeric|min:0',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'fornecedor' => 'nullable|string',
        ]);

        Order::create([
            'nome' => $request->nome,
            'quantia' => $request->quantia,
            'preco' => $request->preco,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'fornecedor' => $request->fornecedor,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('orders.index')->with('success', 'Pedido criado com sucesso!');
    }

    public function edit($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantia' => 'required|integer|min:1',
            'preco' => 'required|numeric|min:0',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'fornecedor' => 'nullable|string',
        ]);

        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $order->update([
            'nome' => $request->nome,
            'quantia' => $request->quantia,
            'preco' => $request->preco,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'fornecedor' => $request->fornecedor,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pedido excluído com sucesso!');
    }
}
