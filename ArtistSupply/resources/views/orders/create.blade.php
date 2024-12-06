@extends('layouts.master')

@section('content')
    <h1>Criar Pedido</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        @include('orders.fields')
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@endsection
