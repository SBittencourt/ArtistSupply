@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-4" style="padding-top: 2vh">
                <h1>Bem-vindo de volta!</h1>
            </div>
            <br>
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <a href="{{ url('/eventos') }}" class="btn btn-purple-box">
                        <i class="fas fa-home"></i> Eventos
                    </a>
                    <a href="{{ url('/relatorios') }}" class="btn btn-purple-box">
                        <i class="fas fa-user"></i> Relatórios
                    </a>
                    <a href="{{ url('/estoque') }}" class="btn btn-purple-box">
                        <i class="fas fa-cog"></i> Estoque
                    </a>
                    <a href="{{ url('/pagina4') }}" class="btn btn-purple-box">
                        <i class="fas fa-sign-out-alt"></i> Página 4
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .btn-purple-box {
            background-color: #6f42c1; 
            color: white;
            border: none;
            width: 23%; 
            height: 100px; 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 8px; 
            text-decoration: none; 
        }

        .btn-purple-box:nth-child(2) {
            background-color: #5a30a1; 
        }

        .btn-purple-box:nth-child(3) {
            background-color: #4e1f8e; 
        }

        .btn-purple-box:nth-child(4) {
            background-color: #421a7a; 
        }

        .btn-purple-box:hover {
            filter: brightness(90%); 
        }

        @media (max-width: 768px) {
            .btn-purple-box {
                width: 100%; 
                margin-bottom: 10px; 
            }
        }
    </style>
@endsection
