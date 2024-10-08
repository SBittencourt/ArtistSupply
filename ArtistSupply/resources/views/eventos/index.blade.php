@extends('layouts.master')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Eventos</h1>
        <a href="{{ route('events.create') }}" class="btn btn-create">Criar Novo Evento</a>
    </div>

    <form action="{{ route('events.index') }}" method="GET" class="mb-4 d-flex align-items-end">
        <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar eventos..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Pesquisar</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->data_inicio)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->data_fim)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form id="play-form-{{ $event->id }}" action="{{ route('activeEvents.start', $event->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="button" class="btn btn-success" onclick="startEvent({{ $event->id }})">
                                <i class="fas fa-play"></i>
                            </button>
                        </form>

                        <form id="delete-form-{{ $event->id }}" action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $event->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(eventId) {
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
                    document.getElementById('delete-form-' + eventId).submit();
                }
            });
        }

        function startEvent(eventId) {
            Swal.fire({
                title: 'Iniciar Evento',
                text: "Tem certeza que deseja iniciar este evento?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, iniciar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('play-form-' + eventId).submit();
                }
            });
        }
    </script>
@endsection


