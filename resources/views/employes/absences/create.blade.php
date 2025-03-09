@extends('layout.index')

@section('custom_page')
    <div class="pagetitle">
        <h1>Gestion des Absences</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Absences</a></li>
                <li class="breadcrumb-item active">Absences/Nouvelle Demande</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

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
        <form class="Aform" action="{{ route('absences.store') }}" method="POST">
            @csrf
            <!-- Section pour le formulaire -->
            <div class="Aform-section">
                <div class="Aform-group">
                    <label for="date_debut">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" required>
                </div>

                <div class="Aform-group">
                    <label for="date_fin">Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin" required>
                </div>

                <div class="Aform-group">
                    <label for="type">Type d'absence</label>
                    <select name="type" id="type" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="Congé payé">Congé payé</option>
                        <option value="Congé sans solde">Congé sans solde</option>
                        <option value="Maladie">Maladie</option>
                        <option value="Formation">Formation</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>

                <div class="Aform-group">
                    <label for="motif">Motif</label>
                    <textarea name="motif" id="motif" placeholder="Précisez le motif de votre absence" rows="4" required></textarea>
                </div>

                <input type="hidden" name="statut" value="Planifiée">
                
                <button type="submit" class="Abtn add-absence">Soumettre la demande</button>
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
            const submitButton = document.querySelector('.add-absence');
            const dateDebut = document.getElementById('date_debut');
            const dateFin = document.getElementById('date_fin');

            // Définir la date minimale à aujourd'hui
            const today = new Date().toISOString().split('T')[0];
            dateDebut.min = today;

            // Mettre à jour la date minimale de fin quand la date de début change
            dateDebut.addEventListener('change', function() {
                dateFin.min = this.value;
                if (dateFin.value && dateFin.value < this.value) {
                    dateFin.value = this.value;
                }
            });

            submitButton.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Voulez-vous soumettre cette demande d\'absence ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#54acc4',
                    cancelButtonColor: '#e66840',
                    confirmButtonText: 'Oui, soumettre!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            icon: "success",
                            title: "Demande d'absence soumise avec succès",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });
        });
    </script>
@endsection