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
            
            @php
                // Filtrage des congés similaire à celui de paste.txt
                $filteredConges = $conges->filter(function ($conge) {
                    // Si l'utilisateur est admin ou responsable, on filtre par service
                    if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2) {
                        // Exclure les congés "Planifiée"
                        if ($conge->statut == 'Planifiée') {
                            return false;
                        }
                        // Filtrer par service
                        return Auth::user()->service_id == $conge->employe->service_id;
                    }
                    // Pour les employés réguliers, on affiche tous leurs congés
                    return true;
                });
                
                // Filtrer uniquement les demandes en attente
                $recentDemandes = $filteredConges->where('statut', 'Demandée')->take(2);
            @endphp
            
            @if ($recentDemandes->isEmpty())
                <div class="info-message" style="background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 5px; padding: 15px; margin-bottom: 20px; color: #5a5c69; text-align: center;">
                    <span>Aucune demande en attente n'a été enregistrée dans votre service.</span>
                </div>
            @else
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Employé</th>
                        <th>Fonction</th>
                        <th>Type</th>
                        <th>Période</th>
                        <th>Durée</th>
                        <th>Motif</th>
                        <th>Statut</th>
                    </tr>
                    @php $counter = 0; @endphp
                    @foreach ($recentDemandes as $conge)
                        <tr>
                            <td>{{ ++$counter }}</td>
                            <td>{{ $conge->employe->nom }} {{ $conge->employe->prenom }}</td>
                            <td>{{ $conge->employe->fonction }}</td>
                            <td>{{ $conge->type }}</td>
                            <td>
                                Du {{ date('d/m/Y', strtotime($conge->date_debut)) }}
                                au {{ date('d/m/Y', strtotime($conge->date_fin)) }}
                                <br>
                            </td>
                            <td>{{ $conge->duree }} jour(s)</td>
                            <td>{{ \Illuminate\Support\Str::limit($conge->motif, 50, '...') }}</td>
                            <td>
                                <span
                                    class="badge rounded-pill {{ $conge->statut == 'Acceptée'
                                        ? 'bg-success'
                                        : ($conge->statut == 'Rejetée'
                                            ? 'bg-danger'
                                            : ($conge->statut == 'Demandée'
                                                ? 'bg-warning'
                                                : '')) }}"
                                    style="{{ $conge->statut == 'Planifiée' ? 'background-color: #f0f0f0; color: black;' : '' }}">
                                    {{ $conge->statut }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    <script>
        // Vous pourriez également adapter vos graphiques pour qu'ils reflètent les données filtrées
        // Voici un exemple où vous pourriez passer les données filtrées à vos graphiques via PHP
        var ctx = document.getElementById('chartDemandes').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Acceptées', 'Refusées', 'En attente'],
                datasets: [{
                    data: [10, 5, 7], // Remplacer par des données filtrées
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
                    data: [5, 10, 15, 8, 12], // Remplacer par des données filtrées
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