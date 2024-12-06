<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category'); 
        
        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', '%' . $search . '%')
                             ->orWhere('local', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->get();
        
        $categories = Category::where('user_id', Auth::id())->get();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ], 200);
    }
    
    
    public function create()
    {
        $categories = Category::all();
    
        return response()->json([
            'categories' => $categories,
        ], 200);
    }
    

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return response()->json(['error' => 'Você não tem permissão para editar este produto.'], 403);
        }

        $categories = Category::where('user_id', Auth::id())->get();
        return response()->json([
            'product' => $product,
            'categories' => $categories,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantia' => 'required|integer',
            'preco' => 'required|numeric',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'extra' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $product = Product::create([
            'nome' => $request->nome,
            'quantia' => $request->quantia,
            'preco' => $request->preco,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'category_id' => $request->category_id,
            'user_id' => 1,
        ]);
    
        return response()->json(['message' => 'Produto criado com sucesso!', 'product' => $product], 201);
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        if ($product->user_id !== Auth::id()) {
            return response()->json(['error' => 'Você não tem permissão para atualizar este produto.'], 403);
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
    
        $precoInput = $request->input('preco');
    
        if (!str_contains($precoInput, ',') && !str_contains($precoInput, '.') && strlen($precoInput) > 3) {
            $precoInput = substr_replace($precoInput, ',', -2, 0);
        }
    
        $precoFormatado = str_replace(',', '.', $precoInput);
    
        if (!is_numeric($precoFormatado) || floatval($precoFormatado) < 0) {
            return response()->json(['error' => 'O preço deve ser um número válido.'], 400);
        }
    
        $precoFormatado = floatval($precoFormatado);
    
        $product->update([
            'nome' => $request->nome,
            'quantia' => $request->quantia,
            'preco' => $precoFormatado,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'category_id' => $request->category_id,
        ]);
    
        return response()->json(['message' => 'Produto atualizado com sucesso!', 'product' => $product], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();
        return response()->json(['message' => 'Produto excluído com sucesso!'], 200);
    }
}
