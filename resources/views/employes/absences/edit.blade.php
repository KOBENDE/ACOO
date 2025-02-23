@extends('layout.index')

@section('custom_page')
    <div class="pagetitle">
        <h1>Gestion des Absences</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Absences</a></li>
                <li class="breadcrumb-item active">Absences/Modification</li>
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
        <form class="Aform" action="{{ route('absences.update', $absence->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="Aform-section">
                <div class="Aform-group">
                    <label for="date_debut">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" value="{{ $absence->date_debut }}" required>
                </div>

                <div class="Aform-group">
                    <label for="date_fin">Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin" value="{{ $absence->date_fin }}" required>
                </div>

                <div class="Aform-group">
                    <label for="type">Type d'absence</label>
                    <select name="type" id="type" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="Congé payé" {{ $absence->type == 'Congé payé' ? 'selected' : '' }}>Congé payé</option>
                        <option value="Congé sans solde" {{ $absence->type == 'Congé sans solde' ? 'selected' : '' }}>Congé sans solde</option>
                        <option value="Maladie" {{ $absence->type == 'Maladie' ? 'selected' : '' }}>Maladie</option>
                        <option value="Formation" {{ $absence->type == 'Formation' ? 'selected' : '' }}>Formation</option>
                        <option value="Autre" {{ $absence->type == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div class="Aform-group">
                    <label for="motif">Motif</label>
                    <textarea name="motif" id="motif" placeholder="Précisez le motif de votre absence" rows="4" required>{{ $absence->motif }}</textarea>
                </div>

                <div class="Aform-group">
                    <label for="statut">Statut</label>
                    <select name="statut" id="statut" required>
                        <option value="En attente" {{ $absence->statut == 'En attente' ? 'selected' : '' }}>Planifiée</option>
                        <option value="Approuvée" {{ $absence->statut == 'Approuvée' ? 'selected' : '' }}>Demandée</option>
                    </select>
                </div>

                <button type="submit" class="Abtn edit-absence">Modifier</button>
            </div>
        </form>
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.querySelector('.edit-absence');
            const dateDebut = document.getElementById('date_debut');
            const dateFin = document.getElementById('date_fin');

            // Mettre à jour la date minimale de fin quand la date de début change
            dateDebut.addEventListener('change', function() {
                dateFin.min = this.value;
                if (dateFin.value && dateFin.value < this.value) {
                    dateFin.value = this.value;
                }
            });

            editButton.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Voulez-vous modifier cette demande d\'absence ?',
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
                            title: "Demande d'absence modifiée avec succès",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });
        });
    </script>
@endsection