<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Supprimé | TripGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');

        :root {
            --color-black: #111111;
            --color-white: #ffffff;
            --color-yellow: #FFD000;
            /* Jaune vibrant */
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: var(--color-white);
            overflow-x: hidden;
        }

        /* Background Pattern (Dot Grid) */
        .bg-pattern {
            background-image: radial-gradient(var(--color-black) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.05;
        }

        /* The Ticket Card Styles */
        .ticket-card {
            position: relative;
            background: white;
            border: 3px solid var(--color-black);
            box-shadow: 12px 12px 0px var(--color-black);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .ticket-card:hover {
            transform: translate(-2px, -2px);
            box-shadow: 16px 16px 0px var(--color-black);
        }

        /* Ticket Notches (Top and Bottom) */
        .notch {
            position: absolute;
            width: 30px;
            height: 30px;
            background-color: var(--color-white);
            /* Matches body bg to mask */
            border-radius: 50%;
            z-index: 10;
        }

        .notch-top {
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: inset -2px 0 0 0 var(--color-black), inset 2px 0 0 0 var(--color-black);
        }

        .notch-bottom {
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: inset -2px 0 0 0 var(--color-black), inset 2px 0 0 0 var(--color-black);
        }

        /* Dashed line separator */
        .divider {
            border-left: 3px dashed var(--color-black);
            position: absolute;
            left: 70%;
            top: 10px;
            bottom: 10px;
        }

        /* STAMP ANIMATION */
        .stamp-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            z-index: 20;
            pointer-events: none;
            /* Let clicks pass through */
            opacity: 0;
            /* Hidden initially */
        }

        .stamp-text {
            font-size: 3rem;
            font-weight: 800;
            color: var(--color-white);
            background: var(--color-black);
            padding: 0.5rem 1.5rem;
            border: 4px solid var(--color-yellow);
            /* Yellow border for pop */
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 4px;
            box-shadow: 0 0 0 8px rgba(255, 208, 0, 0.4);
            /* Yellow glow */
        }

        .stamp-anim {
            animation: stampSlam 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        @keyframes stampSlam {
            0% {
                transform: translate(-50%, -50%) scale(4) rotate(-15deg);
                opacity: 0;
            }

            60% {
                transform: translate(-50%, -50%) scale(0.9) rotate(-15deg);
                opacity: 1;
            }

            80% {
                transform: translate(-50%, -50%) scale(1.05) rotate(-15deg);
            }

            100% {
                transform: translate(-50%, -50%) scale(1) rotate(-15deg);
                opacity: 1;
            }
        }

        /* Shake animation for the card when stamped */
        .shake-anim {
            animation: shakeCard 0.5s ease-in-out;
        }

        @keyframes shakeCard {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(2deg);
            }

            75% {
                transform: rotate(-2deg);
            }
        }

        /* Button Hover Effects */
        .btn-hover-effect {
            transition: all 0.2s ease;
        }

        .btn-hover-effect:hover {
            transform: translateY(-3px);
            box-shadow: 4px 4px 0px var(--color-black);
        }

        .btn-hover-effect:active {
            transform: translateY(0);
            box-shadow: 0px 0px 0px var(--color-black);
        }

        /* Entrance Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.8s;
        }

        .delay-2 {
            animation-delay: 1.0s;
        }

        .delay-3 {
            animation-delay: 1.2s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center relative selection:bg-black selection:text-white">

    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-pattern z-0 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-lg px-6 text-center">

        <!-- Main Ticket Element -->
        <div class="ticket-card rounded-2xl p-0 mb-10 mx-auto w-full h-64 flex relative fade-in-up" id="ticketCard">

            <!-- Notches -->
            <div class="notch notch-top"></div>
            <div class="notch notch-bottom"></div>

            <!-- Left Content (Trip Info) -->
            <div class="w-[70%] p-6 flex flex-col justify-between h-full text-left border-r-2 border-transparent">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold tracking-widest text-gray-400 uppercase">Destination</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 truncate">UNKNOWN</h2>
                </div>

                <div class="flex justify-between items-end">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase">Date</div>
                        <div class="text-xl font-bold">--/--/--</div>
                    </div>
                    <!-- Icon -->
                    <div class="w-12 h-12 rounded-full border-2 border-gray-200 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Right Content (Price/Status) -->
            <div class="w-[30%] flex flex-col items-center justify-center h-full">
                <span class="text-xs font-bold text-gray-400 uppercase mb-1 -rotate-90">Total</span>
                <span class="text-lg font-bold text-gray-300 line-through">$0.00</span>
            </div>

            <!-- The Stamp (Overlay) -->
            <div class="stamp-container" id="stamp">
                <div class="stamp-text">Not found</div>
            </div>
        </div>

        <!-- Text Content -->
        <h1 class="text-4xl font-extrabold text-black mb-3 tracking-tight fade-in-up delay-1">
            Oops! Trip Deleted.
        </h1>

        <p class="text-gray-500 text-lg mb-8 max-w-md mx-auto fade-in-up delay-2 leading-relaxed">
            Ce voyage a été annulé par le conducteur ou n'est plus disponible. Veuillez vérifier votre tableau de bord.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in-up delay-3">

            <button onclick="goBack()"

                class="btn-hover-effect px-8 py-3 bg-white border-2 border-black text-black font-bold rounded-full w-full sm:w-auto">
                Retour
            </button>

            <a href="/"
                class="btn-hover-effect px-8 py-3 bg-[#FFD000] border-2 border-black text-black font-bold rounded-full w-full sm:w-auto shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                Home
            </a>

        </div>

    </div>

    <!-- JavaScript Interactions -->
    <script>
        // Trigger Animation on Load
        document.addEventListener('DOMContentLoaded', () => {
            const ticketCard = document.getElementById('ticketCard');
            const stamp = document.getElementById('stamp');

            // Sequence: Card appears -> Wait -> Stamp Slams
            setTimeout(() => {
                // Apply the stamp animation class
                stamp.classList.add('stamp-anim');
                // Shake the card slightly
                ticketCard.classList.add('shake-anim');
            }, 600); // 600ms delay after load
        });



        function goBack() {
            const btn = event.currentTarget;
            btn.style.transform = "translateX(-5px)";
            setTimeout(() => {
                btn.style.transform = "translateX(0)";
            }, 150);

            if (document.referrer) {
        window.history.back();
    } else {
        window.location.href = "{{ route('passenger.dashboard') }}";
    }
        }
    </script>

</body>

</html>
