<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>GCA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    {{-- sweet alert links --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- ionicons installation --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    {{-- font awesome icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    {{-- For Armand --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.blade.php" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block">GCA IBAM</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->
        @auth
            @if (Auth::user()->is_admin == 1)
                <div></div>
            @else
                <div class="solde">Solde de demande restant: 05</div>
            @endif
        @endauth

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" action="#">
                <input type="text" name="query" placeholder="Tapez ici pour rechercher"
                    title="Enter search keyword">

            </form>
        </div>
        <!-- End Search Bar -->

        {{-- bell icon --}}
        <div class="d-flex align-items-center justify-content-between mx-3"> 
            <i class="bi bi-bell toggle-sidebar-btn"></i>
        </div>


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profil.jpeg') }}" alt="Profile" class="rounded-circle">
                        @auth
                            <span
                                class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nom . ' ' . Auth::user()->prenom }}</span>
                        @endauth
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            @auth
                                @if (Auth::user()->is_admin == 1)
                                    <span>Admin</span>
                                    <span
                                        class="d-none d-md-block  ps-2">{{ Auth::user()->nom . ' ' . Auth::user()->prenom }}</span>
                                @else
                                    <span>Employe</span>
                                    <span
                                        class="d-none d-md-block  ps-2">{{ Auth::user()->nom . ' ' . Auth::user()->prenom }}</span>
                                @endif
                            @endauth
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                                <i class="bi bi-person"></i>
                                <span>Mon profil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center confirm-logout"
                                href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Se déconnecter</span>
                            </a>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="{{ url('/dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Tableau de bord</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#request-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-file-text"></i><span>Liste des demandes</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="request-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('conges.index') }}">
                            <i class="bi bi-circle"></i><span>Demandes de congés</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('absences.index') }}">
                            <i class="bi bi-circle"></i><span>Demandes d'absence</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Request list -->

            @auth
                @if (Auth::user()->is_admin == 1)
                    {{-- if is admin display --}}
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('employes.index') }}">
                            <i class="bi bi-list-check"></i><span>Liste des employés</span>
                        </a>
                    </li><!-- End Employe List Page Nav -->
                @else
                    <div></div>
                @endif
            @endauth


            {{-- ----------------------------------------Settings-------------------------------------- --}}

            <li class="nav-heading">Paramètres</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('profile') }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil</span>
                </a>
            </li><!-- End Profile Page Nav -->
        </ul>

        <div class="sidebar-footer">
            <p>&copy; 2024 <br>
                <strong>GCA</strong> <br>
                Tous droits réservés
            </p>
        </div>
    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        {{-- custom_page --}}
        <div class="center">
            @yield('custom_page')
        </div>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>GCA</span></strong>. Tous droits réservés
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- sweet alerte --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutLinks = document.querySelectorAll('.confirm-logout');

            logoutLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const href = this.getAttribute('href');

                    Swal.fire({
                        title: 'Voulez-vous réellement vous déconnecter?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#54acc4',
                        cancelButtonColor: '#e66840',
                        confirmButtonText: 'Oui, Se déconnecter',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = href;
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>
