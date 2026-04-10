<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TripGo</title>
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
            animation: slideUp 0.6s ease-out;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sidebar -->
    <div class="flex h-screen">
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
                        class="flex items-center space-x-3 px-4 py-3 bg-indigo-800 rounded-lg">
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
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-route"></i>
                        <span>Trajets</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statistiques</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-800 rounded-lg transition-colors">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
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
            <header class="bg-white shadow-sm border-b">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <button class="p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-slide-up">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Utilisateurs</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $users_count }}</p>
                                <p class="text-sm text-green-600 mt-2">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +12% ce mois
                                </p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-full">
                                <i class="fas fa-users text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-slide-up"
                        style="animation-delay: 0.1s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Chauffeurs</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $drivers_count }}</p>
                                <p class="text-sm text-green-600 mt-2">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +8% ce mois
                                </p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-full">
                                <i class="fas fa-id-card text-green-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-slide-up"
                        style="animation-delay: 0.2s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Trajets</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $trips_count }}</p>
                                <p class="text-sm text-green-600 mt-2">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    +25% ce mois
                                </p>
                            </div>
                            <div class="bg-yellow-500 p-4 rounded-full">
                                <i class="fas fa-route text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Activité Récente</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Nouveau chauffeur inscrit</p>
                                    <p class="text-xs text-gray-500">Il y a 2 minutes</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Nouveau trajet créé</p>
                                    <p class="text-xs text-gray-500">Il y a 5 minutes</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Nouvel utilisateur inscrit</p>
                                    <p class="text-xs text-gray-500">Il y a 10 minutes</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions Rapides</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                <i class="fas fa-user-plus text-indigo-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium">Ajouter Utilisateur</p>
                            </button>
                            <button class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <i class="fas fa-car text-green-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium">Ajouter Chauffeur</p>
                            </button>
                            <button class="p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                                <i class="fas fa-chart-line text-yellow-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium">Voir Rapports</p>
                            </button>
                            <button class="p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl mb-2"></i>
                                <p class="text-sm font-medium">Signalements</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>