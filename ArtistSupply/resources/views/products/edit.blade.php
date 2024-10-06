@extends('layouts.master')

@section('content')
    <h1>Editar Produto</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('products.fields', ['categories' => $categories])
        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
    </form>
@endsection
