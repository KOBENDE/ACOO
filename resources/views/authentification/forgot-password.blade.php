<!-- Page de demande de réinitialisation -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié | CongeEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-96">
        <h2 class="text-2xl font-bold text-orange-600 mb-4 text-center">Mot de passe oublié</h2>
        <p class="text-gray-700 text-center mb-4">Entrez votre email pour recevoir un lien de réinitialisation.</p>
        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">

            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>
            <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">Envoyer</button>
        </form>
        <p class="text-center text-sm mt-4"><a href="{{ route('login.form') }}" class="text-orange-500 hover:underline">Retour à la connexion</a></p>
    </div>
</body>
</html>