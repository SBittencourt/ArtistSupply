<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'LIKE', "%{$search}%");
            })
            ->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'extra' => 'nullable|string',
        ]);

        $category = Category::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'user_id' => Auth::id(),
        ]);

        return response()->json($category, 201); // Retorna o objeto criado com status 201
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'extra' => 'nullable|string',
        ]);

        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->update($request->all());

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->delete();

        return response()->json(['message' => 'Categoria excluída com sucesso.']);
    }
}
