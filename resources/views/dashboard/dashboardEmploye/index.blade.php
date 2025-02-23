@extends('layout.index')

@section('custom_page')
    <div class="pagetitle">
        <h1>Tableau de Bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.blade.php">Accueil</a></li>
                <li class="breadcrumb-item active">Tableau de Bord</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <!-- Absence Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card" style="border-color: #54acc4;">
                            <div class="card-body">
                                <h5 class="card-title">Nombre d'absences restant</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" 
                                         style="background-color: rgba(84, 172, 196, 0.2); color: #54acc4;">
                                         <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>05</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conges Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card" style="border-color: #e66840;">
                            <div class="card-body">
                                <h5 class="card-title">Nombre de congés restant</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                         style="background-color: rgba(230, 104, 64, 0.2); color: #e66840;">
                                         <i class="bi bi-calendar-x"></i> 
                                    </div>
                                    <div class="ps-3">
                                        <h6>05</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filtrer</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                                    <li><a class="dropdown-item" href="#">Ce mois</a></li>
                                    <li><a class="dropdown-item" href="#">Cette année</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Rapport<span>/Statistiques</span></h5>

                                <div id="reportsChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#reportsChart"), {
                                            series: [{
                                                name: 'Absences',
                                                data: [10, 15, 8, 20, 12, 18, 15]
                                            }, {
                                                name: 'Congés',
                                                data: [5, 8, 12, 8, 10, 7, 9]
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'area',
                                                toolbar: {
                                                    show: false
                                                },
                                            },
                                            markers: {
                                                size: 4
                                            },
                                            colors: ['#54acc4', '#e66840'],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                    shadeIntensity: 1,
                                                    opacityFrom: 0.3,
                                                    opacityTo: 0.4,
                                                    stops: [0, 90, 100]
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                curve: 'smooth',
                                                width: 2
                                            },
                                            xaxis: {
                                                type: 'datetime',
                                                categories: [
                                                    '2024-01-01',
                                                    '2024-02-01',
                                                    '2024-03-01',
                                                    '2024-04-01',
                                                    '2024-05-01',
                                                    '2024-06-01',
                                                    '2024-07-01'
                                                ]
                                            },
                                            tooltip: {
                                                x: {
                                                    format: 'dd/MM/yy'
                                                },
                                            }
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection