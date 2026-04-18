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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <style>
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
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/"
                    class="flex items-center space-x-2 text-yellow-500  font-bold text-xl hover:scale-105 transition-transform">
                    <i class="fas fa-car text-2xl"></i>
                    <span>TripGo</span>
                </a>

                <div class="flex items-center space-x-4">
                    {{-- <button
                        class="p-2 rounded-full bg-gray-100 hover:bg-indigo-600 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-search text-gray-600 group-hover:text-white"></i>
                    </button> --}}

                    <div class="relative">
                        <a href="/notifications"><button
                                class="relative p-2 hover:bg-indrive-gray rounded-lg transition-colors">
                                <i class="fas fa-bell text-indrive-dark text-xl"></i>
                                <span
                                    class="notification-dot absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button></a>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('profile') }}"><button
                                class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                                <img src="https://picsum.photos/seed/passenger/40/40" alt="Profile"
                                    class="w-10 h-10 rounded-full border-2 border-transparent hover:border-indigo-600 transition-all">
                            </button>
                        </a>
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
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div id="alert-success"
                class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-md">

                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span>{{ session('success') }}</span>
                </div>

                <button onclick="document.getElementById('alert-success').remove()"
                    class="text-green-700 hover:text-green-900 font-bold">
                    ✕
                </button>
            </div>
        @endif
        <section class="mb-8 animate-slide-in">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, Alex Johnson</h1>
            <p class="text-gray-600">Find a ride quickly and travel easily.</p>
        </section>

        <section class="bg-white rounded-2xl shadow-lg p-6 mb-8 animate-slide-in">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-route mr-2 text-indigo-600"></i>
                Request a Ride
            </h2>

            <form action="{{ route('passenger.trip') }}" method="post">
                @csrf
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Location </label>
                        <div class="relative">
                            <i
                                class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500"></i>
                            <input type="text" placeholder="Enter pickup location" id="location" readonly
                                name="departure"
                                class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg cursor-not-allowed focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Location Name</label>
                        <div class="relative">
                            <i
                                class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500"></i>
                            <input type="text" placeholder="Enter pickup location name" name="departure_name"
                                class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg  focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                    </div>


                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Destination </label>
                        <div class="relative">
                            <i
                                class="fas fa-flag-checkered absolute left-3 top-1/2 transform -translate-y-1/2 text-red-500"></i>
                            <input type="text" placeholder="Where to?" id="destination" readonly name="destination"
                                class="w-full pl-10 pr-3 py-3 border border-gray-300 cursor-not-allowed rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Destination Name</label>
                        <div class="relative">
                            <i
                                class="fas fa-flag-checkered absolute left-3 top-1/2 transform -translate-y-1/2 text-red-500"></i>
                            <input type="text" placeholder="Where to name?" name="destination_name"
                                class="w-full pl-10 pr-3 py-3 border border-gray-300  rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                </div>

                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date & Time</label>
                        <input type="datetime-local" name="departure_time"
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Passengers</label>
                        {{-- <input type="number" name="available_seats" min="1" max="4"
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        --}} <select name="available_seats"
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <option value="1">1 Passenger</option>
                            <option value="2">2 Passengers</option>
                            <option value="3">3 Passengers</option>
                            <option value="4">4 Passengers</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Offer Price (Optional)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" placeholder="0.00" name="price"
                                class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full md:w-auto px-8 py-3 bg-yellow-500  text-black font-semibold rounded-lg hover:bg-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    <i class="fas fa-search mr-2"></i>
                    Find a Ride
                </button>
            </form>
        </section>



        <section class="grid md:grid-cols-2 gap-6 mb-8">

            @foreach ($trips as $trip)
                @if ($trip->status == "avenir")


                    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-all border border-gray-100">

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-indigo-100 p-3 rounded-full">
                                    <i class="fas fa-car text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Trip</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ optional($trip->departureAddress)->name }}
                                    </p>
                                </div>
                            </div>

                            <span class="px-3 py-1 text-xs rounded-full
                                                    @if($trip->status === 'pending') bg-yellow-100 text-yellow-700
                                                    @elseif($trip->status === 'completed') bg-green-100 text-green-700
                                                    @else bg-gray-100 text-gray-600
                                                    @endif
                                                ">
                                {{ ucfirst($trip->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">

                            <div>
                                <p class="text-gray-400">Departure</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($trip->departure_time)->format('d M - H:i') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-400">Seats</p>
                                <p class="font-semibold text-gray-800">
                                    {{ $trip->available_seats }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-400">Price</p>
                                <p class="font-semibold text-gray-800">
                                    {{ $trip->price }} DH
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-400">Destination</p>
                                <p class="font-semibold text-gray-800">
                                    {{ optional($trip->destinationAddress)->name }}
                                </p>
                            </div>

                        </div>
                        <form action="{{ route('trips.delete', $trip->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg m-2 mt-3 p-2 bg-red-600 text-white">supprimer</button>
                        </form>

                    </div>
                @endif
            @endforeach

        </section>





        <section class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow animate-slide-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Trips</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $trips->count() }}</p>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <i class="fas fa-car text-indigo-600 text-xl"></i>
                    </div>
                </div>
            </div>
            @php
$trips_completed = $trips->where('status', 'accepted');
            @endphp
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow animate-slide-in"
                style="animation-delay: 0.1s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completed Trips</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $trips_completed->count() }}</p>
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
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $trips->sum('price') }}$</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid lg:grid-cols-2 gap-8">
            <section class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center justify-between">
                    <span><i class="fas fa-history mr-2 text-indigo-600"></i>Recent Trips</span>
                </h2>

                <div class="space-y-4">

                    @foreach ($trips as $trip)
                        @if(isset($trip->driver))
                            <div
                                class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all duration-300 hover:border-indigo-400 bg-white">

                                <!-- Header: Driver & Status -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('profile.driver', $trip?->driver->id) }}"><img src="https://picsum.photos/seed/driver1/40/40" alt="Driver"
                                            class="w-12 h-12 rounded-full border border-gray-100 object-cover"></a>
                                        <div>
                                            <a href="{{ route('profile.driver', $trip?->driver->id) }}"><h3 class="font-bold text-gray-900">{{ $trip?->driver->name }}</h3></a>
                                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                                <i class="fas fa-car-side"></i> {{ $trip?->driver->ville }}
                                            </p>
                                        </div>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold uppercase rounded-full tracking-wide">
                                        {{ $trip->status }}
                                    </span>
                                </div>

                                <!-- Trip Details -->
                                <div class="text-sm text-gray-600 space-y-2 mb-4">
                                    <div class="flex items-start">
                                        <div class="mt-1 mr-3 w-5 flex justify-center"><i
                                                class="fas fa-map-marker-alt text-green-500"></i></div>
                                        <p class="font-medium text-gray-800">{{ $trip->departureAddress->name }}</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="mt-1 mr-3 w-5 flex justify-center"><i
                                                class="fas fa-flag-checkered text-red-500"></i></div>
                                        <p class="font-medium text-gray-800">{{ $trip->destinationAddress->name }}</p>
                                    </div>
                                </div>

                                <!-- Price & Time -->
                                <div class="flex justify-between items-center pb-4 border-b border-gray-100 mb-4">
                                    <div>
                                        <span class="text-xl font-extrabold text-indigo-600">{{ $trip->price }} DH</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-400 block">Departure</span>
                                        <span class="text-sm font-semibold text-gray-700">{{ $trip->departure_time }}</span>
                                    </div>
                                </div>

                                <!-- Actions (Only if Terminated) -->
                                @if ($trip->status == "terminer")
                                    <div class="space-y-4">

                                        <!-- Rating Form -->
                                        <form action="{{ route('trips.rate', $trip->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                                <span class="text-sm font-semibold text-gray-700">Noter le chauffeur :</span>
                                                <div
                                                    class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-md border border-gray-200">
                                                    <input type="number" name="rating" value="{{ $trip->rating }}" min="1" max="5"
                                                        placeholder="5"
                                                        class="w-12 text-center font-bold bg-transparent focus:outline-none text-indigo-600">
                                                    <span class="text-gray-500 font-bold">/5</span>
                                                </div>
                                                <button type="submit"
                                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition-colors shadow-sm">
                                                    Noter
                                                </button>
                                            </div>
                                        </form>

                                        @if (!$trip->payment)

                                            <div class="w-full">
                                                <div class="flex items-center gap-3">
                                                    <select id="select-method" name="payment" onchange="methodPayment(this)"
                                                        class="flex-1 w-full bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                                                        <option value="cash" {{ old('payment') == 'cash' ? 'selected' : '' }}>Cash
                                                            (Espèces)</option>
                                                        <option value="online" {{ old('payment') == 'online' ? 'selected' : '' }}>Online
                                                            (Carte)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Payment Form -->
                                            <form id="payment-formuler-cash" action="{{ route('passenger.payment') }}" method="post"
                                                class="w-full">
                                                @csrf
                                                <div class="flex items-center gap-3">
                                                    <input class="hidden" name="amount" type="number" value="{{ $trip->price }}">
                                                    <input class="hidden" name="method" type="text" value="cash">
                                                    <input class="hidden" name="trip_id" type="text" value="{{ $trip->id }}">
                                                    <input class="hidden" name="driver_id" type="text" value="{{ $trip->driver_id }}">
                                                    <input class="hidden" name="passenger_id" type="text"
                                                        value="{{ $trip->passenger_id }}">

                                                    <button type="submit"
                                                        class="whitespace-nowrap bg-yellow-400 hover:bg-yellow-500 text-black text-sm font-bold py-2.5 px-5 rounded-lg transition-transform active:scale-95">
                                                        Payer cash
                                                    </button>
                                                </div>
                                            </form>
                                            <div id="payment-formuler-online" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md border">

                                                <h2 class="text-lg font-bold text-gray-800 mb-5 text-center">
                                                    Paiement par carte
                                                </h2>

                                                <form id="formuler-online-card" class="space-y-4">
                                                    <input type="hidden" id="trip-id" value="{{ $trip->id }}">
                                                    <!-- Card Number -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-600 mb-1">
                                                            Numéro de carte
                                                        </label>
                                                        <div id="card-element"
                                                            class="w-full border border-gray-300 rounded-lg px-3 py-3 bg-gray-50">
                                                        </div>
                                                    </div>

                                                    <!-- Name -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-600 mb-1">
                                                            Nom sur la carte
                                                        </label>
                                                        <input type="text"
                                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none"
                                                            placeholder="Ex: Moussa Essalhi">
                                                    </div>

                                                    <button id="pay-btn" type="submit"
                                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">

                                                        <span id="btn-text">Payer {{ $trip->price }} DH</span>

                                                        <svg id="loader" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                        </svg>
                                                    </button>

                                                </form>

                                                <!-- Footer -->
                                                <p class="text-xs text-gray-400 text-center mt-4">
                                                    Paiement sécurisé via Stripe 🔒
                                                </p>

                                            </div>
                                        @elseif($trip->payment->status == 'pending')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 animate-pulse">
                                                <i class="fas fa-clock"></i> En attente
                                            </span>

                                        @elseif($trip->payment->status == 'paid')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                <i class="fas fa-check-circle"></i> Payé
                                            </span>

                                        @elseif($trip->payment->status == 'refused')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-times-circle"></i> Refusé
                                            </span>
                                        @endif

                                    </div>
                                @endif

                            </div>
                        @endif
                    @endforeach



            </section>

            <section class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-map mr-2 text-indigo-600"></i>
                    Live Map
                </h2>
                <div id="map" class="rounded-lg overflow-hidden"></div>
                <div class="mt-4 flex items-center justify-between text-sm">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                            chose Your Location
                        </span>
                    </div>
                    <button class="text-green-600 hover:text-indigo-700 font-medium" onclick="locationStart()">

                </div>
            </section>
        </div>
    </main>

    <script>
        const formuler_cash = document.getElementById('payment-formuler-cash')
        const formuler_online = document.getElementById('payment-formuler-online')
        function methodPayment(select) {
            const value = select.value
            if (value == "cash") {
                formuler_cash.style.display = 'block'
                formuler_online.style.display = 'none'
            } else if (value == "online") {
                formuler_cash.style.display = 'none'
                formuler_online.style.display = 'block'

            }
        }
        document.addEventListener('DOMContentLoaded', function () {

            const select = document.getElementById('select-method');

            methodPayment(select);
        })
    </script>


    <script>
        const map = L.map('map').setView([33.5731, -7.5898], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let start = null;
        let destination = null;
        let routeControl = null;
        let markers = [];
        let locationStart = document.getElementById('location')
        let locationDestination = document.getElementById('destination')
        map.on("click", function (e) {

            const latlng = e.latlng;

            if (!start) {

                start = latlng;

                markers.push(
                    L.marker(latlng).addTo(map).bindPopup("Start").openPopup()
                );

                locationStart.value = latlng
                return;
            }

            if (!destination) {

                destination = latlng;

                markers.push(
                    L.marker(latlng).addTo(map).bindPopup("Destination").openPopup()
                );
                locationDestination.value = destination

                routeControl = L.Routing.control({
                    waypoints: [
                        L.latLng(start),
                        L.latLng(destination)
                    ],
                    routeWhileDragging: false,
                    addWaypoints: false
                }).addTo(map);

                return;
            }

            markers.forEach(m => map.removeLayer(m));
            markers = [];

            if (routeControl) {
                map.removeControl(routeControl);
            }

            start = null;
            destination = null;

        });
    </script>

</body>

</html>
<style>
    .star-btn {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .star-btn:hover .star-icon {
        transform: scale(1.2) rotate(10deg);
    }

    .star-btn:focus {
        outline: none;
    }

    .star-btn:focus .star-icon {
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.3);
        border-radius: 50%;
    }

    @keyframes starPulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.3);
        }

        100% {
            transform: scale(1);
        }
    }

    .star-selected {
        animation: starPulse 0.3s ease;
    }

    .rating-1 {
        color: #ef4444;
        font-weight: 600;
    }

    .rating-2 {
        color: #f97316;
        font-weight: 600;
    }

    .rating-3 {
        color: #eab308;
        font-weight: 600;
    }

    .rating-4 {
        color: #22c55e;
        font-weight: 600;
    }

    .rating-5 {
        color: #10b981;
        font-weight: 600;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const starButtons = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');
        const ratingText = document.getElementById('rating-text');
        const starIcons = document.querySelectorAll('.star-icon');

        const ratingTexts = {
            0: 'Cliquez',
            1: 'Médiocre',
            2: 'Faible',
            3: 'Correct',
            4: 'Bon',
            5: 'Excellent'
        };

        function updateStars(rating) {
            starIcons.forEach((icon, index) => {
                if (index < rating) {
                    icon.classList.remove('text-gray-300');
                    icon.classList.add('text-yellow-400', 'star-selected');
                } else {
                    icon.classList.add('text-gray-300');
                    icon.classList.remove('text-yellow-400', 'star-selected');
                }
            });

            ratingText.textContent = ratingTexts[rating];
            ratingText.className = 'text-xs ml-2 min-w-[60px]';
            if (rating > 0) {
                ratingText.classList.add(`rating-${rating}`);
            }
        }

        starButtons.forEach(button => {
            button.addEventListener('click', function () {
                const rating = parseInt(this.dataset.rating);
                ratingInput.value = rating;
                updateStars(rating);

                this.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            });

            button.addEventListener('mouseenter', function () {
                const hoverRating = parseInt(this.dataset.rating);
                starIcons.forEach((icon, index) => {
                    if (index < hoverRating) {
                        icon.classList.add('text-yellow-300');
                    } else {
                        icon.classList.remove('text-yellow-300');
                    }
                });
            });
        });

        document.getElementById('star-rating').addEventListener('mouseleave', function () {
            const currentRating = parseInt(ratingInput.value);
            updateStars(currentRating);
        });
    });
