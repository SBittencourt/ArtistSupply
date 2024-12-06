@extends('layouts.master')

@section('content')
<div class="container my-4">
    <h1 class="mb-4 text-center">Relatório Geral de Eventos</h1>

    <!-- Gráficos -->
    <div class="row">
        <!-- Gráfico de Barras: Quantidade Vendida -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-dark text-white">
                    <h5>Quantidade Vendida por Produto</h5>
                </div>
                <div class="card-body">
                    <canvas id="quantityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Barras: Valor Vendido -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-dark text-white">
                    <h5>Valor Vendido por Produto</h5>
                </div>
                <div class="card-body">
                    <canvas id="valueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Pizza: Categoria de Produto -->
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-dark text-white">
                    <h5>Valor Vendido por Categoria</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Linha: Vendas Mensais -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-dark text-white">
                    <h5>Valor Vendido por Mês</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesOverTimeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Produtos Vendidos -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-dark text-white">
                    <h5>Detalhes dos Produtos Vendidos</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Produto</th>
                                <th>Categoria</th>
                                <th>Quantidade Vendida</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soldProducts as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>{{ $product->total_quantity }}</td>
                                    <td>R$ {{ number_format($product->total_value, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData);
        const monthsData = @json($monthsData);

        // Gráfico de Quantidade Vendida
        new Chart(document.getElementById('quantityChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: Object.keys(chartData.quantities),
                datasets: [{
                    label: 'Quantidade Vendida',
                    data: Object.values(chartData.quantities),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Gráfico de Valor Vendido
        new Chart(document.getElementById('valueChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: Object.keys(chartData.values),
                datasets: [{
                    label: 'Valor Vendido (R$)',
                    data: Object.values(chartData.values),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Gráfico de Pizza: Categoria (Com cores de maior contraste)
        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(chartData.categories),
                datasets: [{
                    data: Object.values(chartData.categories),
                    backgroundColor: [
                        '#FF5733',  // Laranja vibrante
                        '#C70039',  // Vermelho escuro
                        '#900C3F',  // Vinho
                        '#581845',  // Roxo escuro
                        '#1C1C1C',  // Preto
                        '#8E44AD'   // Roxo médio
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                aspectRatio: 1.5 // Reduzindo o gráfico de pizza para ajustá-lo ao tamanho do gráfico de linha
            }
        });

        // Gráfico de Linha: Vendas Mensais
        new Chart(document.getElementById('salesOverTimeChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: Object.keys(monthsData),
                datasets: [{
                    label: 'Valor Total Vendido (R$)',
                    data: Object.values(monthsData),
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
