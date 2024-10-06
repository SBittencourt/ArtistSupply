@extends('layouts.master')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Eventos</h1>
        <a href="{{ route('events.create') }}" class="btn btn-create">Criar Novo Evento</a>
    </div>

    <div class="d-flex mb-4">
        <div class="mr-2">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown">
                    Filtros
                </button>
                <div class="dropdown-menu" aria-labelledby="filterDropdown">
                    <a class="dropdown-item" href="{{ route('events.index', ['order' => 'asc']) }}">Mais Próximos</a>
                    <a class="dropdown-item" href="{{ route('events.index', ['order' => 'desc']) }}">Mais Distantes</a>
                </div>
            </div>
        </div>

        <form action="{{ route('events.index') }}" method="GET" class="d-flex flex-grow-1">
            <input type="text" name="search" class="form-control" placeholder="Pesquisar eventos..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary ml-2">Pesquisar</button>
        </form>
    </div>

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

        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.getElementById('filterDropdown');
            const dropdownMenu = dropdownToggle.nextElementSibling;

            dropdownToggle.addEventListener('click', function() {
                dropdownMenu.classList.toggle('show');
            });

            window.addEventListener('click', function(event) {
                if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>
@endsection

<style>
    .btn-create {
        background-color: #ca88ff; 
        border-color: #6a28a7;
        color: white;
    }

    .btn-create:hover {
        background-color: #512188; 
        border-color: #481e7e;
    }

    .content-header {
        padding: 1rem 0;
    }

    .form-control {
        width: 100%; 
    }

    .table thead {
        background-color: #3e1f78; 
        color: white;
    }

    .table tbody tr:hover {
        background-color: #32136d; 
    }

    .btn-primary {
        background-color: #3e1f78;
        border-color: #3e1f78;
    }

    .btn-primary:hover {
        background-color: #29134e;
        border-color: #29134e;
    }

    .dropdown-menu {
        display: none; 
    }

    .dropdown-menu.show {
        display: block; 
    }
</style>
