<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        .tripgo-black { background-color: #121212; }
        .tripgo-black-text { color: #121212; }
        .pattern-bg { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FFD500' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .sidebar-item { transition: all 0.2s ease; border-left: 3px solid transparent; }
        .sidebar-item:hover, .sidebar-item.active { background-color: rgba(255, 213, 0, 0.15); border-left: 3px solid #FFD500; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        .tab-button { transition: all 0.2s ease; cursor: pointer; }
        .tab-button:hover { background-color: rgba(255, 213, 0, 0.1); }
        .tab-button.active { background-color: #FFD500; color: #121212; font-weight: 600; }
    </style>
</head>
<body class="bg-gray-50 pattern-bg">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 tripgo-black text-white flex-shrink-0 hidden md:flex md:flex-col">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 tripgo-yellow rounded-full flex items-center justify-center">
                        <i class="fas fa-route tripgo-black-text"></i>
                    </div>
                    <h1 class="text-xl font-bold">TripGo</h1>
                </div>
                <nav class="space-y-2">
                    <a href="/" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-home w-5"></i><span>Home</span>
                    </a>
                    <a href="#" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                        <i class="fas fa-user w-5"></i><span>Mon profil</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b sticky top-0 z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold tripgo-black-text">
                        {{ $role === 'driver' ? 'Espace Conducteur' : 'Espace Passager' }}
                    </h2>
                    <div class="flex items-center space-x-3 bg-gray-50 px-4 py-2 rounded-full">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium tripgo-black-text hidden sm:block">{{ $user->name }}</span>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg relative w-8 h-8 flex items-center justify-center">
                                        <i class="fas fa-power-off text-sm"></i>
                                    </button>
                                </form>
                    </div>
                </div>
            </div>

            <div class="p-6 max-w-6xl mx-auto">
                
                <!-- CARD INFOS PERSO -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex flex-col md:flex-row items-start space-y-4 md:space-y-0 md:space-x-6">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-3xl font-bold flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <h3 class="text-2xl font-bold tripgo-black-text">{{ $user->name }}</h3>
                                
                                @if($role === 'driver')
                                    @if($user->driver->is_verified)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold flex items-center gap-1">
                                            <i class="fas fa-shield-halved"></i> Vérifié
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold flex items-center gap-1">
                                            <i class="fas fa-exclamation-triangle"></i> Non vérifié
                                        </span>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-sm text-gray-600">
                                <div><i class="fas fa-envelope mr-2 text-gray-400"></i>{{ $user->email }}</div>
                                <div><i class="fas fa-phone mr-2 text-gray-400"></i>{{ $user->phone }}</div>
                                <div><i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>{{ $user->ville }} ({{ $user->postal_code }})</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STATS & INFOS SPÉCIFIQUES -->
                @if($role === 'driver')
                    <!-- DRIVER VIEW -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="lg:col-span-1 space-y-4">
                            <div class="stat-card bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-400">
                                <p class="text-sm text-gray-500 mb-1">Note moyenne</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-3xl font-bold tripgo-black-text">{{ $averageRating }}</span>
                                    <div class="text-yellow-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($averageRating !== 'Nouveau' && $i <= floor($averageRating))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="stat-card bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-400">
                                <p class="text-sm text-gray-500 mb-1">Trajets terminés</p>
                                <span class="text-3xl font-bold tripgo-black-text">{{ $user->driver->trips->where('status', 'terminer')->count() }}</span>
                            </div>
                        </div>

                        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                            <h4 class="text-lg font-bold tripgo-black-text mb-4 flex items-center gap-2">
                                <i class="fas fa-car text-yellow-500"></i> Mon Véhicule
                            </h4>
                            @if($user->driver->vehicle)
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <i class="fas fa-car-side text-2xl text-gray-400 mb-2"></i>
                                        <p class="text-xs text-gray-500">Modèle</p>
                                        <p class="font-semibold tripgo-black-text">{{ $user->driver->vehicle->type }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <i class="fas fa-id-card text-2xl text-gray-400 mb-2"></i>
                                        <p class="text-xs text-gray-500">Immatriculation</p>
                                        <p class="font-semibold tripgo-black-text">{{ $user->driver->vehicle->vehicle_plate }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <i class="fas fa-palette text-2xl text-gray-400 mb-2"></i>
                                        <p class="text-xs text-gray-500">Couleur</p>
                                        <p class="font-semibold tripgo-black-text capitalize">{{ $user->driver->vehicle->coulour }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <i class="fas fa-users text-2xl text-gray-400 mb-2"></i>
                                        <p class="text-xs text-gray-500">Places dispo.</p>
                                        <p class="font-semibold tripgo-black-text">{{ $user->driver->vehicle->num_seats }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                                    <i class="fas fa-car-crash text-4xl mb-3 text-gray-300"></i>
                                    <p>Aucun véhicule trouvé.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                @else
                    <!-- PASSENGER VIEW -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="stat-card bg-white rounded-xl shadow-sm p-6 text-center">
                            <i class="fas fa-route text-3xl text-yellow-500 mb-3"></i>
                            <p class="text-3xl font-bold tripgo-black-text">{{ $user->passenger->trips->count() }}</p>
                            <p class="text-gray-500 text-sm">Trajets réservés</p>
                        </div>
                        <div class="stat-card bg-white rounded-xl shadow-sm p-6 text-center">
                            <i class="fas fa-check-circle text-3xl text-green-500 mb-3"></i>
                            <p class="text-3xl font-bold tripgo-black-text">{{ $user->passenger->trips->where('status', 'terminer')->count() }}</p>
                            <p class="text-gray-500 text-sm">Trajets terminés</p>
                        </div>
                        <div class="stat-card bg-white rounded-xl shadow-sm p-6 text-center">
                            <i class="fas fa-hourglass-half text-3xl text-blue-500 mb-3"></i>
                            <p class="text-3xl font-bold tripgo-black-text">{{ $user->passenger->trips->where('status', 'avenir')->count() }}</p>
                            <p class="text-gray-500 text-sm">Trajets à venir</p>
                        </div>
                    </div>
                @endif

                <!-- LISTE DES TRAJETS -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h4 class="text-lg font-bold tripgo-black-text">
                            {{ $role === 'driver' ? 'Historique de mes courses' : 'Mes trajets' }}
                        </h4>
                        <div class="flex space-x-2 bg-gray-100 p-1 rounded-lg">
                            <button onclick="filterTrips('all', this)" class="tab-button active px-3 py-1 rounded-md text-sm">Tous</button>
                            <button onclick="filterTrips('avenir', this)" class="tab-button px-3 py-1 rounded-md text-sm text-gray-600">A venir</button>
                            <button onclick="filterTrips('encours', this)" class="tab-button px-3 py-1 rounded-md text-sm text-gray-600">En cours</button>
                            <button onclick="filterTrips('terminer', this)" class="tab-button px-3 py-1 rounded-md text-sm text-gray-600">Terminés</button>
                        </div>
                    </div>
                    
                    <div id="trips-container" class="divide-y divide-gray-100">
                        @php
// Utilisation stricte de votre logique de modèles
$trips = $role === 'driver' ? $user->driver->trips : $user->passenger->trips;
                        @endphp

                        @if($trips && $trips->count() > 0)
                            @foreach($trips->sortByDesc('departure_time') as $trip)
                                @include('partials.trip-card', ['trip' => $trip])
                            @endforeach
                        @else
                            <div class="p-10 text-center text-gray-400">
                                <i class="fas fa-suitcase-rolling text-5xl mb-4 text-gray-200"></i>
                                <p class="text-lg">Aucun trajet trouvé.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function filterTrips(status, btnElement) {
            const buttons = btnElement.parentElement.querySelectorAll('.tab-button');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('text-gray-600');
            });
            btnElement.classList.add('active');
            btnElement.classList.remove('text-gray-600');

            const cards = document.querySelectorAll('.trip-row');
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>