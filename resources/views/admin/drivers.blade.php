<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chauffeurs - TripGo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .driver-card {
            transition: all 0.3s ease;
        }
        .driver-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-car text-indigo-900 text-xl font-bold"></i>
                    </div>
                    <span class="text-xl font-bold">TripGo Admin</span>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                    <a href="{{ route('admin.drivers') }}" class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 rounded-lg">
                        <i class="fas fa-id-card"></i>
                        <span>Chauffeurs</span>
                    </a>
                    <a href="{{ route('admin.trips') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-route"></i>
                        <span>Trajets</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Chauffeurs</h1>
                    <div class="flex items-center space-x-4">
                        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un chauffeur
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg p-4 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Actifs</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $drivers->where('status', 'active')->count() }}</p>
                            </div>
                            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">En attente</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $drivers->where('status', 'pending')->count() }}</p>
                            </div>
                            <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border-l-4 border-red-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Inactifs</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $drivers->where('status', 'inactive')->count() }}</p>
                            </div>
                            <i class="fas fa-ban text-red-500 text-2xl"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border-l-4 bg-indigo-600 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm">Total</p>
                                <p class="text-2xl font-bold">{{ $drivers->count() }}</p>
                            </div>
                            <i class="fas fa-car text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" placeholder="Rechercher un chauffeur..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option>Tous les statuts</option>
                                <option>Actif</option>
                                <option>En attente</option>
                                <option>Inactif</option>
                            </select>
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option>Toutes les villes</option>
                                <option>Casablanca</option>
                                <option>Rabat</option>
                                <option>Marrakech</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Drivers Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($drivers as $driver)
                        <div class="driver-card bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://picsum.photos/seed/driver{{ $driver->id }}/50/50" alt="{{ $driver->user->name }}" 
                                             class="w-12 h-12 rounded-full">
                                        <div>
                                            <h3 class="font-semibold text-gray-800">{{ $driver->user->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $driver->ville }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($driver->status === 'active') bg-green-100 text-green-800
                                        @elseif($driver->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($driver->status) }}
                                    </span>
                                </div>

                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-phone w-5 text-gray-400"></i>
                                        <span>{{ $driver->user->phone ?? 'Non défini' }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-envelope w-5 text-gray-400"></i>
                                        <span class="truncate">{{ $driver->user->email }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-car w-5 text-gray-400"></i>
                                        <span>{{ $driver->vehicle->vehicle_plate }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-id-card w-5 text-gray-400"></i>
                                        <span>{{ $driver->license_number }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t">
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-sm 
                                                @if($i <= 4) text-yellow-400 @else text-gray-300 @endif"></i>
                                        @endfor
                                        <span class="text-xs text-gray-600 ml-1">(4.8)</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($driver->status === 'pending')
                                            <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Approuver">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</body>
</html>