<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - TripGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .tripgo-yellow {
            background-color: #FFD500;
        }

        .tripgo-yellow-text {
            color: #FFD500;
        }

        .tripgo-black {
            background-color: #121212;
        }

        .tripgo-black-text {
            color: #121212;
        }

        .input-focus:focus {
            border-color: #FFD500;
            box-shadow: 0 0 0 3px rgba(255, 213, 0, 0.2);
        }

        .btn-yellow:hover {
            background-color: #E5C200;
        }

        .btn-yellow:active {
            background-color: #CCAC00;
        }

        .pattern-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FFD500' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .role-option {
            transition: all 0.2s ease;
        }

        .role-option:hover {
            transform: translateY(-2px);
        }

        .role-option.selected {
            border-color: #FFD500;
            background-color: rgba(255, 213, 0, 0.1);
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4 pattern-bg">
    <div class="w-full max-w-2xl">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 tripgo-yellow rounded-full mb-4">
                <i class="fas fa-route text-3xl tripgo-black-text"></i>
            </div>
            <h1 class="text-3xl font-bold tripgo-black-text">TripGo</h1>
            <p class="text-gray-600 mt-2">Créez votre compte</p>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
            <form id="registerForm" action="{{ route('register.post') }}" method="post" class="space-y-6">
                @csrf
                <!-- Champ Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium tripgo-black-text mb-2">
                        Nom complet
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $googleUser['name'] ?? '') }}"
                            required
                            class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            placeholder="Jean Dupont"
                        >
                    </div>
                </div>

                <!-- Champ Email -->
                <div>
                    <label for="email" class="block text-sm font-medium tripgo-black-text mb-2">
                        Adresse e-mail
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $googleUser['email'] ?? '') }}"
                            required
                            class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            placeholder="exemple@email.com"
                        >
                    </div>
                </div>

                <!-- Champ Téléphone -->
                <div>
                    <label for="phone" class="block text-sm font-medium tripgo-black-text mb-2">
                        Numéro de téléphone
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            required
                            class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            placeholder="+33 6 12 34 56 78"
                        >
                    </div>
                </div>
                 <!-- Champ Ville -->
                    <div>
                        <label for="ville" class="block text-sm font-medium tripgo-black-text mb-2">
                            Ville
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <input
                                id="ville"
                                name="ville"
                                type="text"
                                class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                                placeholder="Paris"
                            >
                        </div>
                    </div>
                 <!-- Champ code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium tripgo-black-text mb-2">
                            Ville
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <input
                                id="postal_code"
                                name="postal_code"
                                type="number"
                                class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                                placeholder="4000"
                            >
                        </div>
                    </div>
                 <!-- Champ date -->
                    <div>
                        <label for="date_birth" class="block text-sm font-medium tripgo-black-text mb-2">
                            date birthday
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <input
                                id="date_birth"
                                name="date_birth"
                                type="date"
                                class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                                placeholder="Paris"
                            >
                        </div>
                    </div>

                <!-- Champ Mot de passe -->
                @if (!session()->has('google_user'))


                <div>
                    <label for="password" class="block text-sm font-medium tripgo-black-text mb-2">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="input-focus appearance-none block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            placeholder="••••••••"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <i id="eyeIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Champ Confirmation du mot de passe -->
                <div>
                    <label for="confirmPassword" class="block text-sm font-medium tripgo-black-text mb-2">
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            id="confirmPassword"
                            name="password_confirmation"
                            type="password"
                            required
                            class="input-focus appearance-none block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            placeholder="••••••••"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" id="toggleConfirmPassword" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <i id="eyeIconConfirm" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
