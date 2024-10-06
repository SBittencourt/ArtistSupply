@extends('layouts.master')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Categorias</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-create">Criar Nova Categoria</a>
    </div>

    <form action="{{ route('categories.index') }}" method="GET" class="d-flex mb-4">
        <input type="text" name="search" class="form-control" placeholder="Pesquisar categorias..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary ml-2">Pesquisar</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->nome }}</td>
                    <td>{{ $category->descricao }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $category->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(categoryId) {
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
                    document.getElementById('delete-form-' + categoryId).submit();
                }
            });
        }
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
</style>
