<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PanUnited</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @livewireStyles

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
    </style>  
  </head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="md:hidden text-white">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <div>
                        <h1 class="text-3xl font-bold hidden md:flex">PanUnited Etisalat B2B</h1>
                        <p class="text-purple-200 mt-1 hidden md:flex">Complete System Management</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm text-purple-200">Logged in as</p>
                        <p class="font-semibold">{{Auth::user()->name}}</p>
                    </div>
                    <a href="{{ route('logout') }}"
                    class="inline-flex items-center bg-white text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-50 transition">
                        <i class="fas fa-sign-out-alt mr-2 hidden md:inline"></i>
                        Logout
                    </a>

                </div>
            </div>
        </div>
    </header>

   
    <livewire:panel-manager />
    @livewireScripts

    
    

</body>
</html>