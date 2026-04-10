<!-- resources/views/partials/trip-card.blade.php -->
<div class="trip-row p-4 hover:bg-gray-50 transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
    data-status="{{ $trip->status }}">
    <div class="flex items-center space-x-4">
        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-map-marker-alt text-gray-500"></i>
        </div>
        <div>
            <p class="font-semibold tripgo-black-text">
                {{ $trip->departureAddress->name ?? 'Inconnu' }}
                <i class="fas fa-arrow-right mx-2 text-gray-400 text-xs"></i>
                {{ $trip->destinationAddress->name ?? 'Inconnu' }}
            </p>
            <p class="text-sm text-gray-500">
                <i class="far fa-calendar mr-1"></i>
                {{ \Carbon\Carbon::parse($trip->departure_time)->format('d M Y à H:i') }}
            </p>
        </div>
    </div>

    <div class="flex items-center space-x-6 w-full sm:w-auto justify-between sm:justify-end">
        <div class="text-right">
            <p class="font-bold tripgo-black-text">{{ number_format($trip->price, 2, ',', ' ') }} €</p>
            <p class="text-xs text-gray-500">{{ $trip->available_seats }} places</p>
        </div>

        <div>
            @if($trip->status === 'terminer')
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Terminé</span>
            @elseif($trip->status === 'encours')
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold flex items-center gap-1">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span> En cours
                </span>
            @else
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">À venir</span>
            @endif
        </div>

        @if($trip->status === 'terminer' && $trip->rating)
            <div class="text-yellow-500 text-sm flex items-center gap-1">
                <i class="fas fa-star"></i> {{ $trip->rating }}/5
            </div>
        @endif
    </div>
</div>