@extends('layout.index')

@section('custom_page')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Liste des employés</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="table table-bordered">
            <thead class="bg-gray-100">
                <tr class="border-b">
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Prénom</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Service</th>
                    <th class="p-3 text-left">Fonction</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employes as $employe)
                <tr class="border-b">
                    <td class="p-3">{{ $employe->nom }}</td>
                    <td class="p-3">{{ $employe->prenom }}</td>
                    <td class="p-3">{{ $employe->email }}</td>
                    <td class="p-3">{{ $employe->service->nom ?? 'Non assigné' }}</td>
                    <td class="p-3">{{ $employe->fonction }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">Aucun employé trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
