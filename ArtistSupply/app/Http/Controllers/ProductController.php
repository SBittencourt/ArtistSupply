<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category'); 

        $products = Product::where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->get();

        $categories = Category::where('user_id', Auth::id())->get(); 

        return view('products.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get(); 
        return view('products.create', compact('categories'));
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.index')->with('error', 'Você não tem permissão para editar este produto.');
        }

        $categories = Category::where('user_id', Auth::id())->get();
        return view('products.edit', compact('product', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantia' => 'required|integer',
            'preco' => 'required|string', 
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'extra' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $preco = str_replace(['.', ','], ['', '.'], $request->input('preco'));

        if (!is_numeric($preco)) {
            return redirect()->back()->withErrors(['preco' => 'O preço deve ser um número válido.']);
        }

        Product::create([
            'nome' => $request->nome,
            'quantia' => $request->quantia,
            'preco' => $preco, 
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.index')->with('error', 'Você não tem permissão para atualizar este produto.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'quantia' => 'required|integer',
            'preco' => 'required|string', 
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'extra' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $preco = str_replace(['.', ','], ['', '.'], $request->input('preco'));

        if (!is_numeric($preco)) {
            return redirect()->back()->withErrors(['preco' => 'O preço deve ser um número válido.']);
        }

        $product->update([
            'nome' => $request->nome,
            'quantia' => $request->quantia,
            'preco' => $preco, 
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }




    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.index')->with('error', 'Você não tem permissão para excluir este produto.');
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }

}
