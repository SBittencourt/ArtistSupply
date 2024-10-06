<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $events = Event::query()
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', '%' . $search . '%');
            })
            ->get();

        return view('eventos.index', compact('events'));
    }


    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Event::create([
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    public function edit(Event $event)
    {
        return view('eventos.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $event->update([
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
        ]);

        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }


    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento excluído com sucesso!');
    }
    
}
