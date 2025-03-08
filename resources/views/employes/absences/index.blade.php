@extends('layout.index')

@section('custom_page')
    <div class="horizontalH">
        <div class="pagetitle">
            <h1>Gestion des Absences</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Absences</a></li>
                    <li class="breadcrumb-item active">Absences/liste</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('absences.create') }}" class="addAcBtn">Nouvelle demande d'absence</a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($absences->isEmpty())
        <div class="empty-list-alert">
            <span class="alert-message">Aucune demande d'absence n'a été enregistrée.</span>
            <span class="close-btn">&times;</span>
        </div>
    @else
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Type</th>
                <th>Période</th>
                <th>Durée</th>
                <th>Motif</th>
                <th>Statut</th>
                <th width="280px">Actions</th>
            </tr>
            @foreach ($absences as $absence)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $absence->type }}</td>
                    <td>
                        Du {{ date('d/m/Y', strtotime($absence->date_debut)) }}
                        au {{ date('d/m/Y', strtotime($absence->date_fin)) }}
                        <br>
                        <small class="text-muted">Demande créée le {{ $absence->created_at->format('d/m/Y') }}</small>
                    </td>
                    <td>{{ $absence->duree }} jour(s)</td>
                    <td>{{ \Illuminate\Support\Str::limit($absence->motif, 50, '...') }}</td>
                    <td>
                        <span class="badge rounded-pill {{ $absence->statut == 'Demandée' ? 'bg-success' : 
                            ($absence->statut == 'Planifiée' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $absence->statut }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('absences.destroy', $absence->id) }}" method="POST"
                            class="actions_crud_form">
                            <a class="btn btn-info icon" href="{{ route('absences.show', $absence->id) }}"
                               style="background-color: #54acc4; border-color: #54acc4;">
                                <ion-icon name="eye-sharp"></ion-icon>voir
                            </a>
                            <a class="btn btn-primary icon" href="{{ route('absences.edit', $absence->id) }}"
                               style="background-color: #54acc4; border-color: #54acc4;">
                                <ion-icon name="pencil-sharp"></ion-icon>Editer
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger icon delete-absence"
                                    style="background-color: #e66840; border-color: #e66840;">
                                <ion-icon name="trash-sharp"></ion-icon>Supp.
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $absences->withQueryString()->links('pagination::bootstrap-5') !!}
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-absence');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Voulez-vous réellement supprimer cette absence ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#54acc4',
                        cancelButtonColor: '#e66840',
                        confirmButtonText: 'Oui, Supprimer!',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire({
                                icon: "success",
                                title: "Demande d'absence supprimée avec succès",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                });
            });
        });

        document.querySelector('.close-btn')?.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    </script>

    <style>
        .badge {
            padding: 8px 12px;
            font-size: 0.9em;
        }
        
        .btn.icon {
            margin: 0 5px;
        }

        .actions_crud_form {
            display: flex;
            gap: 5px;
        }
    </style>
@endsection