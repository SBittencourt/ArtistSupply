<?php

namespace App\Http\Controllers\Api;

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
    
        return response()->json($events);
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

        $event = Event::create([
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
            'user_id' => Auth::id(),
        ]);

        return response()->json($event, 201); 
    }

    public function show($id)
    {
        $event = Event::where('id', $id)->findOrFail();
        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $event = Event::where('id', $id)->first();
        $event->update([
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'extra' => $request->extra,
        ]);

        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        return response()->json(['message' => 'Evento excluído com sucesso!']);
    }
}
