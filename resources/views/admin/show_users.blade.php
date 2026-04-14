<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Utilisateur - TripGo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c7c7c7;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar (Même que le dashboard) -->
        <aside class="w-64 bg-indigo-900 text-white flex-shrink-0">
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
                        <i class="fas fa-tachometer-alt w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 rounded-lg">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span>Utilisateurs</span>
                    </a>
                    <a href="{{ route('admin.drivers') }}"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-id-card w-5 text-center"></i>
                        <span>Chauffeurs</span>
                    </a>
                    <a href="{{ route('admin.trips') }}"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-route w-5 text-center"></i>
                        <span>Trajets</span>
                    </a>
                </nav>
            </div>

            <div class="absolute bottom-0 w-64 p-6 border-t border-indigo-800">
                <div class="flex items-center space-x-3">
                    <img src="https://picsum.photos/seed/admin/40/40" alt="Admin" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold">Admin User</p>
                        <p class="text-xs text-indigo-300">admin@tripgo.com</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b sticky top-0 z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.users') }}"
                            class="text-gray-500 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-800">Profil Utilisateur</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </header>

            <div class="p-6">
                <!-- Profil Header -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 animate-slide-up"
                    style="animation-delay: 0s">
                    <!-- Bannière -->
                    <div class="h-32 bg-gradient-to-r from-indigo-600 to-purple-600 relative">
                        <!-- Boutons d'action sur la bannière -->
                        <div class="absolute top-4 right-4 flex space-x-2">
                            <button
                                class="bg-white/20 hover:bg-white/40 text-white px-4 py-2 rounded-lg text-sm font-medium backdrop-blur-sm transition-colors">
                                <i class="fas fa-pen mr-2"></i>Modifier
                            </button>
                            <button
                                class="bg-red-500/80 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium backdrop-blur-sm transition-colors">
                                <i class="fas fa-ban mr-2"></i>Suspendre
                            </button>
                        </div>
                    </div>

                    <!-- Info principale -->
                    <div class="max-w-6xl mx-auto px-6 pb-6">
                        <div
                            class="flex flex-col md:flex-row items-center md:items-end space-y-4 md:space-y-0 md:space-x-6 -mt-16">
                            <!-- Avatar -->
                            <div class="relative">
                                <img src="https://picsum.photos/seed/{{ $user->id }}/150/150" alt="{{ $user->name }}"
                                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                                <span
                                    class="absolute bottom-2 right-2 w-5 h-5 {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} border-2 border-white rounded-full"></span>
                            </div>

                            <!-- Nom & Stats rapides -->
                            <div class="flex-1 text-center md:text-left pb-2">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                                <p class="text-gray-500">{{ $user->email }}</p>
                                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3 text-sm">
                                    <span class="text-gray-600"><i class="fas fa-calendar-alt mr-1 text-indigo-500"></i>
                                        Inscrit le {{ $user->created_at->format('d M Y') }}</span>
                                    <span class="text-gray-600"><i class="fas fa-phone mr-1 text-indigo-500"></i>
                                        {{ $user->phone ?? 'Non renseigné' }}</span>
                                        @if($user->role == "driver")
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->driver->is_verified ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $user->driver->is_verified ? 'Actif' : 'Suspendu' }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grille : Stats + Infos personnelles -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Statistiques du compte -->
                    <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-4 gap-6 animate-slide-up"
                        style="animation-delay: 0.1s">
                        <div class="stat-card bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Total Dépensé</p>
                                    <p class="text-2xl font-bold text-gray-800 mt-2">
                                        {{ number_format($user->trips->where('status', 'terminer')->sum('price'), 0, ',', ' ') }}
                                        MAD</p>
                                </div>
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <i class="fas fa-wallet text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Trajets Effectués</p>
                                    <p class="text-2xl font-bold text-gray-800 mt-2">
                                        {{ $user->trips->where('status', 'terminer')->count() }}</p>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Trajets en Cours</p>
                                    <p class="text-2xl font-bold text-gray-800 mt-2">
                                        {{ $user->trips->where('status', 'encours')->count() }}</p>
                                </div>
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <i class="fas fa-spinner text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Trajets à Venir</p>
                                    <p class="text-2xl font-bold text-gray-800 mt-2">
                                        {{ $user->trips->where('status', 'avenir')->count() }}</p>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détails & Historique -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Informations Personnelles -->
                    <div class="bg-white rounded-xl shadow-md p-6 h-fit animate-slide-up" style="animation-delay: 0.2s">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-indigo-500 mr-2"></i> Informations
                        </h3>
                        <div class="space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                                <span class="text-gray-500 text-sm">Téléphone</span>
                                <span
                                    class="text-sm font-medium text-gray-800">{{ $user->phone ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                                <span class="text-gray-500 text-sm">Ville</span>
                                <span
                                    class="text-sm font-medium text-gray-800">{{ $user->ville ?? 'Non renseignée' }}</span>
                            </div>
                            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                                <span class="text-gray-500 text-sm">Postale Code</span>
                                <span
                                    class="text-sm font-medium text-gray-800">{{ $user->postal_code ?? 'Non renseigné' }}</span>
                            </div>


                        </div>
                    </div>

                    <!-- Historique des Trajets -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6 animate-slide-up"
                        style="animation-delay: 0.3s">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-route text-indigo-500 mr-2"></i> Historique des trajets
                            </h3>
                            <span class="text-sm text-gray-500">{{ $user->trips->count() }} trajets au total</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-gray-500 text-xs border-b uppercase tracking-wider">
                                        <th class="pb-3 font-medium">Départ</th>
                                        <th class="pb-3 font-medium">Destination</th>
                                        <th class="pb-3 font-medium">Date</th>
                                        <th class="pb-3 font-medium">Prix</th>
                                        <th class="pb-3 font-medium">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->trips->sortByDesc('created_at')->take(10) as $trip)
                                        <tr class="border-b last:border-0 hover:bg-gray-50 transition-colors">
                                            <td class="py-4 text-sm text-gray-800">{{ $trip->departure ?? 'N/A' }}</td>
                                            <td class="py-4 text-sm text-gray-800">{{ $trip->destination ?? 'N/A' }}</td>
                                            <td class="py-4 text-sm text-gray-500">
                                                {{ $trip->created_at->format('d M Y H:i') }}</td>
                                            <td class="py-4 text-sm font-semibold text-gray-800">{{ $trip->price }} MAD</td>
                                            <td class="py-4">
                                                @php
                                                    $statusConfig = [
                                                        'avenir' => ['color' => 'blue', 'icon' => 'clock', 'label' => 'À venir'],
                                                        'encours' => ['color' => 'yellow', 'icon' => 'spinner', 'label' => 'En cours'],
                                                        'terminer' => ['color' => 'green', 'icon' => 'check', 'label' => 'Terminé'],
                                                        'annule' => ['color' => 'red', 'icon' => 'times', 'label' => 'Annulé']
                                                    ];
                                                    $config = $statusConfig[$trip->status] ?? $statusConfig['avenir'];
                                                @endphp
                                                <span
                                                    class="px-3 py-1 text-xs rounded-full bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 font-medium">
                                                    <i class="fas fa-{{ $config['icon'] }} mr-1"></i>{{ $config['label'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if($user->trips->isEmpty())
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-400">
                                                <i class="fas fa-road text-4xl mb-3 block"></i>
                                                Cet utilisateur n'a effectué aucun trajet.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
