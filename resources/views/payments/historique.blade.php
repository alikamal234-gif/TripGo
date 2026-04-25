<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Paiements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        indigo: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#FBBF24', // Sfar (Default theme)
                            600: '#D97706',
                            700: '#B45309',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 pb-20">

    <!-- ==========================
         HEADER
    ========================== -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-between">
            <button onclick="history.back()" class="p-2 text-gray-600 hover:text-yellow-500 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <h1 class="text-lg font-bold text-gray-800">Historique</h1>
            <button class="p-2 text-gray-600 hover:text-yellow-500 transition">
                <i class="fas fa-filter text-xl"></i>
            </button>
        </div>
    </header>

    <main class="max-w-md mx-auto p-4 space-y-6">

        <!-- ==========================
            TOTAL SPENT CARD (Summary)
        ========================== -->
        <div
            class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-2xl p-6 text-white shadow-lg shadow-yellow-400/30">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Total Dépensé</p>
                    <h2 class="text-3xl font-extrabold">4 520 DH</h2>
                    <p class="text-xs text-yellow-100 mt-2 opacity-80">Total des trajets payés</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                    <i class="fas fa-wallet text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- ==========================
            LIST OF PAYMENTS
        ========================== -->
        <div>
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 ml-1">Transactions</h3>

            <div class="space-y-3">

                @forelse($payments as $payment)

                    <!-- PAYMENT CARD -->
                    <div
                        class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex justify-between items-center hover:shadow-md transition-shadow">

                        <!-- Left: Driver & Trip Info -->
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <!-- Driver Avatar -->
                            <img src="{{ $payment->driver->profile_photo ?? 'https://i.pravatar.cc/150?img=11' }}"
                                alt="Driver" class="w-12 h-12 rounded-full object-cover border border-gray-100">

                            <!-- Text Info -->
                            <div class="min-w-0">
                                <h4 class="font-bold text-gray-800 text-sm truncate">
                                    {{ $payment->trip->driver->name }}
                                </h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                    <span><i class="far fa-calendar"></i> {{ $payment->created_at->format('d M') }}</span>
                                    <span>&bull;</span>
                                    <span
                                        class="truncate max-w-[100px]">{{ $payment->trip->destinationAddress->name ?? 'Destination' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Price & Method Badge -->
                        <div class="text-right">
                            <!-- Method Badge (Cash vs Online) -->
                            @if(strtolower($payment->method) == 'cash')
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-green-100 text-green-700 mb-1">
                                    <i class="fas fa-money-bill-wave"></i> Cash
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-100 text-indigo-700 mb-1">
                                    <i class="fas fa-credit-card"></i> Online
                                </span>
                            @endif

                            <!-- Price -->
                            <p class="font-extrabold text-gray-800 text-lg leading-none">
                                {{ $payment->amount }} DH
                            </p>
                        </div>

                    </div>
                    <!-- END CARD -->

                @empty
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl p-8 text-center border border-dashed border-gray-300">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-receipt text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Aucun paiement trouvé</p>
                        <p class="text-xs text-gray-400 mt-1">Vos transactions apparaitront ici.</p>
                    </div>
                @endforelse

            </div>
        </div>

    </main>


</body>

</html>
