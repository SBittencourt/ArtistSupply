@extends('layouts.master')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h1 class="ml-4">Eventos Ativos</h1>
    </div>

    <form action="{{ route('activeEvents.index') }}" method="GET" class="mb-4 d-flex align-items-end">
        <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar eventos ativos..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary ml-2">Pesquisar</button>
    </form>

    <table class="table table-bordered" id="activeEventsTable">
        <thead>
            <tr>
                <th>Nome do Evento</th>
                <th>Data de Início</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activeEvents as $activeEvent)
                <tr>
                    <td>{{ $activeEvent->event->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($activeEvent->start_time)->format('d/m/Y H:i') }}</td>
                    <td>
                        @if(is_null($activeEvent->end_time))
                            <a href="{{ route('activeEvents.show', $activeEvent->id) }}" class="btn btn-info">Visualizar</a>
                        @else
                            <a href="{{ route('activeEvents.summary', $activeEvent->id) }}" class="btn btn-warning">Visualizar Fim</a>
                        @endif
                        <form id="delete-active-event-{{ $activeEvent->id }}" action="{{ route('activeEvents.destroy', $activeEvent->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE') 
                            <button type="button" class="btn btn-danger" onclick="confirmDeleteActiveEvent({{ $activeEvent->id }})">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>


                    </td>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#activeEventsTable').DataTable();
        });

        function confirmDeleteActiveEvent(activeEventId) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Encontra o formulário usando o ID
                    document.getElementById(`delete-active-event-${activeEventId}`).submit();
                }
            });
        }


    </script>
@endsection
