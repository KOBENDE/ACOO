<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page pour profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<div class="min-h-screen bg-gray-100 flex flex-col items-center py-10">
    <div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-user"></i>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h2>
                    <p class="text-gray-600 text-sm">
                        @if(auth()->user()->role === 'employe')
                            Fonction : {{ auth()->user()->fonction }}
                        @else
                            Rôle : {{ ucfirst(auth()->user()->role) }}
                        @endif
                    </p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="get">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Déconnexion
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Informations personnelles</h3>
                <p><strong>Email :</strong> {{ auth()->user()->email }}</p>
                <p><strong>Service :</strong> {{ auth()->user()->service->nom ?? 'Non attribué' }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Actions rapides</h3>
                <button id="editProfileBtn" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Modifier le profil</button>
                <a href="{{ route('directeur.dashboard') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Retour</a>
            </div>
        </div>

        <!-- Formulaire de modification du profil (caché par défaut) -->
        <div id="editProfileForm" class="hidden bg-gray-50 p-6 rounded-lg shadow mt-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Modifier le profil</h3>
            <form action="{{ route('profil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="service" class="block text-gray-700">Service</label>
                    <select name="service" id="service" class="w-full p-2 border border-gray-300 rounded">
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ auth()->user()->service_id == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="fonction" class="block text-gray-700">Fonction</label>
                    <input type="text" name="fonction" id="fonction" value="{{ auth()->user()->fonction }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
                <button type="button" id="closeEditProfileBtn" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Fermer</button>
            </form>
        </div>
        <!-- Formulaire de modification du mot de passe (caché par défaut) -->
<div id="changePasswordForm" class="hidden bg-gray-50 p-6 rounded-lg shadow mt-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-800">Changer le mot de passe</h3>
    <form action="{{ route('profil.updatePassword') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="current_password" class="block text-gray-700">Mot de passe actuel</label>
            <input type="password" name="current_password" id="current_password" required class="w-full p-2 border border-gray-300 rounded">
        </div>

        <div class="mb-4">
            <label for="new_password" class="block text-gray-700">Nouveau mot de passe</label>
            <input type="password" name="new_password" id="new_password" required class="w-full p-2 border border-gray-300 rounded">
        </div>

        <div class="mb-4">
            <label for="confirm_password" class="block text-gray-700">Confirmer le nouveau mot de passe</label>
            <input type="password" name="new_password_confirmation" id="confirm_password" required class="w-full p-2 border border-gray-300 rounded">
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
            <button type="button" id="closeChangePasswordBtn" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Annuler</button>
        </div>
    </form>
</div>

<!-- Bouton pour ouvrir le formulaire de changement de mot de passe -->
<button id="changePasswordBtn" class="bg-purple-500 text-white px-4 py-2 rounded mt-4 hover:bg-purple-600">
    Modifier le mot de passe
</button>

    </div>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
</div>
<script>
    // Affichage du formulaire de modification du profil
    document.getElementById("editProfileBtn").addEventListener("click", function() {
        document.getElementById("editProfileForm").classList.remove("hidden");
    });

    // Fermeture du formulaire de modification du profil
    document.getElementById("closeEditProfileBtn").addEventListener("click", function() {
        document.getElementById("editProfileForm").classList.add("hidden");
    });

    // Affichage du formulaire de changement de mot de passe
    document.getElementById("changePasswordBtn").addEventListener("click", function() {
        document.getElementById("changePasswordForm").classList.remove("hidden");
    });

    // Fermeture du formulaire de changement de mot de passe
    document.getElementById("closeChangePasswordBtn").addEventListener("click", function() {
        document.getElementById("changePasswordForm").classList.add("hidden");
    });
    // Sélection des éléments
    const changePasswordBtn = document.getElementById("changePasswordBtn");
    const changePasswordForm = document.getElementById("changePasswordForm");
    const closeChangePasswordBtn = document.getElementById("closeChangePasswordBtn");

    // Affichage du formulaire de changement de mot de passe et disparition du bouton
    changePasswordBtn.addEventListener("click", function() {
        changePasswordForm.classList.remove("hidden"); // Afficher le formulaire
        changePasswordBtn.classList.add("hidden"); // Cacher le bouton
    });

    // Fermeture du formulaire et réapparition du bouton
    closeChangePasswordBtn.addEventListener("click", function() {
        changePasswordForm.classList.add("hidden"); // Cacher le formulaire
        changePasswordBtn.classList.remove("hidden"); // Réafficher le bouton
    });
</script>


</body>
</html>
