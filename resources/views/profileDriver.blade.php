<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Passager</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Configuration Tailwind (Colors) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        indigo: {
                            50: '#FFFBEB',
                            100: '#FEF3C7',
                            500: '#FBBF24',
                            600: '#D97706',
                            700: '#B45309',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased h-screen flex flex-col">


    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-between">
            <!-- Back Button -->
            <button onclick="history.back()" class="text-gray-600 hover:text-indigo-600 transition p-2">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>

            <!-- Page Title -->
            <h1 class="text-lg font-bold text-gray-800">Détails Driver</h1>

            <!-- Placeholder for Balance/Settings -->
            <div></div>
        </div>
    </header>


    <main class="flex-1 overflow-y-auto pb-20">
        <div class="max-w-md mx-auto p-4">

            <!-- --- PASSENGER PROFILE CARD --- -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-6">

                <!-- Header Image/Gradient -->
                <div class="relative bg-gradient-to-r from-indigo-500 to-purple-600 h-32">
                    <!-- Decorative Icon -->
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                </div>

                <!-- Profile Info -->
                <div class="relative px-6 pb-6">
                    <!-- Avatar -->
                    <div class="relative -mt-16 mb-4 flex justify-center">
                        <div class="relative">
                            <img src="{{ 'https://i.pravatar.cc/150?img=12' }}"
                                alt="driver"
                                class="w-28 h-28 rounded-full border-4 border-white shadow-md object-cover">
                            <!-- Online Status -->
                            <span
                                class="absolute bottom-2 right-2 w-5 h-5 bg-green-500 border-4 border-white rounded-full"></span>
                        </div>
                    </div>
                    @php
$rating = $driver->trips->avg('rating');
$rating = round($rating ?? 0, 1);
                    @endphp
                    <!-- Name & Stats -->
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $driver->user->name }}</h2>
                        <div class="flex items-center justify-center mt-2 space-x-2">
                            <div class="flex items-center">
                                <div class="flex text-base space-x-0.5">
                                    <!-- 2. Boucle pour les 5 étoiles -->
                                    @for ($i = 1; $i <= 5; $i++)

                                        @if ($rating >= $i)
                                            <i class="fas fa-star text-yellow-400 drop-shadow-sm"></i>
                                        @elseif ($rating >= ($i - 0.5))
                                            <i class="fas fa-star-half-alt text-yellow-400 drop-shadow-sm"></i>
                                        @else
                                            <i class="far fa-star text-gray-300"></i>
                                        @endif

                                    @endfor
                                </div>

                                <!-- Optionnel: Afficher la note chiffrée à côté -->
                                <span class="ml-2 text-sm font-bold text-gray-700">
                                    {{ $rating > 0 ? $rating : '-' }}
                                </span>
                            </div>

                            <span class="text-gray-400 text-xs">({{ $driver->trips->count() ?? 0 }} trajets)</span>
                        </div>
                    </div>

                    <!-- Call Button -->
                    <a href="tel:{{ $driver->user->phone }}"
                        class="flex items-center justify-center w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold py-3.5 rounded-xl mb-6 transition-colors border border-indigo-200 group">
                        <i class="fas fa-phone-alt mr-3 text-indigo-600 group-hover:rotate-12 transition-transform"></i>
                        {{ $driver->user->phone ?? '+212 600 000 000' }}
                    </a>

                    <!-- Vehicle/Trip Details Section -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-200">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Véhicule cible</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-sm border border-gray-200">
                                    <i class="fas fa-car text-gray-400 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $driver->vehicle->type ?? 'Peugeot 208' }}
                                    </p>
                                    <p class="text-xs text-gray-500 font-mono">
                                        {{ $driver->vehicle->vehicle_plate ?? '12345 A 10' }}</p>
                                </div>
                            </div>
                            <button class="text-indigo-600 hover:bg-indigo-100 p-2 rounded-full transition">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Other Info Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Info Item 1 -->
                        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 text-center">
                            <p class="text-xs text-gray-400 mb-1">Membre depuis</p>
                            <p class="font-bold text-gray-700 text-sm">{{ $driver->created_at }}</p>
                        </div>
                        <!-- Info Item 2 -->
                        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 text-center">
                            <p class="text-xs text-gray-400 mb-1">Role</p>
                            <p class="font-bold text-gray-700 text-sm">Driver</p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- --- END CARD --- -->

            <!-- Action Buttons (Optional - e.g. Report Passenger) -->
            <div class="flex gap-4 mb-6">
                <button
                    class="flex-1 bg-white border border-red-200 text-red-500 font-semibold py-3 rounded-lg hover:bg-red-50 transition">
                    <i class="fas fa-flag mr-2"></i> Signaler
                </button>
                <button
                    class="flex-1 bg-white border border-gray-200 text-gray-600 font-semibold py-3 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-ban mr-2"></i> Bloquer
                </button>
            </div>

        </div>
    </main>



</body>

</html>
