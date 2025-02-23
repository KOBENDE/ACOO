<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | GCA</title>
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

        .custom-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            pointer-events: none;
            z-index: 10;
        }

        .input-with-icon {
            padding-left: 3rem;
            position: relative;
            z-index: 1;
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

        .gradient-background {
            background: linear-gradient(to bottom, #7ebed2, #ffffff);
        }
    </style>
</head>

<body class="gradient-background flex items-center justify-center min-h-screen p-4">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-2xl p-8 custom-shadow animate-fade-in">
        <!-- Logo et Titre -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-4xl text-[#54acc4]"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Créer votre compte GCA</h2>
            <p class="text-gray-600">Remplissez le formulaire pour commencer</p>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center font-medium animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg animate-fade-in">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="#" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                    <div class="relative">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="nom" value="{{ old('nom') }}" required
                            class="w-full input-with-icon py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#54acc4] focus:border-transparent transition-all duration-200"
                            placeholder="Votre nom">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                    <div class="relative">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" required
                            class="w-full input-with-icon py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#54acc4] focus:border-transparent transition-all duration-200"
                            placeholder="Votre prénom">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email professionnel</label>
                    <div class="relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full input-with-icon py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#54acc4] focus:border-transparent transition-all duration-200"
                            placeholder="nom@entreprise.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fonction</label>
                    <div class="relative">
                        <i class="fas fa-briefcase input-icon"></i>
                        <input type="text" name="fonction" value="{{ old('fonction') }}"
                            class="w-full input-with-icon py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#54acc4] focus:border-transparent transition-all duration-200"
                            placeholder="Votre poste">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service</label>
                    <div class="relative">
                        <i class="fas fa-building input-icon"></i>
                        <select name="service_id" required
                            class="w-full input-with-icon py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#54acc4] focus:border-transparent transition-all duration-200 appearance-none bg-white">
                            <option value="">Sélectionner un service</option>
                            {{-- @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->nom }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full custom-blue text-white py-3 rounded-lg custom-blue-hover transition-all duration-200 font-medium hover:shadow-lg transform hover:-translate-y-0.5 mt-8">
                <i class="fas fa-user-plus mr-2"></i>Créer mon compte
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Déjà inscrit ?
                    <a href="{{ url('/') }}" class="text-[#54acc4] hover:text-[#4798b0] font-medium hover:underline">
                        Connectez-vous
                    </a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>