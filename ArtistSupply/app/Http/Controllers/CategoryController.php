<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $categories = Category::where('user_id', Auth::id())
            ->when($search, function($query, $search) {
                return $query->where('nome', 'LIKE', "%{$search}%");
            })
            ->get();

        return view('categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'extra' => 'nullable|string',
        ]);

        Category::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('categories.edit', compact('category'));
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
        return redirect()->route('categories.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoria excluída com sucesso.');
    }
}
