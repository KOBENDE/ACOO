@extends('layout.index')

@section('custom_page')
    <div class="pagetitle">
        <h1>Gestion des Absences</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Absences</a></li>
                <li class="breadcrumb-item active">Absences/Détails</li>
            </ol>
        </nav>
    </div>

    <div class="absence-card">
        <div class="absence-content">
            <div class="status-badge {{ $absence->statut == 'Approuvée' ? 'approved' : 
                ($absence->statut == 'Refusée' ? 'rejected' : 'pending') }}">
                {{ $absence->statut }}
            </div>
            <h5>{{ $absence->type }}</h5>
            <div class="absence-info">
                <p><strong>Période:</strong> Du {{ date('d/m/Y', strtotime($absence->date_debut)) }} 
                   au {{ date('d/m/Y', strtotime($absence->date_fin)) }}</p>
                <p><strong>Durée:</strong> {{ $absence->duree }} jour(s)</p>
                <p><strong>Demande créée le:</strong> {{ $absence->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="motif-section">
                <h6>Motif de l'absence:</h6>
                <p class="absence-description">{{ $absence->motif }}</p>
            </div>

            <div class="absence-actions">
                <a href="{{ route('absences.edit', $absence->id) }}" class="btn btn-primary">
                    <ion-icon name="pencil-sharp"></ion-icon> Modifier
                </a>
                <a href="{{ route('absences.index') }}" class="btn btn-secondary">
                    <ion-icon name="arrow-back-sharp"></ion-icon> Retour
                </a>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #54acc4;
            --secondary: #495057;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #e66840;
        }

        .absence-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(84, 172, 196, 0.1);
            max-width: 800px;
            margin: 2rem auto;
        }

        .absence-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(84, 172, 196, 0.2);
            border-color: var(--primary);
        }

        .absence-content {
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            color: white;
        }

        .status-badge.approved {
            background: var(--success);
        }

        .status-badge.rejected {
            background: var(--danger);
        }

        .status-badge.pending {
            background: var(--warning);
            color: #000;
        }

        .absence-content h5 {
            color: var(--primary);
            font-size: 1.5rem;
            margin: 1.5rem 0 1rem;
            font-weight: 600;
        }

        .absence-content h6 {
            color: var(--secondary);
            font-size: 1.1rem;
            margin: 1rem 0;
            font-weight: 600;
        }

        .absence-info {
            margin-bottom: 1.5rem;
            color: var(--secondary);
        }

        .absence-info p {
            margin: 0.5rem 0;
        }

        .motif-section {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin: 1.5rem 0;
        }

        .absence-description {
            color: var(--secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .absence-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #4798ae;
            border-color: #4798ae;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(84, 172, 196, 0.2);
        }

        .btn-secondary {
            background-color: #f0f0f0;
            border-color: #ddd;
            color: var(--secondary);
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .absence-card {
                margin: 1rem;
            }

            .absence-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection