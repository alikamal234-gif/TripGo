<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inDrive - Accueil</title>
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
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
        #heroMap {
            height: 450px;
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
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FFD600 0%, #FFC107 100%);
        }
        /* Fix pour éviter le double rendu */
        .leaflet-pane {
            z-index: auto !important;
        }
        .leaflet-map-pane {
            z-index: 1 !important;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-indrive-gray min-h-screen">
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 gradient-bg opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="animate-slide-up">
                    <h1 class="text-5xl lg:text-6xl font-bold text-indrive-dark mb-6">
                        Votre trajet, <span class="text-indrive-yellow">votre prix</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Rejoignez des millions de passagers qui choisissent inDrive pour des trajets
                        abordables et sûrs. Proposez votre prix et voyagez en toute liberté.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        @if (!auth()->check())
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-indrive-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transform hover:scale-105 transition-all duration-300 shadow-lg text-lg">
                                <i class="fas fa-bolt mr-2"></i>
                                Get free account 
                            </a>
                        @elseif (auth()->user()->is_driver())
                        
                            <a href="{{ route('driver.dashboard') }}"
                                class="px-8 py-4 bg-indrive-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transform hover:scale-105 transition-all duration-300 shadow-lg text-lg">
                                <i class="fas fa-bolt mr-2"></i>
                                Go to dashboard driver
                            </a>
                        @elseif (auth()->user()->is_passenger())
                        
                            <a href="{{ route('passenger.dashboard') }}"
                                class="px-8 py-4 bg-indrive-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transform hover:scale-105 transition-all duration-300 shadow-lg text-lg">
                                <i class="fas fa-bolt mr-2"></i>
                                Go to dashboard passenger
                            </a>
                        
                        @elseif (auth()->user()->is_admin())
                        
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-8 py-4 bg-indrive-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transform hover:scale-105 transition-all duration-300 shadow-lg text-lg">
                                <i class="fas fa-bolt mr-2"></i>
                                Go to dashboard admin 
                            </a>
                        
                        @endif
                        
                        <button class="px-8 py-4 bg-white text-indrive-dark font-bold rounded-xl border-2 border-gray-300 hover:border-indrive-yellow hover:text-indrive-yellow transition-all duration-300 shadow-lg text-lg">
                            <i class="fas fa-play-circle mr-2"></i>
                            Comment ça marche
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-indrive-yellow">150M+</p>
                            <p class="text-sm text-gray-600 mt-1">Utilisateurs</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-indrive-yellow">700+</p>
                            <p class="text-sm text-gray-600 mt-1">Villes</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-indrive-yellow">4.8⭐</p>
                            <p class="text-sm text-gray-600 mt-1">Note moyenne</p>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Map Preview -->
                <div class="relative animate-slide-up" style="animation-delay: 0.2s">
                    <div class="bg-white rounded-2xl shadow-2xl p-1">
                        <div id="heroMap" class="rounded-xl"></div>
                    </div>

                </div>
                <div class="absolute mb-5 -bottom-4 -left-4 bg-white rounded-xl shadow-xl p-4 flex items-center space-x-3 z-10">
                        <div class="w-12 h-12 bg-indrive-yellow rounded-full flex items-center justify-center">
                            <i class="fas fa-car text-black text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-indrive-dark">Chauffeurs à proximité</p>
                            <p class="text-sm text-gray-600">5 disponibles maintenant</p>
                        </div>
                    </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-indrive-yellow mb-4">Pourquoi choisir inDrive?</h2>
                <p class="text-xl text-gray-600">Découvrez nos avantages uniques</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-indrive-yellow rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                        <i class="fas fa-hand-holding-usd text-black text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-indrive-dark mb-2">Fixez votre prix</h3>
                    <p class="text-gray-600">Proposez le prix qui vous convient et acceptez l'offre qui vous plaît</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-indrive-yellow rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                        <i class="fas fa-shield-alt text-black text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-indrive-dark mb-2">Trajets sécurisés</h3>
                    <p class="text-gray-600">Tous nos chauffeurs sont vérifiés et notés par la communauté</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-indrive-yellow rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                        <i class="fas fa-clock text-black text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-indrive-dark mb-2">Rapide et efficace</h3>
                    <p class="text-gray-600">Trouvez un chauffeur en quelques minutes seulement</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-indrive-gray">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-indrive-yellow mb-4">Comment ça marche?</h2>
                <p class="text-xl text-gray-600">Trois étapes simples pour voyager</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-indrive-yellow rounded-full flex items-center justify-center text-2xl font-bold text-black mb-4">
                            1
                        </div>
                        <h3 class="text-xl font-bold text-indrive-dark mb-3">Indiquez votre trajet</h3>
                        <p class="text-gray-600">Entrez votre point de départ et destination</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-indrive-yellow rounded-full flex items-center justify-center text-2xl font-bold text-black mb-4">
                            2
                        </div>
                        <h3 class="text-xl font-bold text-indrive-dark mb-3">Proposez votre prix</h3>
                        <p class="text-gray-600">Fixez le montant que vous souhaitez payer</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-indrive-yellow rounded-full flex items-center justify-center text-2xl font-bold text-black mb-4">
                            3
                        </div>
                        <h3 class="text-xl font-bold text-indrive-dark mb-3">Voyagez!</h3>
                        <p class="text-gray-600">Acceptez l'offre d'un chauffeur et profitez de votre trajet</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="booking" class="py-20 bg-gradient-to-r from-indrive-yellow to-yellow-400">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-black mb-6">Prêt à commencer votre voyage?</h2>
            <p class="text-xl text-gray-800 mb-8">Téléchargez l'application et réservez votre premier trajet</p>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="px-8 py-4 bg-black text-white font-bold rounded-xl hover:bg-gray-900 transition-all duration-300 flex items-center">
                    <i class="fab fa-apple text-2xl mr-3"></i>
                    <div class="text-left">
                        <p class="text-xs">Download on the</p>
                        <p class="text-lg">App Store</p>
                    </div>
                </button>
                <button class="px-8 py-4 bg-black text-white font-bold rounded-xl hover:bg-gray-900 transition-all duration-300 flex items-center">
                    <i class="fab fa-google-play text-2xl mr-3"></i>
                    <div class="text-left">
                        <p class="text-xs">Get it on</p>
                        <p class="text-lg">Google Play</p>
                    </div>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-indrive-dark text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-indrive-yellow rounded-lg flex items-center justify-center">
                            <i class="fas fa-bolt text-black text-xl font-bold"></i>
                        </div>
                        <span class="text-white font-bold text-xl">inDrive</span>
                    </div>
                    <p class="text-gray-400">Votre trajet, votre prix</p>
                </div>

                <div>
                    <h4 class="font-bold text-indrive-yellow mb-4">À propos</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-indrive-yellow transition-colors">Qui sommes-nous</a></li>
                        <li><a href="#" class="hover:text-indrive-yellow transition-colors">Carrières</a></li>
                        <li><a href="#" class="hover:text-indrive-yellow transition-colors">Presse</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-indrive-yellow mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-indrive-yellow transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-indrive-yellow transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-indrive-yellow transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-indrive-yellow mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indrive-yellow hover:text-black transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indrive-yellow hover:text-black transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indrive-yellow hover:text-black transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indrive-yellow hover:text-black transition-all">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 inDrive. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Hero Map
        let heroMap;
        function initHeroMap() {
            // S'assurer que la carte n'existe pas déjà
            if (heroMap) {
                heroMap.remove();
            }

            // Créer la carte
            heroMap = L.map('heroMap', {
                center: [48.8566, 2.3522],
                zoom: 13,
                zoomControl: false
            });

            // Ajouter les tuiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(heroMap);

            // Désactiver le zoom avec la molette pour éviter les bugs
            heroMap.scrollWheelZoom.disable();

            // Icône personnalisée pour l'utilisateur
            const userIcon = L.divIcon({
                html: '<div class="bg-indrive-yellow rounded-full p-2 shadow-lg"><i class="fas fa-user text-black"></i></div>',
                iconSize: [40, 40],
                className: 'custom-div-icon'
            });

            // Marqueur de l'utilisateur
            L.marker([48.8566, 2.3522], {icon: userIcon}).addTo(heroMap)
                .bindPopup('Votre Position');

            // Icône pour les chauffeurs
            const driverIcon = L.divIcon({
                html: '<div class="bg-green-500 rounded-full p-2 shadow-lg"><i class="fas fa-car text-white"></i></div>',
                iconSize: [35, 35],
                className: 'custom-div-icon'
            });

            // Positions des chauffeurs
            const driverLocations = [
                [48.8616, 2.3562],
                [48.8516, 2.3482],
                [48.8616, 2.3442],
                [48.8666, 2.3602],
                [48.8466, 2.3522]
            ];

            // Ajouter les marqueurs des chauffeurs
            driverLocations.forEach((loc, index) => {
                L.marker(loc, {icon: driverIcon}).addTo(heroMap)
                    .bindPopup(`Chauffeur ${index + 1} - Disponible`);
            });
        }

        // Initialiser la carte quand le DOM est chargé
        document.addEventListener('DOMContentLoaded', function() {
            // Attendre un peu pour s'assurer que le conteneur est prêt
            setTimeout(initHeroMap, 100);
        });

        // Smooth scroll to booking section
        function scrollToBooking() {
            document.getElementById('booking').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // Gérer le redimensionnement de la fenêtre
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (heroMap) {
                    heroMap.invalidateSize();
                }
            }, 250);
        });

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observer toutes les sections
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'all 0.6s ease-out';
            observer.observe(section);
        });
    </script>
</body>
</html>
