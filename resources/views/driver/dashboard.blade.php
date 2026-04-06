<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inDrive - Espace Chauffeur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'indrive-yellow': '#FFD600',
                        'indrive-dark': '#2C2C2C',
                        'indrive-gray': '#F5F5F5',
                    }
                }
            }
        }
    </script>
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

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse 2s infinite;
        }

        #driverMap {
            height: 400px;
            border-radius: 12px;
            z-index: 1;
            position: relative;
        }

        .leaflet-container {
            background: white !important;
            border-radius: 12px !important;
        }

        .leaflet-control-attribution {
            background: rgba(255, 255, 255, 0.8) !important;
            color: #333 !important;
            font-size: 11px !important;
            padding: 2px 4px !important;
        }

        .custom-div-icon {
            background: transparent !important;
            border: none !important;
        }

        .trip-card {
            transition: all 0.3s ease;
        }

        .trip-card:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .new-trip {
            animation: pulse 2s infinite;
            border: 2px solid #FFD600;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #FFD600 0%, #FFC107 100%);
        }

        .leaflet-pane {
            z-index: auto !important;
        }

        .leaflet-map-pane {
            z-index: 1 !important;
        }

        .status-badge {
            animation: pulse 2s infinite;
        }

        .notification-dot {
            animation: pulse 1.5s infinite;
        }

        .leaflet-popup {
            z-index: 1000 !important;
        }

        .leaflet-marker-pane {
            z-index: 600;
        }

        .leaflet-popup-pane {
            z-index: 700;
        }

        .leaflet-marker-pane {
            z-index: 600 !important;
        }

        .leaflet-popup-pane {
            z-index: 700 !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-white to-indrive-gray min-h-screen">
    <!-- Driver Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indrive-yellow rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-black text-xl font-bold"></i>
                    </div>
                    <span class="text-indrive-dark font-bold text-xl">inDrive</span>
                    <span
                        class="bg-indrive-yellow text-black px-2 py-1 rounded-full text-xs font-bold ml-2">CHAUFFEUR</span>
                </div>

                <!-- Driver Info -->
                <div class="flex items-center space-x-6">
                    <!-- Earnings -->
                    <div class="hidden md:flex items-center space-x-2 bg-indrive-gray px-4 py-2 rounded-lg">
                        <i class="fas fa-euro-sign text-indrive-yellow"></i>
                        <span class="font-bold text-indrive-dark">142.50€</span>
                        <span class="text-xs text-gray-600">aujourd'hui</span>
                    </div>

                    <!-- Notifications -->
                    <div class="relative">
                        <button class="relative p-2 hover:bg-indrive-gray rounded-lg transition-colors">
                            <i class="fas fa-bell text-indrive-dark text-xl"></i>
                            <span
                                class="notification-dot absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>

                    <!-- Profile -->
                    <div class="flex items-center space-x-3">
                        <img src="https://picsum.photos/seed/driver123/40/40.jpg" alt="Profile"
                            class="w-10 h-10 rounded-full border-2 border-indrive-yellow">
                        <div class="hidden md:block">
                            <p class="font-bold text-indrive-dark">Marc Dubois</p>
                            <p class="text-xs text-green-600 flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En ligne
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Map & Stats -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Map Section -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-indrive-dark">Trajets disponibles</h2>
                        <div class="flex items-center space-x-2">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-circle text-green-500 text-xs mr-1"></i>
                                {{ $trips->count() }} nouveaux trajets
                            </span>
                        </div>
                    </div>
                    <div id="driverMap" class="rounded-xl"></div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white rounded-xl p-4 text-center">
                        <i class="fas fa-route text-indrive-yellow text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-indrive-dark">12</p>
                        <p class="text-sm text-gray-600">Trajets aujourd'hui</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 text-center">
                        <i class="fas fa-star text-indrive-yellow text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-indrive-dark">4.9</p>
                        <p class="text-sm text-gray-600">Note moyenne</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 text-center">
                        <i class="fas fa-clock text-indrive-yellow text-2xl mb-2"></i>
                        <p class="text-2xl font-bold text-indrive-dark">6h</p>
                        <p class="text-sm text-gray-600">Temps en ligne</p>
                    </div>
                </div>

                <!-- NOUVELLE SECTION : MES TRAJETS ACCEPTÉS -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-indrive-dark">Mes trajets acceptés</h2>
                        <div class="flex items-center space-x-2">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-check-circle text-blue-500 text-xs mr-1"></i>
                                3 trajets en cours
                            </span>
                        </div>
                    </div>

                    <!-- Liste des trajets acceptés -->
                    <div class="space-y-4">
                        <!-- Trajet accepté 1 - En cours -->
                        <div class="border-2 border-blue-500 bg-blue-50 rounded-xl p-4">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <img src="https://picsum.photos/seed/accepted1/40/40.jpg" alt="Passager"
                                            class="w-10 h-10 rounded-full">
                                        <span class="absolute -bottom-1 -right-1 bg-blue-500 text-white rounded-full p-1">
                                            <i class="fas fa-phone text-xs"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-indrive-dark">Sophie Martin</p>
                                        <p class="text-xs text-gray-600">⭐ 4.9 • En route</p>
                                    </div>
                                </div>
                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    EN COURS
                                </span>
                            </div>

                            <div class="space-y-2 mb-3">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-map-marker-alt text-green-500 w-5"></i>
                                    <span class="text-gray-700 ml-2">15 Rue de la Paix, 75002 Paris</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-flag-checkered text-red-500 w-5"></i>
                                    <span class="text-gray-700 ml-2">Aéroport Charles de Gaulle, Terminal 2</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-blue-200">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-road mr-1"></i>28.5 km
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-clock mr-1"></i>35 min
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-indrive-yellow">45€</p>
                                    <p class="text-xs text-gray-600">confirmé</p>
                                </div>
                            </div>

                            <div class="flex space-x-2 mt-4">
                                <button class="flex-1 bg-green-500 text-white font-bold py-2 rounded-lg hover:bg-green-600 transition-colors">
                                    <i class="fas fa-navigation mr-2"></i>
                                    Démarrer navigation
                                </button>
                                <button class="flex-1 bg-indrive-yellow text-black font-bold py-2 rounded-lg hover:bg-yellow-400 transition-colors">
                                    <i class="fas fa-comment mr-2"></i>
                                    Contacter
                                </button>
                            </div>
                        </div>

                        
                            <div class="flex items-center justify-between pt-3 border-t border-gray-300">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-road mr-1"></i>42.3 km
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-clock mr-1"></i>45 min
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-indrive-yellow">65€</p>
                                    <p class="text-xs text-gray-600">confirmé</p>
                                </div>
                            </div>

                            <div class="flex space-x-2 mt-4">
                                <button class="flex-1 bg-indrive-yellow text-black font-bold py-2 rounded-lg hover:bg-yellow-400 transition-colors">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Confirmer arrivée
                                </button>
                                <button class="flex-1 bg-gray-200 text-gray-700 font-bold py-2 rounded-lg hover:bg-gray-300 transition-colors">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Détails
                                </button>
                            </div>
                        </div>

                        <!-- Trajet accepté 3 - Terminé aujourd'hui -->
                        <div class="border-2 border-green-500 bg-green-50 rounded-xl p-4 opacity-75">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <img src="https://picsum.photos/seed/accepted3/40/40.jpg" alt="Passager"
                                        class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-bold text-indrive-dark">Marie Laurent</p>
                                        <p class="text-xs text-gray-600">⭐ 5.0 • Terminé à 11:45</p>
                                    </div>
                                </div>
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    TERMINÉ
                                </span>
                            </div>

                            <div class="space-y-2 mb-3">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-map-marker-alt text-green-500 w-5"></i>
                                    <span class="text-gray-700 ml-2">Tour Eiffel, Quai Branly</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-flag-checkered text-red-500 w-5"></i>
                                    <span class="text-gray-700 ml-2">Musée du Louvre, Rue de Rivoli</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-green-200">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-road mr-1"></i>4.2 km
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-clock mr-1"></i>15 min
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-indrive-yellow">18€</p>
                                    <p class="text-xs text-gray-600">payé</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-green-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <span class="text-sm text-gray-600 ml-2">Excellent trajet!</span>
                                </div>
                                <button class="text-indrive-yellow hover:text-yellow-400 transition-colors">
                                    <i class="fas fa-receipt"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton voir plus -->
                    <div class="mt-6 text-center">
                        <button class="text-indrive-yellow hover:text-yellow-400 font-semibold transition-colors">
                            Voir tous mes trajets <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column - Trips List -->
            <div class="space-y-6">
                <!-- Filter & Sort -->
                <div class="bg-white rounded-2xl shadow-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-indrive-dark">Nouveaux trajets</h3>
                        <button class="text-indrive-yellow hover:text-yellow-400 transition-colors">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>

                    <!-- Trips List -->
                    <div class="space-y-3 max-h-96 overflow-y-auto" id="tripsList">
                        <!-- Trip 1 - New -->

                        @php
                        $nouveau = true;
                        @endphp
                        @foreach($trips as $trip)


                        <div
                            class="trip-card bg-white border-2 border-indrive-yellow rounded-xl p-4 cursor-pointer new-trip">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <img src="https://picsum.photos/seed/passenger1/32/32.jpg" alt="Passenger"
                                        class="w-8 h-8 rounded-full">
                                    <div>
                                        <p class="font-bold text-indrive-dark">{{ $trip->passenger->name }}</p>
                                        {{-- <p class="text-xs text-gray-600">⭐ 4.8 • 23 trajets</p> --}}
                                    </div>
                                </div>
                                @if($nouveau)
                                <span
                                    class="bg-indrive-yellow text-black px-2 py-1 rounded-full text-xs font-bold animate-pulse-slow">
                                    NOUVEAU
                                </span>
                                @endif
                            </div>

                            <div class="space-y-2 items-start">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-map-marker-alt text-green-500 w-5"></i>
                                    <span class="text-gray-700 ml-2">{{ $trip->departureAddress->name }}  {{ $trip->id }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-flag-checkered text-red-500 w-5"></i>
                                    <span class="text-gray-700 ml-2">{{ $trip->destinationAddress->name }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-road mr-1"></i>5.2 km
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-clock mr-1"></i>{{ $trip->departue_time }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-indrive-yellow">{{ $trip->price }}</p>
                                    <p class="text-xs text-gray-600">proposé</p>
                                </div>
                            </div>

                            <div class="flex space-x-2 mt-3">
                                <form action="{{ route('trip.accept', $trip->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="flex-1 bg-indrive-yellow text-black font-bold py-2 rounded-lg hover:bg-yellow-400 transition-colors">
                                        Accepter
                                    </button>
                                </form>
                                <button
                                    class="flex-1 bg-gray-200 text-gray-700 font-bold py-2 rounded-lg hover:bg-gray-300 transition-colors">
                                    Détails
                                </button>
                            </div>
                        </div>
                        @php
                        $nouveau = false;
                        @endphp
                        @endforeach
                    </div>
                </div>
                <!-- Status Toggle -->
                <div class="bg-white rounded-2xl shadow-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-bold text-indrive-dark">Statut de disponibilité</p>
                            <p class="text-sm text-gray-600">Recevoir des demandes de trajets</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div
                                class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indrive-yellow">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-indrive-dark text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="w-10 h-10 bg-indrive-yellow rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-black text-xl font-bold"></i>
                    </div>
                    <span class="text-white font-bold text-xl">inDrive</span>
                    <span class="text-gray-400 ml-2">Espace Chauffeur</span>
                </div>
                <div class="flex space-x-6 text-gray-400">
                    <a href="#" class="hover:text-indrive-yellow transition-colors">Aide</a>
                    <a href="#" class="hover:text-indrive-yellow transition-colors">Support</a>
                    <a href="#" class="hover:text-indrive-yellow transition-colors">Mentions légales</a>
                </div>
            </div>
        </div>



    </footer>



</body>
<script>








    // Initialize Driver Map
    let driverMap;
    let driverMarkers = [];
    let tripMarkers = [];

    function initDriverMap() {

        // Clean up existing map
        if (driverMap) {
            driverMap.remove();
        }

        driverMarkers = [];
        tripMarkers = [];

        // Create map
        driverMap = L.map('driverMap', {
            center: [48.8566, 2.3522],
            zoom: 12,
            zoomControl: true
        });

        // Add tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(driverMap);

        // Driver icon
        const driverIcon = L.divIcon({
            html: '<div class="bg-indrive-yellow rounded-full p-3 shadow-lg"><i class="fas fa-car text-black text-xl"></i></div>',
            iconSize: [50, 50],
            className: 'custom-div-icon'
        });

        // Trip request icons
        const tripIcon = L.divIcon({
            html: '<div class="bg-green-500 rounded-full p-2 shadow-lg animate-pulse"><i class="fas fa-user text-white"></i></div>',
            iconSize: [35, 35],
            className: 'custom-div-icon'
        });

        // Sample trip locations
        const tripLocations = [
            @foreach ($trips as $trip)
            @php
            preg_match('/LatLng\((.*),\s*(.*)\)/', $trip->departureAddress->coordonnees, $matches1);
            @endphp
            {
                lat: {{ $matches1[1] }},
                lng: {{ $matches1[2] }},
                price: {{ $trip->price }},
                name : "{{ $trip->departureAddress->name }}",
                passenger : "{{ $trip->passenger->name }}"
                },
            @endforeach
        ];
        console.log(tripLocations)
        // Add trip markers
        tripLocations.forEach((trip) => {
            const marker = L.marker([trip.lat, trip.lng], { icon: tripIcon }).addTo(driverMap);

            marker.bindPopup(`
                <div class="text-center flex flex-col bg-black text-white p-4 rounded-xl">
                    <small class="text-white">passenger : ${trip.passenger}</small>
                    <small class="text-white">passenger : ${trip.name}</small>
                    <span class="text-indrive-yellow font-bold">price : ${trip.price} DH</span><br>
                </div>
            `);

            tripMarkers.push(marker);
        });

        // 🔥 GPS + DRIVER + LINES
        function getDriverCoords() {
            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        resolve([
                            position.coords.latitude,
                            position.coords.longitude
                        ]);
                    },
                    (error) => reject(error)
                );
            });
        }

        async function setDriver() {

            const coord = await getDriverCoords();

            // Move map to driver
            driverMap.setView(coord, 14);

            // Add driver marker
            const driverMarker = L.marker(coord, { icon: driverIcon }).addTo(driverMap);

            driverMarker
                .bindPopup('<b>Votre position</b><br>En ligne et disponible')
                .openPopup();

            driverMarkers.push(driverMarker);

            // Draw lines (driver → trips)
            tripLocations.forEach(trip => {

                L.polyline([
                    coord,
                    [trip.lat, trip.lng]
                ], {
                    color: '#FFD600',
                    weight: 3,
                    opacity: 0.6,
                    dashArray: '10, 10'
                }).addTo(driverMap);

            });

        }

        // Call driver function
        setDriver();
    }

    // Initialize map when DOM is loaded
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(initDriverMap, 100);

        // Simulate notifications
        setInterval(() => {
            const notificationDot = document.querySelector('.notification-dot');
            if (notificationDot) {
                notificationDot.style.display = notificationDot.style.display === 'none' ? 'block' : 'none';
            }
        }, 3000);
    });

    // Handle resize
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (driverMap) {
                driverMap.invalidateSize();
            }
        }, 250);
    });

    // Handle details buttons
    document.querySelectorAll('.trip-card button:last-child').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const card = this.closest('.trip-card');
            const passengerName = card.querySelector('.font-bold').textContent;

            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 animate-slide-up">
                    <h3 class="text-xl font-bold text-indrive-dark mb-4">Détails du trajet</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <img src="https://picsum.photos/seed/${passengerName}/48/48.jpg" class="w-12 h-12 rounded-full">
                            <div>
                                <p class="font-bold">${passengerName}</p>
                                <p class="text-sm text-gray-600">Passager vérifié</p>
                            </div>
                        </div>
                        <div class="border-t pt-3">
                            <p class="text-sm text-gray-600">Distance: 7.8 km</p>
                            <p class="text-sm text-gray-600">Durée estimée: 20 min</p>
                            <p class="text-sm text-gray-600">Prix proposé: <span class="font-bold text-indrive-yellow">22€</span></p>
                        </div>
                    </div>
                    <button onclick="this.closest('.fixed').remove()" class="mt-6 w-full bg-indrive-yellow text-black font-bold py-3 rounded-lg">
                        Fermer
                    </button>
                </div>
            `;
            document.body.appendChild(modal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        });
    });

    // Animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    document.querySelectorAll('.trip-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        observer.observe(card);
    });
    // const carts_trip = getElementsByClassName("trip-card")

    // carts_trip.forEach(cart => {
    //      cart.addEventListener('click', function (){
    //       driverMap.setView([48.8566, 2.3522],14)
    //     })
    // });
</script>
</html>
