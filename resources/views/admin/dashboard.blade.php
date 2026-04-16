<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TripGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0; /* Pour que l'animation fonctionne bien avec les delays */
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Style pour la scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex-shrink-0">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-car text-indigo-900 text-xl font-bold"></i>
                    </div>
                    <span class="text-xl font-bold">TripGo Admin</span>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 rounded-lg">
                        <i class="fas fa-tachometer-alt w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span>Utilisateurs</span>
                    </a>
                    <a href="{{ route('admin.drivers') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-id-card w-5 text-center"></i>
                        <span>Chauffeurs</span>
                    </a>
                    <a href="{{ route('admin.trips') }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-route w-5 text-center"></i>
                        <span>Trajets</span>
                    </a>
                </nav>
            </div>

            <div class="absolute bottom-0 w-64 p-6 border-t border-indigo-800">
                <div class="flex items-center space-x-3">
                    <img src="https://picsum.photos/seed/admin/40/40" alt="Admin" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-indigo-300">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b sticky top-0 z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500"><i class="far fa-calendar-alt mr-2"></i>{{ now()->format('d M Y') }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg relative w-8 h-8 flex items-center justify-center">
                                <i class="fas fa-power-off text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="p-6">
                <!-- Ligne 1: Stats Principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Utilisateurs -->
                    <div class="stat-card bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Utilisateurs</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $users_count }}</p>
                                <p class="text-sm text-green-600 mt-2">
                                    <i class="fas fa-arrow-up mr-1"></i>+{{ $users_today }} aujourd'hui
                                </p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-full">
                                <i class="fas fa-users text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Chauffeurs -->
                    <div class="stat-card bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.1s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Chauffeurs</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $drivers_count }}</p>
                                <p class="text-sm text-orange-500 mt-2">
                                    <i class="fas fa-clock mr-1"></i>{{ $drivers_unverified }} en attente
                                </p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-full">
                                <i class="fas fa-id-card text-green-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Trajets -->
                    <div class="stat-card bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.2s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Trajets</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $trips_count }}</p>
                                <p class="text-sm text-green-600 mt-2">
                                    <i class="fas fa-arrow-up mr-1"></i>+{{ $trips_today }} aujourd'hui
                                </p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-full">
                                <i class="fas fa-route text-yellow-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Revenus -->
                    <div class="stat-card bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.3s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Revenus Totaux</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($total_revenue, 0, ',', ' ') }} <span class="text-lg">MAD</span></p>
                                <p class="text-sm text-green-600 mt-2">
                                    <i class="fas fa-arrow-up mr-1"></i>{{ number_format($revenue_today, 0, ',', ' ') }} MAD aujourd'hui
                                </p>
                            </div>
                            <div class="bg-purple-100 p-4 rounded-full">
                                <i class="fas fa-wallet text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ligne 2: Graphiques & Résumés -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Répartition des Trajets -->
                    <div class="bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.4s">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Statut des trajets</h2>
                        <div class="flex justify-center items-center h-48">
                            <canvas id="tripsChart"></canvas>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mt-4 text-center text-xs">
                            <div class="bg-blue-50 text-blue-700 p-2 rounded">À venir<br><span class="font-bold text-sm">{{ $trips_avenir }}</span></div>
                            <div class="bg-yellow-50 text-yellow-700 p-2 rounded">En cours<br><span class="font-bold text-sm">{{ $trips_encours }}</span></div>
                            <div class="bg-green-50 text-green-700 p-2 rounded">Terminés<br><span class="font-bold text-sm">{{ $trips_terminer }}</span></div>
                        </div>
                    </div>

                    <!-- Vérification Chauffeurs -->
                    <div class="bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.5s">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Vérification Chauffeurs</h2>
                        <div class="flex justify-center items-center h-48">
                            <canvas id="driversChart"></canvas>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-4 text-center text-xs">
                            <div class="bg-green-50 text-green-700 p-2 rounded">Vérifiés<br><span class="font-bold text-sm">{{ $drivers_verified }}</span></div>
                            <div class="bg-red-50 text-red-700 p-2 rounded">Non vérifiés<br><span class="font-bold text-sm">{{ $drivers_unverified }}</span></div>
                        </div>
                    </div>

                    <!-- Actions Rapides -->
                    <div class="bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.6s">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions Rapides</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.users') }}" class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors text-center">
                                <i class="fas fa-users text-indigo-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-700">Gérer Utilisateurs</p>
                            </a>
                            <a href="{{ route('admin.drivers') }}" class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors text-center">
                                <i class="fas fa-id-card text-green-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-700">Vérifier Chauffeurs</p>
                            </a>
                            <a href="{{ route('admin.trips') }}" class="p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors text-center">
                                <i class="fas fa-route text-yellow-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-700">Voir Trajets</p>
                            </a>
                            <button class="p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors text-center">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-700">Signalements</p>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Ligne 3: Données Récentes -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Trajets Récents -->
                    <div class="bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.7s">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Trajets Récents</h2>
                            {{-- <a href="{{ route('admin.trips') }}" class="text-sm text-indigo-600 hover:underline">Voir tout</a> --}}
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-gray-500 text-xs border-b">
                                        <th class="pb-2 font-medium">Passager</th>
                                        <th class="pb-2 font-medium">Chauffeur</th>
                                        <th class="pb-2 font-medium">Prix</th>
                                        <th class="pb-2 font-medium">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_trips as $trip)
                                    <tr class="border-b last:border-0 hover:bg-gray-50">
                                        <td class="py-3 text-sm">{{ $trip->passenger->name ?? '-' }}</td>
                                        <td class="py-3 text-sm">{{ $trip->driver->name ?? '-' }}</td>
                                        <td class="py-3 text-sm font-medium">{{ $trip->price }} MAD</td>
                                        <td class="py-3">
                                            @php
    $statusColor = ['avenir' => 'blue', 'encours' => 'yellow', 'terminer' => 'green'][$trip->status] ?? 'gray';
    $statusLabel = ['avenir' => 'À venir', 'encours' => 'En cours', 'terminer' => 'Terminé'][$trip->status] ?? $trip->status;
                                            @endphp
                                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Nouveaux Utilisateurs -->
                    <div class="bg-white rounded-xl shadow-md p-6 animate-slide-up" style="animation-delay: 0.8s">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Nouveaux Utilisateurs</h2>
                            {{-- <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:underline">Voir tout</a> --}}
                        </div>
                        <div class="space-y-3">
                            @foreach($recent_users as $user)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Script pour les Graphiques -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Configuration globale des charts
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#6b7280';

            // Graphique des Trajets (Donut)
            const tripsCtx = document.getElementById('tripsChart').getContext('2d');
            new Chart(tripsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['À venir', 'En cours', 'Terminés'],
                    datasets: [{
                        data: [{{ $trips_avenir }}, {{ $trips_encours }}, {{ $trips_terminer }}],
                        backgroundColor: ['#3b82f6', '#f59e0b', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Graphique des Chauffeurs (Donut)
            const driversCtx = document.getElementById('driversChart').getContext('2d');
            new Chart(driversCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Vérifiés', 'Non vérifiés'],
                    datasets: [{
                        data: [{{ $drivers_verified }}, {{ $drivers_unverified }}],
                        backgroundColor: ['#10b981', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</body>

</html>
