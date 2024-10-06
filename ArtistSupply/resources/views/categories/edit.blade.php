@extends('layouts.master')

@section('content')
    <h1>Editar Categoria</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categories.fields') 
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection

