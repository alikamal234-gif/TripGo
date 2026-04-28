<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Trajet #{{ $trip->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-800 pb-20">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-2xl mx-auto px-4 h-16 flex items-center justify-between">
            <button onclick="history.back()" class="p-2 text-gray-600 hover:text-indigo-600">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <h1 class="text-lg font-bold text-gray-800">Détails du Trajet</h1>
            <div class="w-8"></div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto p-4 space-y-6">


        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">ID Référence</p>
                <p class="text-xl font-mono font-bold text-indigo-600">#{{ $trip->id }}</p>
            </div>

            <!-- Status Badge -->
            <div class="text-right">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">État</p>
                <span
                    class="inline-block px-3 py-1 rounded-full text-xs font-bold
                    {{ $trip->status == 'terminer' ? 'bg-green-100 text-green-700' :
    ($trip->status == 'en_cours' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($trip->status) }}
                </span>
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-indigo-50 p-4 border-b border-indigo-100 flex justify-between items-center">
                <span class="text-indigo-700 font-bold text-sm"><i class="fas fa-route mr-2"></i>Itinéraire</span>
                <span class="text-2xl font-extrabold text-indigo-600">{{ $trip->price }} DH</span>
            </div>

            <div class="p-5 relative">
                <!-- Timeline Line -->
                <div class="absolute left-[34px] top-12 bottom-12 w-0.5 bg-gray-100"></div>

                <!-- Departure -->
                <div class="flex gap-4 relative mb-6">
                    <div class="mt-1 z-10 flex-shrink-0">
                        <div
                            class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center border-2 border-white shadow-sm">
                            <i class="fas fa-map-marker-alt text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Départ</p>
                        <p class="font-bold text-gray-800 text-lg leading-tight">{{ $trip->departureAddress->name }}</p>
                    </div>
                </div>

                <!-- Destination -->
                <div class="flex gap-4 relative">
                    <div class="mt-1 z-10 flex-shrink-0">
                        <div
                            class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center border-2 border-white shadow-sm">
                            <i class="fas fa-flag-checkered text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Destination</p>
                        <p class="font-bold text-gray-800 text-lg leading-tight">{{ $trip->destinationAddress->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Passenger -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-xs text-gray-400 font-bold uppercase mb-2">Passager</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="truncate">
                        <p class="font-bold text-gray-800 text-sm truncate">{{ $trip->passenger->user->name ?? 'Inconnu' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Driver -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-xs text-gray-400 font-bold uppercase mb-2">Chauffeur</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="truncate">
                        <p class="font-bold text-gray-800 text-sm truncate">{{ $trip->driver->user->name ?? 'Inconnu' }}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-sm font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">
                Horaires & Logistique
            </h3>

            <div class="space-y-3">
                <!-- Departure Time (Scheduled) -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                        <i class="far fa-calendar-alt w-4 text-center text-gray-400"></i>
                        <span>Prévu (Départ)</span>
                    </div>
                    <span class="font-mono font-medium text-gray-800">{{ $trip->departure_time }}</span>
                </div>

                <!-- Start Time (Real) -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                        <i class="fas fa-play w-4 text-center text-green-500"></i>
                        <span>Début Réel</span>
                    </div>
                    <span class="font-mono font-medium text-gray-800">{{ $trip->start_time ?? '-' }}</span>
                </div>

                <!-- End Time (Real) -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                        <i class="fas fa-stop w-4 text-center text-red-500"></i>
                        <span>Fin (Terminé)</span>
                    </div>
                    <span class="font-mono font-medium text-gray-800">{{ $trip->termine_time ?? '-' }}</span>
                </div>

                <hr class="border-dashed border-gray-200 my-2">

                <!-- Seats -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                        <i class="fas fa-chair w-4 text-center text-gray-400"></i>
                        <span>Sièges Disponibles</span>
                    </div>
                    <span class="font-bold text-gray-800">{{ $trip->available_seats }}</span>
                </div>
            </div>
        </div>

   
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase mb-1">Note Passager</p>
                <!-- Dynamic Stars Logic Here (Simplified for this snippet) -->
                <div class="flex items-center gap-1 text-yellow-400 text-sm">
                    <i class="fas fa-star"></i>
                    <span class="text-gray-800 font-bold ml-1">{{ $trip->rating ?? 'N/A' }}/5</span>
                </div>
            </div>

            <div class="text-right">
                <p class="text-xs text-gray-400 font-bold uppercase mb-1">Créé le</p>
                <p class="text-sm text-gray-600">{{ $trip->created_at->format('d M Y') }}</p>
                <p class="text-[10px] text-gray-400">{{ $trip->created_at->format('H:i') }}</p>
            </div>
        </div>

    </main>

</body>

</html>
