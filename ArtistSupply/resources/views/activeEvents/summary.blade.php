@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="my-4">Resumo do Evento: {{ $activeEvent->event->nome }}</h1>

    <h3 class="my-4">Informações do Evento</h3>
    <p><strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($activeEvent->start_time)->format('d/m/Y H:i') }}</p>
    <p><strong>Data de Término:</strong> {{ $activeEvent->end_time ? \Carbon\Carbon::parse($activeEvent->end_time)->format('d/m/Y H:i') : 'Ainda em andamento' }}</p>
    <p><strong>Duração:</strong> 
        @if($activeEvent->end_time)
            @php
                $totalSeconds = strtotime($activeEvent->end_time) - strtotime($activeEvent->start_time);
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);
            @endphp
            {{ $hours }} horas e {{ $minutes }} minutos
        @else
            N/A
        @endif
    </p>

    <p><strong>Total de Vendas:</strong> {{ $activeEvent->products->sum('pivot.quantity_sold') }}</p>
    <p><strong>Total Bruto:</strong> R$ {{ number_format($activeEvent->total_gross, 2) }}</p>
    <p><strong>Total Despesas:</strong> R$ {{ number_format($activeEvent->total_expense, 2) }}</p>
    <p><strong>Lucro Total:</strong> R$ {{ number_format($activeEvent->total_gross - $activeEvent->total_expense, 2) }}</p> 

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

    <form action="{{ route('events.index') }}" method="GET" class="mt-4">
        <button type="submit" class="btn btn-secondary">Voltar para a Lista de Eventos</button>
    </form>
</div>
@endsection
