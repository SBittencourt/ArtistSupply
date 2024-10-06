@extends('layouts.master')

@section('content')
    <h1>Criar Evento</h1>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        @include('eventos.fields')
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@endsection
