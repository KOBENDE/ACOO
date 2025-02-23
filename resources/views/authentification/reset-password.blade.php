<!-- Page de réinitialisation du mot de passe -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe | CongeEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-96">
        <h2 class="text-2xl font-bold text-orange-600 mb-4 text-center">Réinitialiser le mot de passe</h2>
        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500" required>
            </div>
            <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">Réinitialiser</button>
        </form>
    </div>
</body>
</html>
