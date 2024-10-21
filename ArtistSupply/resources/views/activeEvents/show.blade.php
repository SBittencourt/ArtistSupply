@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="my-4">Evento Ativo: {{ $activeEvent->event->nome }}</h1>
    <p><strong>Início:</strong> {{ $activeEvent->start_time }}</p>
    <p><strong>Total Bruto:</strong> R$ {{ number_format($activeEvent->total_gross, 2) }}</p>
    <p><strong>Total Despesas:</strong> R$ {{ number_format($activeEvent->total_expense, 2) }}</p>
    @if(isset($totalProfit))
        <p><strong>Lucro Total:</strong> R$ {{ number_format($totalProfit, 2) }}</p> 
    @endif

    <h3 class="my-4">Produtos Vendidos</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade Vendida</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($soldProducts))
                @foreach($soldProducts as $product)
                    <tr>
                        <td>{{ $product->nome }}</td>
                        <td>{{ $product->pivot->quantity_sold }}</td>
                        <td>R$ {{ number_format($product->pivot->total_value, 2) }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3 class="my-4">Adicionar Venda</h3>
    @if(isset($products) && $products->count() > 0)
        <form action="" method="POST" id="sellForm" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="productSelect">Selecione um Produto:</label>
                <select name="product_id" id="productSelect" class="form-control" onchange="updateFormAction(this)">
                    <option value="">Selecione um produto</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantityInput">Quantidade:</label>
                <input type="number" name="quantity" id="quantityInput" class="form-control" placeholder="Quantidade" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Venda</button>
        </form>
    @endif

    <h3 class="my-4">Adicionar Despesa</h3>
    <form action="{{ route('activeEvents.addExpense', $activeEvent->id) }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="expenseInput">Valor da Despesa:</label>
            <input type="number" name="expense" id="expenseInput" class="form-control" placeholder="Valor da Despesa" required>
        </div>
        <button type="submit" class="btn btn-danger">Adicionar Despesa</button>
    </form>

    <form action="{{ route('activeEvents.end', $activeEvent->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger mt-2">Finalizar Evento</button>
    </form>
</div>

<script>
    function updateFormAction(select) {
        const selectedValue = select.value;
        const form = document.getElementById('sellForm');

        if (selectedValue) {
            form.action = "{{ route('activeEvents.sell', ['activeEventId' => '__activeEventId__', 'productId' => '__productId__']) }}".replace('__activeEventId__', '{{ $activeEvent->id }}').replace('__productId__', selectedValue);
        } else {
            form.action = '';
        }
    }
</script>
@endsection