@endif

                <!-- Sélection du rôle -->
                <div>
                    <label class="block text-sm font-medium tripgo-black-text mb-2">
                        Je m'inscris en tant que
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <div id="passengerOption" class="role-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer text-center">
                            <i class="fas fa-user text-2xl text-gray-600 mb-2"></i>
                            <p class="font-medium">Passager</p>
                        </div>
                        <div id="driverOption" class="role-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer text-center">
                            <i class="fas fa-car text-2xl text-gray-600 mb-2"></i>
                            <p class="font-medium">Conducteur</p>
                        </div>
                    </div>
                    <input type="hidden" id="role" name="role" value="passenger">
                </div>

                <!-- Champs supplémentaires pour les conducteurs (cachés par défaut) -->
                <div id="driverFields" class="hidden space-y-6 fade-in">
                    <h3 class="text-lg font-medium tripgo-black-text border-t pt-4">Informations sur le véhicule</h3>

                    <!-- Champ Numéro de permis -->
                    <div>
                        <label for="licenseNumber" class="block text-sm font-medium tripgo-black-text mb-2">
                            Numéro de permis de conduire
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input
                                id="licenseNumber"
                                name="licenseNumber"
                                type="text"
                                class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                                placeholder="123456789012"
                            >
                        </div>
                    </div>



                    <!-- Champ Type de véhicule -->
                    <div>
                        <label for="vehicleType" class="block text-sm font-medium tripgo-black-text mb-2">
                            Type de véhicule
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-car text-gray-400"></i>
                            </div>
                            <select
                                id="vehicleType"
                                name="vehicleType"
                                class="input-focus appearance-none block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            >
                                <option value="">Sélectionnez un type</option>
                                <option value="sedan">Berline</option>
                                <option value="suv">SUV</option>
                                <option value="hatchback">Compacte</option>
                                <option value="van">Fourgonnette</option>
                                <option value="luxury">Luxe</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Champ Couleur du véhicule -->
                    <div>
                        <label for="vehicleColor" class="block text-sm font-medium tripgo-black-text mb-2">
                            Couleur du véhicule
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-palette text-gray-400"></i>
                            </div>
                            <input
                                id="vehicleColor"
                                name="vehicleColor"
                                type="text"
                                class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                                placeholder="Noir"
                            >
                        </div>
                    </div>

                    <!-- Champ Nombre de sièges -->
                    <div>
                        <label for="seatCount" class="block text-sm font-medium tripgo-black-text mb-2">
                            Nombre de sièges
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-chair text-gray-400"></i>
                            </div>
                            <select
                                id="seatCount"
                                name="seatCount"
                                class="input-focus appearance-none block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            >
                                <option value="">Sélectionnez le nombre</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8+</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Champ Plaque d'immatriculation -->
                    <div>
                        <label for="vehiclePlate" class="block text-sm font-medium tripgo-black-text mb-2">
                            Plaque d'immatriculation
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-badge text-gray-400"></i>
                            </div>
                            <input
                                id="vehiclePlate"
                                name="vehiclePlate"
                                type="text"
                                class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                                placeholder="AA-123-BB"
                            >
                        </div>
                    </div>
                </div>

                <!-- Conditions d'utilisation -->
                <div class="flex items-center">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        required
                        class="h-4 w-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded"
                    >
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        J'accepte les <a href="#" class="tripgo-yellow-text hover:underline">conditions d'utilisation</a> et la <a href="#" class="tripgo-yellow-text hover:underline">politique de confidentialité</a>
                    </label>
                </div>

                <!-- Bouton d'inscription -->
                <div>
                    <button
                        type="submit"
                        class="btn-yellow group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium tripgo-black-text tripgo-yellow focus:outline-none transition duration-150"
                    >
                        S'inscrire
                    </button>
                </div>
            </form>

            <!-- Lien de connexion -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Vous avez déjà un compte?
                    <a href="{{ route('login') }}" class="font-medium tripgo-yellow-text hover:underline">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>

        <!-- Message d'erreur (caché par défaut) -->
        <div id="errorMessage" class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 hidden">
            <p class="font-medium">Erreur d'inscription</p>
            <p class="text-sm">Veuillez vérifier les informations saisies.</p>
        </div>

        <!-- Message de succès (caché par défaut) -->
        <div id="successMessage" class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 hidden">
            <p class="font-medium">Inscription réussie</p>
            <p class="text-sm">Redirection vers la page de connexion...</p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
if(togglePassword && passwordInput){
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Change the icon
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });

        // Toggle confirm password visibility
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            // Change the icon
            if (type === 'password') {
                eyeIconConfirm.classList.remove('fa-eye-slash');
                eyeIconConfirm.classList.add('fa-eye');
            } else {
                eyeIconConfirm.classList.remove('fa-eye');
                eyeIconConfirm.classList.add('fa-eye-slash');
            }
        });
    }
        // Role selection
        const passengerOption = document.getElementById('passengerOption');
        const driverOption = document.getElementById('driverOption');
        const roleInput = document.getElementById('role');
        const driverFields = document.getElementById('driverFields');

        passengerOption.addEventListener('click', function() {
            roleInput.value = 'passenger';
            passengerOption.classList.add('selected');
            driverOption.classList.remove('selected');
            driverFields.classList.add('hidden');

            // Remove required attribute from driver fields
            const driverInputs = driverFields.querySelectorAll('input, select');
            driverInputs.forEach(input => {
                input.removeAttribute('required');
            });
        });

        driverOption.addEventListener('click', function() {
            roleInput.value = 'driver';
            driverOption.classList.add('selected');
            passengerOption.classList.remove('selected');
            driverFields.classList.remove('hidden');

            // Add required attribute to driver fields
            const driverInputs = driverFields.querySelectorAll('input, select');
            driverInputs.forEach(input => {
                input.setAttribute('required', 'required');
            });
        });



        // Set default role to passenger
        passengerOption.click();
    </script>
</body>
</html>
