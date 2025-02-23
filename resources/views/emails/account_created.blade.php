<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte a été créé</title>
</head>
<body>
    <h2>Bonjour {{ $prenom }} {{ $nom }},</h2>
    <p>Votre compte a été créé avec succès sur la plateforme CongeEasy.</p>
    <p>Voici vos informations de connexion :</p>
    <ul>
        <li><strong>Email :</strong> {{ $email }}</li>
        <li><strong>Mot de passe :</strong> {{ $password }}</li>
    </ul>
    <p>Veuillez vous connecter et modifier votre mot de passe dès que possible.</p>
    <p><a href="{{ route('login.form') }}">Accéder à la connexion</a></p>
    <p>Cordialement,<br>L'équipe CongeEasy</p>
</body>
</html>
