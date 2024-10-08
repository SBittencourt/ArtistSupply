@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-4" style="padding-top: 2vh">
                <h1>Bem-vindo de volta, {{ $user->name }}!</h1>
            </div> 
            <br>
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    <a href="{{ url('/eventos') }}" class="btn btn-purple">
                        <i class="fas fa-calendar"></i> Eventos
                    </a>
                    <a href="{{ url('/categorias') }}" class="btn btn-purple">
                        <i class="fas fa-list"></i> Categorias
                    </a>
                    <a href="{{ url('/estoque') }}" class="btn btn-purple">
                        <i class="fas fa-boxes"></i> Estoque
                    </a>
                    <a href="{{ url('https://docs.google.com/spreadsheets/u/0/d/1m0L1dx60k05oz-6jqm8h9NDiqRTBc9gOe5X14t2aYw0/htmlview') }}" class="btn btn-purple">
                        <i class="fas fa-box"></i> Fornecedores
                    </a>
                </div>

            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Produtos recentemente adicionados</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Quantia</th>
                            <th>Preço</th>
                            <th>Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products->take(3) as $product)
                            <tr>
                                <td>{{ $product->nome }}</td>
                                <td>{{ $product->quantia }}</td>
                                <td>{{ number_format($product->preco, 2, ',', '.') }}</td>
                                <td>{{ $product->local }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-12 text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Ver mais Produtos</a>
            </div>

            <div class="col-md-12 mt-5">
                <h3>Eventos recentemente adicionados</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events->take(3) as $event)
                            <tr>
                                <td>{{ $event->nome }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->data_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->data_fim)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('events.index') }}" class="btn btn-primary">Ver mais Eventos</a>
        </div>
    </div>
@endsection
