@extends('layout.index')

@section('custom_page')
    {{-- Ajoutez le lien vers votre CSS personnalisé --}}
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <div class="dashboard-container">
        <!-- Section des statistiques -->
        <div class="grid-2">
            <div class="stat-card">
                <h2 class="text-lg font-semibold mb-4">Répartition des demandes</h2>
                <div class="chart-container">
                    <canvas id="chartDemandes"></canvas>
                </div>
            </div>
            <div class="stat-card">
                <h2 class="text-lg font-semibold mb-4">Évolution des demandes</h2>
                <div class="chart-container">
                    <canvas id="chartEvolution"></canvas>
                </div>
            </div>
        </div>

        <!-- Tableau des demandes récentes -->
        <div class="table-container">
            <h2 class="text-lg font-semibold mb-4">Liste des demandes récentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Fonction</th>
                        <th>Solde</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Doe</td>
                        <td>John</td>
                        <td>Secretaire</td>
                        <td class="solde-warning">30</td>
                        <td>
                            <button class="btn-view">Voir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Vos scripts Chart.js restent identiques
        var ctx = document.getElementById('chartDemandes').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Acceptées', 'Refusées', 'En attente'],
                datasets: [{
                    data: [10, 5, 7],
                    backgroundColor: ['#54acc4', '#e66840', '#gray']
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true
            }
        });

        var ctx2 = document.getElementById('chartEvolution').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai'],
                datasets: [{
                    label: 'Demandes traitées',
                    data: [5, 10, 15, 8, 12],
                    borderColor: '#e66840',
                    fill: false
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true
            }
        });
    </script>
@endsection