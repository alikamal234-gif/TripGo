<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - TripGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        .tripgo-yellow {
            background-color: #FFD500;
        }

        .tripgo-black {
            background-color: #121212;
        }

        .tripgo-black-text {
            color: #121212;
        }

        .sidebar-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover,
        .sidebar-item.active {
            background-color: rgba(255, 213, 0, 0.15);
            border-left: 3px solid #FFD500;
        }

        .notif-card {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .notif-card:hover {
            transform: translateX(4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .notif-card.type-trip_created {
            border-left-color: #3b82f6;
        }

        /* Bleu */
        .notif-card.type-trip_accepted {
            border-left-color: #10b981;
        }

        /* Vert */
        .notif-card.type-trip_refused {
            border-left-color: #ef4444;
        }

        /* Rouge */
        .notif-card.type-trip_finished {
            border-left-color: #8b5cf6;
        }

        /* Violet */

        .notif-card.unread {
            background-color: #f0f9ff;
        }
    </style>
</head>

<body class="flex h-screen">

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
                <a href="/"
                    class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                    <i class="fas fa-arrow-left w-5"></i><span>Retour au home</span>
                </a>
                <a href="#" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                    <i class="fas fa-bell w-5"></i><span>Notifications</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b sticky top-0 z-10">
            <div class="px-6 py-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold tripgo-black-text">Notifications</h2>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition">
                        <i class="fas fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
<div class="max-w-3xl mx-auto p-6">

    @if($notifications->count() > 0)
        <div class="space-y-4">
            @foreach ($notifications as $notif)

                <!-- CARTE : TRIP CRÉÉ (Pour le passager qui l'a créé) -->
                @if ($notif->type == 'trip_created')
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">{{ $notif->message }}</h4>
                                @if($notif->trip)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-gray-50 rounded-lg p-2.5 mb-2">
                                        <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                                        <span>{{ $notif->trip->departureAddress->name ?? 'Inconnu' }}</span>
                                        <i class="fas fa-arrow-right text-gray-300 text-xs"></i>
                                        <i class="fas fa-map-pin text-green-400 text-xs"></i>
                                        <span>{{ $notif->trip->destinationAddress->name ?? 'Inconnu' }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-xs text-gray-400">
                                        <span><i
                                                class="far fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($notif->trip->departure_time)->format('d M Y à H:i') }}</span>
                                        <span><i class="fas fa-euro-sign mr-1"></i>{{ number_format($notif->trip->price, 2) }} €</span>
                                        <span class="ml-auto time-ago" data-time="{{ $notif->created_at->toIso8601String() }}"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- CARTE : TRIP ACCEPTÉ (Pour les deux) -->
                @elseif ($notif->type == 'trip_accepted' && $notif->user_id == auth()->id())
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">{{ $notif->message }}</h4>
                                <p class="text-sm text-gray-500 mb-2">Par <span
                                        class="font-semibold text-gray-700">{{ $notif->trip->driver->name ?? '' }}</span></p>

                                @if($notif->trip)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-gray-50 rounded-lg p-2.5 mb-2">
                                        <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                                        <span>{{ $notif->trip->departureAddress->name ?? 'Inconnu' }}</span>
                                        <i class="fas fa-arrow-right text-gray-300 text-xs"></i>
                                        <i class="fas fa-map-pin text-green-400 text-xs"></i>
                                        <span>{{ $notif->trip->destinationAddress->name ?? 'Inconnu' }}</span>
                                    </div>

                                    <!-- Affichage du véhicule uniquement si accepté -->
                                    @if($notif->driver_vehicle)
                                        <div
                                            class="flex items-center gap-2 text-sm text-blue-700 bg-blue-50 border border-blue-100 rounded-lg p-2.5 mb-2">
                                            <i class="fas fa-car"></i>
                                            <span class="font-medium">{{ $notif->driver_vehicle->type }}</span>
                                            <span class="text-blue-400">|</span>
                                            <span>{{ $notif->driver_vehicle->vehicle_plate }}</span>
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-4 text-xs text-gray-400">
                                        <span><i
                                                class="far fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($notif->trip->departure_time)->format('d M Y à H:i') }}</span>
                                        <span><i class="fas fa-euro-sign mr-1"></i>{{ number_format($notif->trip->price, 2) }} €</span>
                                        <span class="ml-auto time-ago" data-time="{{ $notif->created_at->toIso8601String() }}"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @elseif ($notif->type == 'trip_refused' && $notif->trip->user_id == auth()->id())
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1 text-red-700">{{ $notif->message }}</h4>
                                <p class="text-sm text-gray-500 mb-2">Par <span
                                        class="font-semibold text-gray-700">{{ $notif->author_name ?? '' }}</span></p>

                                @if($notif->trip)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-gray-50 rounded-lg p-2.5 mb-2">
                                        <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                                        <span>{{ $notif->trip->departureAddress->name ?? 'Inconnu' }}</span>
                                        <i class="fas fa-arrow-right text-gray-300 text-xs"></i>
                                        <i class="fas fa-map-pin text-green-400 text-xs"></i>
                                        <span>{{ $notif->trip->destinationAddress->name ?? 'Inconnu' }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-xs text-gray-400">
                                        <span class="ml-auto time-ago" data-time="{{ $notif->created_at->toIso8601String() }}"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- CARTE : TRIP TERMINÉ -->
                @elseif ($notif->type == 'trip_finished' && $notif->trip->driver_id == auth()->id() || $notif->trip->passenger_id == auth()->id())
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">{{ $notif->message }}</h4>

                                @if($notif->trip)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-gray-50 rounded-lg p-2.5 mb-2">
                                        <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                                        <span>{{ $notif->trip->departureAddress->name ?? 'Inconnu' }}</span>
                                        <i class="fas fa-arrow-right text-gray-300 text-xs"></i>
                                        <i class="fas fa-map-pin text-green-400 text-xs"></i>
                                        <span>{{ $notif->trip->destinationAddress->name ?? 'Inconnu' }}</span>
                                    </div>

                                    <div class="flex items-center gap-4 text-xs text-gray-400">
                                        <span class="text-green-500 font-semibold"><i
                                                class="fas fa-euro-sign mr-1"></i>{{ number_format($notif->trip->price, 2) }} €
                                            payés</span>
                                        <span class="ml-auto time-ago" data-time="{{ $notif->created_at->toIso8601String() }}"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    @else
        <!-- État vide -->
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-bell-slash text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune notification</h3>
            <p class="text-gray-400 max-w-sm">Vous n'avez pas encore de notifications.</p>
        </div>
    @endif

</div>
    </div>

    <script>
        function updateTimeAgo() {
            const timeElements = document.querySelectorAll('.time-ago');
            timeElements.forEach(el => {
                const past = new Date(el.dataset.time);
                const now = new Date();
                const diffMs = now - past;
                const diffMins = Math.floor(diffMs / 60000);
                const diffHours = Math.floor(diffMins / 60);
                const diffDays = Math.floor(diffHours / 24);

                let timeString = "";
                if (diffMins < 1) timeString = "À l'instant";
                else if (diffMins < 60) timeString = `Il y a ${diffMins} min`;
                else if (diffHours < 24) timeString = `Il y a ${diffHours} h`;
                else if (diffDays === 1) timeString = "Hier";
                else timeString = `Il y a ${diffDays} j`;

                el.textContent = timeString;
            });
        }

        document.addEventListener('DOMContentLoaded', updateTimeAgo);
        setInterval(updateTimeAgo, 60000);
    </script>
</body>

</html>