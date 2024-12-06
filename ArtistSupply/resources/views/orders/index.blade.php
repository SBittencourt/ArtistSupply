@extends('layouts.master')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h1 class="ml-4">Lista de Pedidos</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-create">Criar Novo Pedido</a>
    </div>

    <form action="{{ route('orders.index') }}" method="GET" class="mb-4 d-flex align-items-end">
        <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar pedidos..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary ml-2">Pesquisar</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Quantia</th>
                <th>Preço</th>
                <th>Local</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->nome }}</td>
                    <td>{{ $order->quantia }}</td>
                    <td>R$ {{ number_format($order->preco, 2, ',', '.') }}</td>
                    <td>{{ $order->local }}</td>
                    <td>
                        <!-- Botão de editar pedido -->
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Botão de deletar pedido -->
                        <form id="delete-form-{{ $order->id }}" action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $order->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(orderId) {
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
                    document.getElementById('delete-form-' + orderId).submit();
                }
            });
        }
    </script>
@endsection
