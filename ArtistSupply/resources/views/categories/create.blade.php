@extends('layouts.master')

@section('content')
    <h1>Criar Categoria</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories.fields') 
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@endsection


