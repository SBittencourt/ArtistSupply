@extends('layouts.master')

@section('content')
<div class="container text-light">
    <h1 class="text-center mb-4">Evento Ativo: {{ $activeEvent->event->nome }}</h1>
    <p class="text-center">Tempo: <span id="eventTimer" class="font-weight-bold"></span></p>

    <h3 class="mt-4">Produtos</h3>
    <ul class="list-group mb-4">
        @foreach ($products as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $product->nome }}</strong> (Em estoque: <span class="badge bg-info">{{ $product->quantia }}</span>)
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-secondary me-2" onclick="updateQuantity({{ $product->id }}, -1)">-</button>
                    <input type="number" id="quantity-{{ $product->id }}" name="quantity" min="1" max="{{ $product->quantia }}" value="1" style="width: 50px;" class="text-center mx-2" onchange="validateQuantity({{ $product->id }})">
                    <button class="btn btn-secondary" onclick="updateQuantity({{ $product->id }}, 1)">+</button>
                    <form action="{{ route('activeEvents.sell', [$activeEvent->id, $product->id]) }}" method="POST" class="ms-3" onsubmit="return validateForm({{ $product->id }}, event)">
                        @csrf
                        <input type="hidden" name="quantity" id="quantity-hidden-{{ $product->id }}" value="1">
                        <button type="submit" class="btn btn-success">Vender</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <h3 class="mt-4">Resumo</h3>
    <div class="summary-card p-3 mb-4">
        <p><strong>Total Vendido:</strong> R$ {{ $activeEvent->total_gross }}</p>
        <p><strong>Total de Gastos:</strong> R$ {{ $activeEvent->total_expense }}</p>
        <p><strong>Lucro:</strong> R$ {{ $activeEvent->total_profit }}</p>
    </div>

    <div class="text-center">
        <button class="btn btn-danger" id="finalizeButton">Finalizar Evento</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function startTimer() {
    const startTime = new Date("{{ $activeEvent->start_time }}").getTime(); // Usamos getTime() para obter o timestamp
    console.log("Start Time:", startTime); // Log para verificar o tempo de início
    const timerElement = document.getElementById('eventTimer');

    function updateTimer() {
        const currentTime = new Date().getTime(); // Usamos getTime() para obter o timestamp atual
        const elapsed = currentTime - startTime; // Calcula o tempo decorrido em milissegundos
        console.log("Current Time:", currentTime); // Log para verificar o tempo atual
        console.log("Elapsed Time:", elapsed); // Log para verificar o tempo decorrido

        if (elapsed < 0) {
            timerElement.innerText = "00:00:00"; // Se o tempo for negativo, exibe 0
            return;
        }

        const hours = Math.floor(elapsed / 3600000);
        const minutes = Math.floor((elapsed % 3600000) / 60000);
        const seconds = Math.floor((elapsed % 60000) / 1000);

        timerElement.innerText = 
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');
    }

    setInterval(updateTimer, 1000);
}



    function updateQuantity(productId, change) {
        const quantityInput = document.getElementById('quantity-' + productId);
        let currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity + change >= 1 && currentQuantity + change <= parseInt(quantityInput.max)) {
            quantityInput.value = currentQuantity + change;
            document.getElementById('quantity-hidden-' + productId).value = quantityInput.value; // Atualiza o campo oculto
        }
    }

    function validateQuantity(productId) {
        const quantityInput = document.getElementById('quantity-' + productId);
        const maxQuantity = parseInt(quantityInput.max);

        // Ajusta para que não exceda o máximo
        if (parseInt(quantityInput.value) > maxQuantity) {
            quantityInput.value = maxQuantity;
        } else if (parseInt(quantityInput.value) < 1) {
            quantityInput.value = 1;
        }
        document.getElementById('quantity-hidden-' + productId).value = quantityInput.value; // Atualiza o campo oculto
    }

    function validateForm(productId, event) {
        const quantityInput = document.getElementById('quantity-' + productId);
        if (parseInt(quantityInput.value) < 1) {
            event.preventDefault(); // Impede o envio do formulário
            alert('A quantidade deve ser pelo menos 1.');
            return false;
        }
        return true; // Permite o envio do formulário
    }

    document.getElementById('finalizeButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Deseja realmente finalizar o evento?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, finalizar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Substitua o método abaixo pela chamada ao endpoint de finalização
                document.querySelector('form[action="{{ route('activeEvents.end', $activeEvent->id) }}"]').submit();
            }
        });
    });

    window.onload = startTimer;
</script>

<style>
    body {
        background-color: #343a40; /* Cor de fundo escura */
    }
    .summary-card {
        background-color: #495057; 
        border: 1px solid #6c757d; 
        border-radius: 0.5rem;
        color: #f8f9fa;
    }
    .list-group-item {
        background-color: #495057;
        border: 1px solid #6c757d;
    }
    .btn-secondary {
        width: 40px; /* Define a largura dos botões */
    }
    .text-center {
        text-align: center;
    }
    .font-weight-bold {
        font-weight: bold;
    }
</style>
@endsection
