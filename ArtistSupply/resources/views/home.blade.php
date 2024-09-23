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
                    <a href="{{ url('/pagina1') }}" class="btn btn-purple-box">
                        <i class="fas fa-home"></i> Página 1
                    </a>
                    <a href="{{ url('/pagina2') }}" class="btn btn-purple-box">
                        <i class="fas fa-user"></i> Página 2
                    </a>
                    <a href="{{ url('/pagina3') }}" class="btn btn-purple-box">
                        <i class="fas fa-cog"></i> Página 3
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
            background-color: #6f42c1; /* Tom de roxo 1 */
            color: white;
            border: none;
            width: 23%; /* Ajuste a largura conforme necessário */
            height: 100px; /* Altura dos botões */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 8px; /* Bordas levemente arredondadas */
            text-decoration: none; /* Remove underline */
        }

        .btn-purple-box:nth-child(2) {
            background-color: #5a30a1; /* Tom de roxo 2 */
        }

        .btn-purple-box:nth-child(3) {
            background-color: #4e1f8e; /* Tom de roxo 3 */
        }

        .btn-purple-box:nth-child(4) {
            background-color: #421a7a; /* Tom de roxo 4 */
        }

        .btn-purple-box:hover {
            filter: brightness(90%); /* Efeito ao passar o mouse */
        }

        @media (max-width: 768px) {
            .btn-purple-box {
                width: 100%; /* Botões ocupam a largura total em telas menores */
                margin-bottom: 10px; /* Espaçamento entre botões */
            }
        }
    </style>
@endsection
