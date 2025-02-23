@extends('layout.index')

@section('custom_page')
    <div class="horizontalH">
        <div class="pagetitle">
            <h1>Gestion des Congés</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Congés</a></li>
                    <li class="breadcrumb-item active">Congés/liste</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('conges.create') }}" class="addAcBtn">Nouvelle demande de congé</a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($conges->isEmpty())
        <div class="empty-list-alert">
            <span class="alert-message">Aucune demande de congé n'a été enregistrée.</span>
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
            @foreach ($conges as $conge)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $conge->type }}</td>
                    <td>
                        Du {{ date('d/m/Y', strtotime($conge->date_debut)) }}
                        au {{ date('d/m/Y', strtotime($conge->date_fin)) }}
                        <br>
                        <small class="text-muted">Demande créée le {{ $conge->created_at->format('d/m/Y') }}</small>
                    </td>
                    <td>{{ $conge->duree }} jour(s)</td>
                    <td>{{ \Illuminate\Support\Str::limit($conge->motif, 50, '...') }}</td>
                    <td>
                        <span class="badge rounded-pill {{ $conge->statut == 'Approuvée' ? 'bg-success' : 
                            ($conge->statut == 'Refusée' ? 'bg-danger' : 'bg-warning') }}">
                            {{ $conge->statut }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('conges.destroy', $conge->id) }}" method="POST"
                            class="actions_crud_form">
                            <a class="btn btn-info icon" href="{{ route('conges.show', $conge->id) }}"
                               style="background-color: #54acc4; border-color: #54acc4;">
                                <ion-icon name="eye-sharp"></ion-icon>voir
                            </a>
                            <a class="btn btn-primary icon" href="{{ route('conges.edit', $conge->id) }}"
                               style="background-color: #54acc4; border-color: #54acc4;">
                                <ion-icon name="pencil-sharp"></ion-icon>Editer
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger icon delete-conge"
                                    style="background-color: #e66840; border-color: #e66840;">
                                <ion-icon name="trash-sharp"></ion-icon>Supp.
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $conges->withQueryString()->links('pagination::bootstrap-5') !!}
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-conge');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Voulez-vous réellement supprimer ce conge ?',
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
                                title: "demande de congé supprimé avec succès",
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