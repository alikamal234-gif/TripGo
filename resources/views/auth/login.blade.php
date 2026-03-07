<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - TripGo</title>
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
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4 pattern-bg">
    <div class="w-full max-w-md">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 tripgo-yellow rounded-full mb-4">
                <i class="fas fa-route text-3xl tripgo-black-text"></i>
            </div>
            <h1 class="text-3xl font-bold tripgo-black-text">TripGo</h1>
            <p class="text-gray-600 mt-2">Connectez-vous à votre compte</p>
        </div>
        
        <!-- Formulaire de connexion -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
            <form id="loginForm" class="space-y-6">
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
                            autocomplete="email" 
                            required
                            class="input-focus appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none transition duration-150"
                            placeholder="exemple@email.com"
                        >
                    </div>
                </div>
                
                <!-- Champ Mot de passe -->
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
                            autocomplete="current-password" 
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
                
                <!-- Se souvenir de moi et mot de passe oublié -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember-me" 
                            name="remember-me" 
                            type="checkbox" 
                            class="h-4 w-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded"
                        >
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium tripgo-yellow-text hover:underline">
                            Mot de passe oublié?
                        </a>
                    </div>
                </div>
                
                <!-- Bouton de connexion -->
                <div>
                    <button 
                        type="submit" 
                        class="btn-yellow group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium tripgo-black-text tripgo-yellow focus:outline-none transition duration-150"
                    >
                        Se connecter
                    </button>
                </div>
                
                <!-- Séparateur -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Ou</span>
                    </div>
                </div>
                
                <!-- Boutons de connexion sociale -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        <i class="fab fa-google text-red-500 mr-2"></i>
                        Google
                    </button>
                    <button type="button" class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>
                        Facebook
                    </button>
                </div>
            </form>
            
            <!-- Lien d'inscription -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Vous n'avez pas de compte? 
                    <a href="{{ route('register') }}" class="font-medium tripgo-yellow-text hover:underline">
                        S'inscrire
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Message d'erreur (caché par défaut) -->
        <div id="errorMessage" class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 hidden">
            <p class="font-medium">Erreur de connexion</p>
            <p class="text-sm">L'e-mail ou le mot de passe est incorrect.</p>
        </div>
        
        <!-- Message de succès (caché par défaut) -->
        <div id="successMessage" class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 hidden">
            <p class="font-medium">Connexion réussie</p>
            <p class="text-sm">Redirection en cours...</p>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
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
        
        // Form submission
        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');
        
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Hide previous messages
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');
            
            // Get form values
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Simple validation (in a real app, this would be server-side)
            if (email && password) {
                // Show success message
                successMessage.classList.remove('hidden');
                
                // Simulate redirect after 2 seconds
                setTimeout(() => {
                    // In a real app, this would redirect to the dashboard
                    alert('Redirection vers le tableau de bord...');
                }, 2000);
            } else {
                // Show error message
                errorMessage.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>