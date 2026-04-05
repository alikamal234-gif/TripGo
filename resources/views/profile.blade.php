<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - TripGo</title>
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
        
        .sidebar-item {
            transition: all 0.2s ease;
        }
        
        .sidebar-item:hover {
            background-color: rgba(255, 213, 0, 0.1);
            border-left: 3px solid #FFD500;
        }
        
        .sidebar-item.active {
            background-color: rgba(255, 213, 0, 0.15);
            border-left: 3px solid #FFD500;
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .tab-button {
            transition: all 0.2s ease;
        }
        
        .tab-button:hover {
            background-color: rgba(255, 213, 0, 0.1);
        }
        
        .tab-button.active {
            background-color: #FFD500;
            color: #121212;
        }
    </style>
</head>
<body class="bg-gray-50 pattern-bg">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 tripgo-black text-white">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 tripgo-yellow rounded-full flex items-center justify-center">
                        <i class="fas fa-route tripgo-black-text"></i>
                    </div>
                    <h1 class="text-xl font-bold">TripGo</h1>
                </div>
                
                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg">
                        <i class="fas fa-home w-5"></i>
                        <span>Home</span>
                    </a>
                    <a href="#" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg">
                        <i class="fas fa-user w-5"></i>
                        <span>Mon profil</span>
                    </a>
                    <!-- Afficher seulement si c'est un conducteur -->
                    @if($user->role->name === 'driver')
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg">
                        <i class="fas fa-car w-5"></i>
                        <span>Mes véhicules</span>
                    </a>
                    @endif
                    
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg">
                        <i class="fas fa-cog w-5"></i>
                        <span>Paramètres</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-red-400">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Déconnexion</span>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold tripgo-black-text">Mon profil</h2>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="flex items-center space-x-3">
                            <img src="{{ $user->profile_photo_url ?? 'https://picsum.photos/seed/' . $user->id . '/40/40.jpg' }}" alt="Profile" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="text-sm font-medium tripgo-black-text">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($user->role->name) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Content -->
            <div class="p-6">
                <!-- Profile Header -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                        <!-- Profile Picture -->
                        <div class="relative">
                            <img src="{{ $user->profile_photo_url ?? 'https://picsum.photos/seed/' . $user->id . '/120/120.jpg' }}" alt="Profile" class="w-32 h-32 rounded-full border-4 border-yellow-400">
                            <button class="absolute bottom-0 right-0 w-10 h-10 tripgo-yellow rounded-full flex items-center justify-center shadow-lg hover:bg-yellow-400 transition">
                                <i class="fas fa-camera tripgo-black-text"></i>
                            </button>
                        </div>
                        
                        <!-- Profile Info -->
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-bold tripgo-black-text">{{ $user->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                            <p class="text-gray-600 mb-4">{{ $user->phone ?? 'Non renseigné' }}</p>
                            
                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i> {{ $user->email_verified_at ? 'Vérifié' : 'Non vérifié' }}
                                </span>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-star mr-1"></i> {{ $user->average_rating ?? 'Nouveau' }} ({{ $user->ratings_count ?? 0 }} avis)
                                </span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-{{ $user->role->name === 'driver' ? 'car' : 'user' }} mr-1"></i> {{ ucfirst($user->role->name) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-2">
                            <form action="" method="post">
                                @method('DELETE')
                                @csrf
                                <button class="hover:bg-red-500 px-6 py-2 rounded-lg tripgo-black-text font-medium">
                                <i class="fas fa-trash-can mr-2"></i> supprimer le compte
                            </button>
                            </form>
                            <button class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                                <i class="fas fa-share-alt mr-2"></i> Partager
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics Cards - Différentes selon le rôle -->
                @if($user->role->name === 'driver')
                <!-- Driver Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="stat-card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fas fa-route text-2xl text-yellow-500"></i>
                            <span class="text-xs text-green-600 font-medium">+12%</span>
                        </div>
                        <h4 class="text-2xl font-bold tripgo-black-text">{{ $user->driver->completed_trips ?? 0 }}</h4>
                        <p class="text-gray-600 text-sm">Number Of Trips</p>    
                    </div>
                    
                    
                </div>
                @else
                <!-- Passenger Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="stat-card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fas fa-route text-2xl text-yellow-500"></i>
                            <span class="text-xs text-green-600 font-medium">+5%</span>
                        </div>
                        <h4 class="text-2xl font-bold tripgo-black-text">{{ count($user->passenger->trips ?? []) }}</h4>
                        <p class="text-gray-600 text-sm">Trajets effectués</p>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fas fa-map-marked-alt text-2xl text-blue-500"></i>
                            <span class="text-xs text-green-600 font-medium">+15%</span>
                        </div>
                        <h4 class="text-2xl font-bold tripgo-black-text">{{ $user->passenger->total_distance ?? 0 }} km</h4>
                        <p class="text-gray-600 text-sm">Distance parcourue</p>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fas fa-euro-sign text-2xl text-green-500"></i>
                            <span class="text-xs text-red-600 font-medium">-10%</span>
                        </div>
                        <h4 class="text-2xl font-bold tripgo-black-text">€{{ number_format($user->passenger->total_spent ?? 0, 0, ',', ' ') }}</h4>
                        <p class="text-gray-600 text-sm">Total dépensé</p>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fas fa-award text-2xl text-purple-500"></i>
                            <span class="text-xs text-green-600 font-medium">Nouveau!</span>
                        </div>
                        <h4 class="text-2xl font-bold tripgo-black-text">{{ $user->passenger->loyalty_points ?? 0 }}</h4>
                        <p class="text-gray-600 text-sm">Points de fidélité</p>
                    </div>
                </div>
                @endif
                
                <!-- Tabs Section -->
                <div class="bg-white rounded-xl shadow-sm">
                    <!-- Tab Headers -->
                    <div class="border-b border-gray-200">
                        <div class="flex space-x-1 p-1">
                            <button class="tab-button active px-4 py-2 rounded-lg font-medium" onclick="switchTab('personal')">
                                Informations personnelles
                            </button>
                            @if($user->role->name === 'driver')
                            <button class="tab-button px-4 py-2 rounded-lg font-medium text-gray-600" onclick="switchTab('vehicle')">
                                Véhicule
                            </button>
                           
                            @endif
                            <button class="tab-button px-4 py-2 rounded-lg font-medium text-gray-600" onclick="switchTab('preferences')">
                                Préférences
                            </button>
                        </div>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Personal Information Tab -->
                        <div id="personal-tab" class="tab-content">
                            <h4 class="text-lg font-semibold tripgo-black-text mb-4">Informations personnelles</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                    <input type="text" value="{{ $user->name }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" value="{{ $user->email }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                    <input type="string" value="{{ $user->phone ?? '' }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance</label>
                                    <input type="date" value="{{ $user->birth_date ?? '' }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                    <input type="text" value="{{ $user->city ?? '' }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                                    <input type="text" value="{{ $user->postal_code ?? '' }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button class="btn-yellow px-6 py-2 rounded-lg tripgo-black-text font-medium">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                        
                       @if($user->driver && $user->driver->vehicle)
                        <!-- Vehicle Tab -->
                        <div id="vehicle-tab" class="tab-content hidden">
                            <h4 class="text-lg font-semibold tripgo-black-text mb-4">Informations sur le véhicule</h4>
                            @if($user->driver->vehicle->type)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Marque et modèle</label>
                                    <input type="text" value="{{ $user->driver->vehicle->type }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                               <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">number de plate</label>
                                    <input type="text" value="{{ $user->driver->vehicle->vehicle_plate }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                                    <input type="text" value="{{ $user->driver->vehicle->coulour }}" class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                                
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de sièges</label>
                                    <select class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                        <option {{ $user->driver->vehicle->num_seats == 2 ? 'selected' : '' }}>2</option>
                                        <option {{ $user->driver->vehicle->num_seats == 3 ? 'selected' : '' }}>3</option>
                                        <option {{ $user->driver->vehicle->num_seats == 4 ? 'selected' : '' }}>4</option>
                                        <option {{ $user->driver->vehicle->num_seats == 5 ? 'selected' : '' }}>5</option>
                                        <option {{ $user->driver->vehicle->num_seats >= 6 ? 'selected' : '' }}>6+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $user->driver->vehicle->photo_url ?? 'https://picsum.photos/seed/vehicle' . $user->id . '/200/120.jpg' }}" alt="Vehicle" class="rounded-lg">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-2">Photo du véhicule</p>
                                        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                                            <i class="fas fa-upload mr-2"></i> Changer la photo
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-8">
                                <i class="fas fa-car text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 mb-4">Aucun véhicule enregistré</p>
                                <button class="btn-yellow px-6 py-2 rounded-lg tripgo-black-text font-medium">
                                    <i class="fas fa-plus mr-2"></i> Ajouter un véhicule
                                </button>
                            </div>
                            @endif
                            <div class="mt-6 flex justify-end">
                                <button class="btn-yellow px-6 py-2 rounded-lg tripgo-black-text font-medium">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                        
                        
                        @endif
                        
                        <!-- Preferences Tab -->
                        <div id="preferences-tab" class="tab-content hidden">
                            <h4 class="text-lg font-semibold tripgo-black-text mb-4">Préférences</h4>
                            <div class="space-y-6">
                                <div>
                                    <h5 class="font-medium mb-3">Notifications</h5>
                                    <div class="space-y-3">
                                        <label class="flex items-center justify-between">
                                            <span class="text-gray-700">Notifications par email</span>
                                            <input type="checkbox" {{ $user->email_notifications ? 'checked' : '' }} class="w-5 h-5 text-yellow-500 rounded focus:ring-yellow-400">
                                        </label>
                                        <label class="flex items-center justify-between">
                                            <span class="text-gray-700">Notifications push</span>
                                            <input type="checkbox" {{ $user->push_notifications ? 'checked' : '' }} class="w-5 h-5 text-yellow-500 rounded focus:ring-yellow-400">
                                        </label>
                                        <label class="flex items-center justify-between">
                                            <span class="text-gray-700">SMS de confirmation</span>
                                            <input type="checkbox" {{ $user->sms_notifications ? 'checked' : '' }} class="w-5 h-5 text-yellow-500 rounded focus:ring-yellow-400">
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <h5 class="font-medium mb-3">Langue </h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Langue</label>
                                            <select class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                                <option {{ $user->language === 'fr' ? 'selected' : '' }}>Français</option>
                                                <option {{ $user->language === 'en' ? 'selected' : '' }}>English</option>
                                                <option {{ $user->language === 'es' ? 'selected' : '' }}>Español</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button class="btn-yellow px-6 py-2 rounded-lg tripgo-black-text font-medium">
                                    Enregistrer les préférences
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active');
                button.classList.add('text-gray-600');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Add active class to clicked button
            event.target.classList.add('active');
            event.target.classList.remove('text-gray-600');
        }
        
        // Handle profile picture upload
        document.querySelector('.fa-camera').parentElement.addEventListener('click', function() {
            // Create a hidden file input
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*';
            fileInput.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    // In a real app, this would upload the file
                    alert('Photo de profil mise à jour avec succès!');
                }
            };
            fileInput.click();
        });
    </script>
</body>
</html>