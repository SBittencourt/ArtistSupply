@extends('layouts.master')

@section('content')
    <h1>Criar Produto</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        @include('products.fields', ['categories' => $categories])
        <button type="submit" class="btn btn-primary">Criar Produto</button>
    </form>
@endsection
