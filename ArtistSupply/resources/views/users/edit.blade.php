@extends('layouts.master')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar</h1>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="invoice p-3 mb-3">
            <form action="{{ route('usuario.store', ['user_id' => $user->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('users.fields')
                <div class="row no-print">
                    <div class="col-12">
                        <button type="submit" class="btn btn-custom float-right" style="margin-right: 5px;">{{ trans('Salvar') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
