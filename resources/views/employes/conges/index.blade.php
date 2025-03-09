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
        @auth
            @if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
                <div></div>
            @else
                <a href="{{ route('conges.create') }}" class="addAcBtn">Nouvelle demande de congé</a>
            @endif
        @endauth
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
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
                @if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
                    <th>Employé</th>
                    <th>Fonction</th>
                    <th>Rôle</th>
                @endif
                <th>Type</th>
                <th>Période</th>
                <th>Durée</th>
                <th>Motif</th>
                <th>Statut</th>
                <th width="290px">Actions</th>
            </tr>
            @php $counter = $i; @endphp
            @foreach ($conges as $conge)
                {{-- Masquer les demandes "Planifiée" pour les admins --}}
                @if ((Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2) && $conge->statut == 'Planifiée')
                    @continue
                @endif
                <tr>
                    <td>{{ ++$counter }}</td>
                    @if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
                        <td>{{ $conge->employe->nom }} {{ $conge->employe->prenom }}</td>
                        <td>{{ $conge->employe->fonction }}</td>
                        <td>{{ $conge->employe->role }}</td>
                    @endif
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
                    <td>
                        <div class="actions_crud_form">
                            <a class="btn btn-info icon" href="{{ route('conges.show', $conge->id) }}"
                                style="background-color: #54acc4; border-color: #54acc4;">
                                <ion-icon name="eye-sharp"></ion-icon>Voir
                            </a>

                            @if (Auth::user()->is_admin == 1)
                                <!-- Admin niveau 1 (probablement chef de service) -->
                                <form action="{{ route('conges.approuver', $conge->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success icon"
                                        style="background-color: #28a745; border-color: #28a745;">
                                        <ion-icon name="checkmark-sharp"></ion-icon>Accepter
                                    </button>
                                </form>

                                <form action="{{ route('conges.rejeter', $conge->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger icon"
                                        style="background-color: #dc3545; border-color: #dc3545;">
                                        <ion-icon name="close-sharp"></ion-icon>Rejeter
                                    </button>
                                </form>
                            @elseif (Auth::user()->is_admin == 2)
                                <!-- Admin niveau 2 (probablement directeur ou GRH) -->
                                <a class="btn btn-primary icon" href="{{ route('conges.edit', $conge->id) }}"
                                    style="background-color: #54acc4; border-color: #54acc4;">
                                    <ion-icon name="pencil-sharp"></ion-icon>Editer
                                </a>

                                <form action="{{ route('conges.approuver', $conge->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success icon"
                                        style="background-color: #28a745; border-color: #28a745;">
                                        <ion-icon name="checkmark-sharp"></ion-icon>Accepter
                                    </button>
                                </form>

                                <form action="{{ route('conges.rejeter', $conge->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger icon"
                                        style="background-color: #dc3545; border-color: #dc3545;">
                                        <ion-icon name="close-sharp"></ion-icon>Rejeter
                                    </button>
                                </form>
                            @else
                                <!-- Utilisateur normal (employé) -->
                                @if ($conge->statut == 'Acceptée')
                                    <div></div>
                                @elseif ($conge->statut != 'Demandée')
                                    <a class="btn btn-primary icon" href="{{ route('conges.edit', $conge->id) }}"
                                        style="background-color: #54acc4; border-color: #54acc4;">
                                        <ion-icon name="pencil-sharp"></ion-icon>Editer
                                    </a>
                                @endif

                                <form action="{{ route('conges.destroy', $conge->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger icon delete-conge"
                                        style="background-color: #e66840; border-color: #e66840;">
                                        <ion-icon name="trash-sharp"></ion-icon>Supp.
                                    </button>
                                </form>
                            @endif
                        </div>
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
            padding: 5px 10px;
        }

        .actions_crud_form {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
    </style>
@endsection
