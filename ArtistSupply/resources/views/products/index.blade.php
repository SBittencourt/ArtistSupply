@extends('layouts.master')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Produtos</h1>
        <a href="{{ route('products.create') }}" class="btn btn-create">Criar Novo Produto</a>
    </div>

    <form action="{{ route('products.index') }}" method="GET" class="mb-4 d-flex align-items-end">
        {{-- <select name="category" class="form-control me-2 category-filter">
            <option value="">Todas as Categorias</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->nome }}
                </option>
            @endforeach
        </select> --}}
        

        
        <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar produtos..." value="{{ request('search') }}">
        
        
        <button type="submit" class="btn btn-primary">Pesquisar</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Local</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->nome }}</td>
                    <td>{{ $product->quantia }}</td>
                    <td>{{ number_format($product->preco, 2, ',', '.') }}</td>
                    <td>{{ $product->local }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $product->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(productId) {
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
                    document.getElementById('delete-form-' + productId).submit();
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

    /* Estilo para o filtro de categorias */
    .category-filter {
        width: 150px; /* Ajuste a largura conforme necessário */
    }
</style>
