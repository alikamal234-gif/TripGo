<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur - TripGo</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .tripgo-yellow {
            background-color: #FFD500;
        }

        .tripgo-yellow-text {
            color: #FFD500;
        }

        .tripgo-black-text {
            color: #121212;
        }

        .input-focus:focus {
            border-color: #FFD500;
            box-shadow: 0 0 0 3px rgba(255, 213, 0, 0.2);
        }

        .role-option.selected {
            border-color: #FFD500;
            background: rgba(255, 213, 0, 0.1);
        }
    </style>
</head>

<body class="bg-white min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">

        <!-- HEADER -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 tripgo-yellow rounded-full mb-4">
                <i class="fas fa-route text-3xl tripgo-black-text"></i>
            </div>
            <h1 class="text-3xl font-bold tripgo-black-text">TripGo</h1>
            <p class="text-gray-600 mt-2">Modifier un utilisateur</p>
        </div>

        <!-- CARD -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">

            <!-- USER PREVIEW -->
            <div class="flex items-center gap-4 mb-6 border-b pb-4">
                <div class="w-12 h-12 rounded-full tripgo-yellow flex items-center justify-center font-bold">
                    JD
                </div>
                <div>
                    <h2 id="previewName" class="font-semibold">{{ $user->name }}</h2>
                    <p id="previewEmail" class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <form class="space-y-6" method="post" action="{{ route('admin.user.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm mb-2">Nom complet</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                        <input id="name" type="text" placeholder="Jean Dupont" value="{{ $user->name }}"
                            class="input-focus w-full pl-10 py-3 border rounded-lg" name="name">
                    </div>
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm mb-2">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        <input id="email" type="email" placeholder="jean@email.com" value="{{ $user->email }}"
                            class="input-focus w-full pl-10 py-3 border rounded-lg" name="email">
                    </div>
                </div>

                <!-- PHONE -->
                <div>
                    <label class="block text-sm mb-2">Téléphone</label>
                    <div class="relative">
                        <i class="fas fa-phone absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" value="{{ $user->phone }}"
                            class="input-focus w-full pl-10 py-3 border rounded-lg" placeholder="+212 657-499843"
                            name="phone">
                    </div>
                </div>

                <!-- VILLE -->
                <div>
                    <label class="block text-sm mb-2">Ville</label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" value="{{ $user->ville }}" placeholder="Marrakech"
                            class="input-focus w-full pl-10 py-3 border rounded-lg" name="ville">
                    </div>
                </div>

                <!-- ROLE -->
                <div>
                    <label class="block text-sm mb-2">Rôle</label>
                    <div class="grid grid-cols-3 gap-4">

                        <div id="passenger" onclick="selectRole(this)"
                            class="role-option border-2 p-4 text-center rounded-lg cursor-pointer">
                            <i class="fas fa-user"></i>
                            <p>Passager</p>
                        </div>

                        <div id="driver" onclick="selectRole(this)"
                            class="role-option border-2 p-4 text-center rounded-lg cursor-pointer">
                            <i class="fas fa-car"></i>
                            <p>Conducteur</p>
                        </div>

                        <div id="admin" onclick="selectRole(this)"
                            class="role-option border-2 p-4 text-center rounded-lg cursor-pointer">
                            <i class="fas fa-star"></i>
                            <p>Admin</p>
                        </div>

                    </div>
                    <input type="hidden" id="roleValue" value="{{ $user->role->name }}" name="role">
                </div>

                <!-- DRIVER FIELDS -->
                <div id="driverFields" class="hidden space-y-4">

                    <h3 class="font-medium border-t pt-4">Infos conducteur</h3>

                    <input type="text" value="{{ $user->driver->license_number ?? '' }}" placeholder="123456789012"
                        name="licenseNumber" class="input-focus w-full py-3 px-3 border rounded-lg">

                    <select class="input-focus w-full py-3 px-3 border rounded-lg" name="vehicleType">
                        <option value="">Sélectionnez un type</option>
                        <option @if($user->driver && $user->driver->vehicle->type == "sedan") selected @endif value="sedan">Berline
                        </option>
                        <option @if($user->driver && $user->driver->vehicle->type == "suv") selected @endif value="suv">SUV</option>
                        <option @if($user->driver && $user->driver->vehicle->type == "hatchback") selected @endif value="hatchback">
                            Compacte</option>
                        <option @if($user->driver && $user->driver->vehicle->type == "van") selected @endif value="van">Fourgonnette
                        </option>
                        <option @if($user->driver && $user->driver->vehicle->type == "luxury") selected @endif value="luxury">Luxe</option>
                    </select>

                </div>

                <!-- BUTTONS -->
                <div class="flex gap-4 pt-4">

                    <button type="button" class="w-full border py-3 rounded-lg">
                        Annuler
                    </button>

                    <button type="submit" class="w-full tripgo-yellow py-3 rounded-lg font-medium">
                        Enregistrer
                    </button>

                </div>

            </form>

        </div>
    </div>

    <script>

        if ("{{ $user->role->name }}" === 'driver') {
            document.getElementById('driverFields').classList.remove('hidden');
        } else {
            document.getElementById('driverFields').classList.add('hidden');
        }
        document.getElementById('roleValue').value = "{{ $user->role->name }}"
        document.getElementById("{{ $user->role->name }}").classList.add('selected');



        function selectRole(el) {
            document.querySelectorAll('.role-option')
                .forEach(e => e.classList.remove('selected'));

            el.classList.add('selected');

            document.getElementById('roleValue').value = el.id;

            if (el.id === 'driver') {
                document.getElementById('driverFields').classList.remove('hidden');
            } else {
                document.getElementById('driverFields').classList.add('hidden');
            }
        }

    </script>

</body>

</html>
