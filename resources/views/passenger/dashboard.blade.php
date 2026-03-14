<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RideFlow - Passenger Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        /* Custom animations */
        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        #map {
            height: 400px;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/"
                    class="flex items-center space-x-2 text-yellow-500  font-bold text-xl hover:scale-105 transition-transform">
                    <i class="fas fa-car text-2xl"></i>
                    <span>TripGo</span>
                </a>

                <!-- Nav Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Search Icon -->
                    <button
                        class="p-2 rounded-full bg-gray-100 hover:bg-indigo-600 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-search text-gray-600 group-hover:text-white"></i>
                    </button>

                    <!-- Notifications -->
                    <button
                        class="relative p-2 rounded-full bg-gray-100 hover:bg-indigo-600 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-bell text-gray-600 group-hover:text-white"></i>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">3</span>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button onclick="toggleDropdown()"
                            class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                            <img src="https://picsum.photos/seed/passenger/40/40" alt="Profile"
                                class="w-10 h-10 rounded-full border-2 border-transparent hover:border-indigo-600 transition-all">
                            <i class="fas fa-chevron-down text-gray-600 text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 animate-slide-in">
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                            <hr class="my-2">
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <section class="mb-8 animate-slide-in">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, Alex Johnson</h1>
            <p class="text-gray-600">Find a ride quickly and travel easily.</p>
        </section>

        <!-- Ride Request Card -->
        <section class="bg-white rounded-2xl shadow-lg p-6 mb-8 animate-slide-in">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-route mr-2 text-indigo-600"></i>
                Request a Ride
            </h2>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Location</label>
                    <div class="relative">
                        <i
                            class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500"></i>
                        <input type="text" placeholder="Enter pickup location"
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                    <div class="relative">
                        <i
                            class="fas fa-flag-checkered absolute left-3 top-1/2 transform -translate-y-1/2 text-red-500"></i>
                        <input type="text" placeholder="Where to?"
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date & Time</label>
                    <input type="datetime-local"
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Passengers</label>
                    <select
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <option>1 Passenger</option>
                        <option>2 Passengers</option>
                        <option>3 Passengers</option>
                        <option>4 Passengers</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Offer Price (Optional)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" placeholder="0.00"
                            class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                </div>
            </div>

            <button onclick="findRide()"
                class="w-full md:w-auto px-8 py-3 bg-yellow-500  text-black font-semibold rounded-lg hover:bg-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                <i class="fas fa-search mr-2"></i>
                Find a Ride
            </button>
        </section>

        <!-- Quick Stats Cards -->
        <section class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow animate-slide-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Trips</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">47</p>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <i class="fas fa-car text-indigo-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow animate-slide-in"
                style="animation-delay: 0.1s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completed Trips</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">42</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow animate-slide-in"
                style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Spent</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">$892</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Recent Trips Section -->
            <section class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center justify-between">
                    <span><i class="fas fa-history mr-2 text-indigo-600"></i>Recent Trips</span>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700">View All</a>
                </h2>

                <div class="space-y-4">
                    <!-- Trip 1 -->
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all hover:border-indigo-300">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center space-x-3">
                                <img src="https://picsum.photos/seed/driver1/40/40" alt="Driver"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-800">Michael Chen</p>
                                    <p class="text-sm text-gray-500">Toyota Camry</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Completed</span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><i class="fas fa-map-marker-alt text-green-500 mr-2"></i>Downtown Station</p>
                            <p><i class="fas fa-flag-checkered text-red-500 mr-2"></i>Airport Terminal 2</p>
                        </div>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                            <span class="text-lg font-bold text-gray-800">$24.50</span>
                            <span class="text-xs text-gray-500">Dec 15, 2023 • 2:30 PM</span>
                        </div>
                    </div>

                    <!-- Trip 2 -->
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all hover:border-indigo-300">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center space-x-3">
                                <img src="https://picsum.photos/seed/driver2/40/40" alt="Driver"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-800">Sarah Williams</p>
                                    <p class="text-sm text-gray-500">Honda Accord</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">Accepted</span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><i class="fas fa-map-marker-alt text-green-500 mr-2"></i>123 Main Street</p>
                            <p><i class="fas fa-flag-checkered text-red-500 mr-2"></i>Shopping Mall</p>
                        </div>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                            <span class="text-lg font-bold text-gray-800">$15.00</span>
                            <span class="text-xs text-gray-500">Dec 16, 2023 • 10:00 AM</span>
                        </div>
                    </div>

                    <!-- Trip 3 -->
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all hover:border-indigo-300">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center space-x-3">
                                <img src="https://picsum.photos/seed/driver3/40/40" alt="Driver"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-800">David Park</p>
                                    <p class="text-sm text-gray-500">Nissan Altima</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Pending</span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><i class="fas fa-map-marker-alt text-green-500 mr-2"></i>Office Building</p>
                            <p><i class="fas fa-flag-checkered text-red-500 mr-2"></i>Home</p>
                        </div>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                            <span class="text-lg font-bold text-gray-800">$18.75</span>
                            <span class="text-xs text-gray-500">Dec 17, 2023 • 6:00 PM</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Map Section -->
            <section class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-map mr-2 text-indigo-600"></i>
                    Live Map
                </h2>
                <div id="map" class="rounded-lg overflow-hidden"></div>
                <div class="mt-4 flex items-center justify-between text-sm">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                            Available Drivers (5)
                        </span>
                        <span class="flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                            Your Location
                        </span>
                    </div>
                    <button class="text-indigo-600 hover:text-indigo-700 font-medium">
                        <i class="fas fa-sync-alt mr-1"></i> Refresh
                    </button>
                </div>
            </section>
        </div>
    </main>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span id="toastMessage">Success!</span>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        }


        // hadchi dyal maaps 

        const ville = "benguerir";

        async function getCoord(ville) {

            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${ville}`);
            const data = await response.json();

            return [data[0].lat, data[0].lon];

        }

        async function initMap() {

            const coord = await getCoord(ville);

            const map = L.map('map').setView(coord, 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            L.marker(coord)
                .addTo(map)
                .bindPopup(ville)
                .openPopup();


        }

        initMap();

    </script>
       
</body >

</html >