<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <title>Connexion | GCA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            scroll-behavior: smooth;
        }

        .custom-blue {
            background-color: #54acc4;
        }

        .custom-blue-hover:hover {
            background-color: #4798b0;
        }

        .custom-orange {
            color: #e66840;
        }

        .custom-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            pointer-events: none; /* L'icône ne bloque pas les clics */
            z-index: 10; /* Assure que l'icône reste au-dessus du champ */
        }

        .input-with-icon {
            padding-left: 3rem; /* Espace pour l'icône */
            position: relative;
            z-index: 1; /* Assure que le texte saisi reste au-dessus de l'icône */
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dégradé personnalisé */
        .gradient-background {
            background: linear-gradient(to bottom, #7ebed2, #ffffff);
        }
    </style>
</head>

<body class="gradient-background flex items-center justify-center min-h-screen p-4">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8 custom-shadow animate-fade-in">
        <!-- Logo et Titre -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-alt text-4xl text-[#54acc4]"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Bienvenue sur GCA</h2>
            <p class="text-gray-600">Gérez vos congés en toute simplicité</p>
        </div>

        <!-- Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center font-medium animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route("connection") }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full input-with-icon py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#54acc4] focus:border-transparent transition-all duration-200"
                        placeholder="nom@entreprise.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                <div class="relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" required
                    class="w-full input-with-icon py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#54acc4] focus:border-transparent transition-all duration-200"
F                    placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm group cursor-pointer">
                    <input type="checkbox" name="remember"
                        class="mr-2 rounded border-gray-300 text-[#54acc4] focus:ring-[#54acc4] cursor-pointer">
                    <span class="text-gray-600 group-hover:text-gray-800 transition-colors">Se souvenir de moi</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-[#54acc4] hover:text-[#4798b0] transition-colors hover:underline">
                    Mot de passe oublié ?
                </a>
            </div>

            <button type="submit"
                class="w-full custom-blue text-white py-3 rounded-lg custom-blue-hover transition-all duration-200 font-medium hover:shadow-lg transform hover:-translate-y-0.5">
                <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
            </button>
        </form>

        <div class="mt-6 space-y-3">
            <p class="text-center text-sm text-gray-600">
                Pas encore de compte ?
                <a href="{{ url('/register') }}"
                    class="text-[#54acc4] hover:text-[#4798b0] font-medium hover:underline">
                    Inscrivez-vous
                </a>
            </p>
        </div>
    </div>
</body>

</html>