</script>
<script src="https://js.stripe.com/v3/"></script>

<script>

    document.addEventListener("DOMContentLoaded", async function () {
        const tripIdEl = document.getElementById('trip-id');

        if (!tripIdEl) return;

        const tripId = tripIdEl.value;
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();

        const card = elements.create("card", {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#374151',
                    '::placeholder': { color: '#9CA3AF' }
                }
            }
        });

        card.mount("#card-element");

        const form = document.getElementById("formuler-online-card");

        const btn = document.getElementById("pay-btn");
        const btnText = document.getElementById("btn-text");
        const loader = document.getElementById("loader");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            btn.disabled = true;
            btnText.textContent = "Processing...";
            loader.classList.remove("hidden");

            try {
                const res = await fetch('/passenger/payment/intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ trip_id: tripId })
                });

                const data = await res.json();

                const result = await stripe.confirmCardPayment(data.clientSecret, {
                    payment_method: { card: card }
                });

                if (result.error) {
                    alert(result.error.message);

                    btn.disabled = false;
                    btnText.textContent = "Payer";
                    loader.classList.add("hidden");

                } else if (result.paymentIntent.status === 'succeeded') {
                    window.location.href = "/passenger/payment/success?trip_id=" + tripId;
                }

            } catch (err) {
                console.error(err);

                btn.disabled = false;
                btnText.textContent = "Payer";
                loader.classList.add("hidden");
            }
        });
    });
</script>
