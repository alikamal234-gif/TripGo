<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trajets - TripGo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .trip-row:hover {
            background-color: #f9fafb;
        }

        .status-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
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
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                    <a href="{{ route('admin.drivers') }}"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-id-card"></i>
                        <span>Chauffeurs</span>
                    </a>
                    <a href="{{ route('admin.trips') }}"
                        class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 rounded-lg">
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
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Trajets</h1>
                    <div class="flex items-center space-x-4">
                        <button
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Exporter
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg p-4 text-center">
                        <i class="fas fa-route text-blue-500 text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                        <p class="text-sm text-gray-600">Total</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <i class="fas fa-clock text-yellow-500 text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['avenir'] }}
                       
                       
                        
                        </p>
                        <p class="text-sm text-gray-600">Lancés</p>
                    </div>
                   
                    <div class="bg-white rounded-lg p-4 text-center">
                        <i class="fas fa-car text-indigo-500 text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $stats['encours'] }}</p>
                        <p class="text-sm text-gray-600">En cours</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                                                <i class="fas fa-flag-checkered text-purple-500 text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['terminer'] }}</p>
                        <p class="text-sm text-gray-600">Terminés</p>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" placeholder="Rechercher un trajet..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option>Tous les statuts</option>
                                <option>En attente</option>
                                <option>Accepté</option>
                                <option>En cours</option>
                                <option>Terminé</option>
                                <option>Annulé</option>
                            </select>
                            <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                <i class="fas fa-filter mr-2"></i>
                                Filtres
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Trips Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passager</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chauffeur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trajet</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($trips as $trip)
                                    <tr class="trip-row transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ str_pad($trip->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img src="https://picsum.photos/seed/passenger{{ $trip->passenger->id }}/32/32" 
                                                     alt="{{ $trip->passenger->name }}" class="w-8 h-8 rounded-full mr-2">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $trip->passenger->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $trip->passenger->phone ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($trip->driver)
                                                <div class="flex items-center">
                                                    <img src="https://picsum.photos/seed/driver{{ $trip->driver->id }}/32/32" 
                                                         alt="{{ $trip->driver->name }}" class="w-8 h-8 rounded-full mr-2">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ $trip->driver->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $trip->driver?->voiture_marque }}</div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500">Non assigné</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm">
                                                <div class="flex items-center text-gray-900">
                                                    <i class="fas fa-map-marker-alt text-green-500 mr-1 text-xs"></i>
                                                    {{ Str::limit($trip->departureAddress->name, 20) }}
                                                </div>
                                                <div class="flex items-center text-gray-500 mt-1">
                                                    <i class="fas fa-flag-checkered text-red-500 mr-1 text-xs"></i>
                                                    {{ Str::limit($trip->destinationAddress->name, 20) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $trip->departure_time }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold text-gray-900">{{ $trip->price }} DH</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($trip->status === '') 

                                                @elseif($trip->status === 'avenir') 
                                                    bg-blue-100 text-blue-800
                                                @elseif($trip->status === 'encours') 
                                                    bg-indigo-100 text-indigo-800 status-badge
                                                @elseif($trip->status === 'terminer') 
                                                    bg-green-100 text-green-800
                                                @else 
                                                    bg-red-100 text-red-800
                                                @endif">
                                                {{ $trip->status === 'encours' ? 'En cours' :
        ($trip->status === 'terminer' ? 'Terminé' :
            ($trip->status === 'avenir' ? 'Accepté' : 'anuller'))
                                                   
                                                }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <button class="text-indigo-600 hover:text-indigo-900" title="Voir détails" 
                                                        onclick="showTripDetails({{ $trip->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($trip->status === 'pending')
                                                    <button class="text-green-600 hover:text-green-900" title="Assigner chauffeur">
                                                        <i class="fas fa-user-plus"></i>
                                                    </button>
                                                @endif
                                                @if($trip->status === 'in_progress')
                                                    <button class="text-yellow-600 hover:text-yellow-900" title="Suivre en temps réel">
                                                        <i class="fas fa-location-arrow"></i>
                                                    </button>
                                                @endif
                                                <button class="text-gray-600 hover:text-gray-900" title="Plus d'actions">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t">
                        <div class="text-sm text-gray-700">
                            Affichage de
                            <span class="font-medium">{{ $trips->firstItem() }}</span> à
                            <span class="font-medium">{{ $trips->lastItem() }}</span> sur
                            <span class="font-medium">{{ $trips->total() }}</span> résultats
                        </div>
                        <div>
                            {{ $trips->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Trip Details -->
    <div id="tripModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Détails du Trajet</h3>
                    <button onclick="closeTripModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div id="tripDetailsContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show trip details modal
        function showTripDetails(tripId) {
            const modal = document.getElementById('tripModal');
            const content = document.getElementById('tripDetailsContent');
            
            // Simulate loading trip details
            content.innerHTML = `
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Informations du trajet</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">ID Trajet:</span>
                                <span class="font-medium">#${String(tripId).padStart(5, '0')}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium">15/12/2023 14:30</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Prix:</span>
                                <span class="font-medium text-green-600">150 DH</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Passagers:</span>
                                <span class="font-medium">2</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Passager</h4>
                            <div class="flex items-center space-x-3">
                                <img src="https://picsum.photos/seed/passenger${tripId}/40/40" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-medium">Jean Dupont</p>
                                    <p class="text-sm text-gray-600">+212 6XX-XXXXXX</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Chauffeur</h4>
                            <div class="flex items-center space-x-3">
                                <img src="https://picsum.photos/seed/driver${tripId}/40/40" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-medium">Mohamed Ali</p>
                                    <p class="text-sm text-gray-600">Toyota Camry</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Itinéraire</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                <span class="text-sm">Casablanca, Centre Ville</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-flag-checkered text-red-500 mr-2"></i>
                                <span class="text-sm">Rabat, Agdal</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button onclick="closeTripModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            Fermer
                        </button>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer
                        </button>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
        }
        
        // Close trip modal
        function closeTripModal() {
            document.getElementById('tripModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('tripModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTripModal();
            }
        });
    </script>
</body>
</html>