@extends('layout.index')

@section('custom_page')
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary);
            color: var(--light);
            padding: 1rem 1.5rem;
            font-size: 1.2rem;
            font-weight: bold;
            border-bottom: none;
        }

        .card-body {
            padding: 2rem;
            background-color: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            padding: 0.8rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(47, 119, 7, 0.25);
        }

        .btn-submit {
            background-color: var(--blue);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #54acc4;
            transform: translateY(-2px);
            color: white;
        }

        .alert {
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: none;
        }

        .alert-success {
            background-color: rgba(47, 119, 7, 0.1);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        .invalid-feedback {
            color: var(--orange);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .form-control.is-invalid {
            border-color: var(--orange);
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="profile-container">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-grid">
            <!-- Modifier le profil -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-circle me-2"></i>
                    Modifier le profil
                </div>
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">
                                <i class="bi bi-person me-2"></i>Nom
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name"
                                 {{-- value="{{ old('name', Auth::user()->name) }}" --}}
                                 >
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="bi bi-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" 
                                {{-- value="{{ old('email', Auth::user()->email) }}" --}}
                                >
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-check2 me-2"></i>Mettre à jour le profil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Changer le mot de passe -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-key me-2"></i>
                    Changer le mot de passe
                </div>
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">
                                <i class="bi bi-shield-lock me-2"></i>Mot de passe actuel
                            </label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password">
                            @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password">
                                <i class="bi bi-shield-plus me-2"></i>Nouveau mot de passe
                            </label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password" name="new_password">
                            @error('new_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">
                                <i class="bi bi-shield-check me-2"></i>Confirmer le nouveau mot de passe
                            </label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-check2 me-2"></i>Changer le mot de passe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Fonction pour le formulaire de mise à jour du profil
        document.querySelector('form[action="#"]').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Voulez-vous vraiment mettre à jour votre profil?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2f7707',
                cancelButtonColor: '#b50505',
                confirmButtonText: 'Oui, mettre à jour!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Fonction pour le formulaire de changement de mot de passe
        document.querySelector('form[action="#"]').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Voulez-vous vraiment changer votre mot de passe?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2f7707',
                cancelButtonColor: '#b50505',
                confirmButtonText: 'Oui, changer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Si un message de succès existe, afficher une alerte sweet
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2f7707'
            });
        @endif
    </script>
@endsection
