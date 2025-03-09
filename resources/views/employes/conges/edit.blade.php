@extends('layout.index')

@section('custom_page')
    <div class="pagetitle">
        <h1>Gestion des Congés</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Congés</a></li>
                <li class="breadcrumb-item active">Congés/Modification</li>
            </ol>
        </nav>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="Acontainer">
        @if ($conge->statut == 'Demandée')
            <div class="alert alert-warning">
                <strong>Attention!</strong> Cette demande de congé est au statut "Demandée" et ne peut plus être modifiée.
            </div>
            <a href="{{ route('conges.index') }}" class="Abtn">Retour à la liste</a>
        @else
            <form class="Aform" action="{{ route('conges.update', $conge->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="Aform-section">
                    <div class="Aform-group">
                        <label for="date_debut">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" value="{{ $dateFormats['date_debut'] }}"
                            required>
                    </div>

                    <div class="Aform-group">
                        <label for="date_fin">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" value="{{ $dateFormats['date_fin'] }}"
                            required>
                    </div>

                    <div class="Aform-group">
                        <label for="type">Type d'absence</label>
                        <select name="type" id="type" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="Congé payé" {{ $conge->type == 'Congé payé' ? 'selected' : '' }}>Congé payé
                            </option>
                            <option value="Congé sans solde" {{ $conge->type == 'Congé sans solde' ? 'selected' : '' }}>
                                Congé
                                sans solde</option>
                            <option value="Maladie" {{ $conge->type == 'Maladie' ? 'selected' : '' }}>Maladie</option>
                            <option value="Formation" {{ $conge->type == 'Formation' ? 'selected' : '' }}>Formation</option>
                            <option value="Autre" {{ $conge->type == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>

                    <div class="Aform-group">
                        <label for="motif">Motif</label>
                        <textarea name="motif" id="motif" style="max-height: 50px" placeholder="Précisez le motif de votre absence"
                            rows="4" required>{{ $conge->motif }}</textarea>
                    </div>

                    <div class="Aform-group">
                        <label for="statut">Statut</label>
                        <select name="statut" id="statut" required>
                            <option value="Planifiée" {{ $conge->statut == 'Planifiée' ? 'selected' : '' }}>Planifiée
                            </option>
                            <option value="Demandée" {{ $conge->statut == 'Demandée' ? 'selected' : '' }}>Demandée</option>
                        </select>
                    </div>

                    <button type="submit" class="Abtn edit-absence">Modifier</button>
                </div>
            </form>
        @endif
    </div>

    <style>
        .Abtn {
            background-color: #54acc4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
            text-decoration: none;
            margin-top: 10px;
        }

        .Abtn:hover {
            background-color: #e66840;
        }

        .Aform-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-warning {
            color: #8a6d3b;
            background-color: #fcf8e3;
            border-color: #faebcc;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateDebut = document.getElementById('date_debut');
            const dateFin = document.getElementById('date_fin');

            // Vérifier si les éléments existent (au cas où on est dans le mode "Demandée")
            if (dateDebut && dateFin) {
                // Mettre à jour la date minimale de fin quand la date de début change
                dateDebut.addEventListener('change', function() {
                    dateFin.min = this.value;
                    if (dateFin.value && dateFin.value < this.value) {
                        dateFin.value = this.value;
                    }
                });

                // Définir la date minimale initiale
                dateFin.min = dateDebut.value;
            }

            // Récupérer le bouton de modification s'il existe
            const editButton = document.querySelector('.edit-absence');
            if (editButton) {
                editButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Voulez-vous modifier cette demande de congé ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#54acc4',
                        cancelButtonColor: '#e66840',
                        confirmButtonText: 'Oui, modifier!',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire({
                                icon: "success",
                                title: "Demande de congé modifiée avec succès",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                });
            }
        });
    </script>
@endsection
