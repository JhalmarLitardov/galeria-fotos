@php
    $settings = \App\Models\AppearanceSetting::first();
    $logo = $settings->system_logo ?? null;
    $favicon = $settings->favicon ?? null;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - GAD Esmeraldas</title>
    @if($favicon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="https://esmeraldas.gob.ec/wp-content/uploads/2020/06/cropped-favicon-gadme-32x32.png">
    @endif
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .btn-institucional {
            background-color: #2e7d32;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-institucional:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">

    <!-- Topbar Institucional -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <!-- Logo Dinámico a la Izquierda -->
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo Institucional" class="h-14 object-contain">
                    @else
                        <img src="./assets/logo_c.png" alt="Logo Institucional" class="h-14 object-contain">
                    @endif
                </a>
            </div>

            <!-- Usuario Activo y Botón Hamburguesa a la Derecha -->
            <div class="flex items-center space-x-3">
                <div class="hidden md:flex flex-col items-end mr-2">
                    <span class="text-xs font-bold text-gray-800">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-gray-500">{{ auth()->user()->email }}</span>
                </div>
                <button id="hamburger-btn" class="p-2.5 rounded-full border-2 border-[#2e7d32] text-[#2e7d32] hover:bg-[#2e7d32] hover:text-white transition cursor-pointer shadow-sm flex items-center justify-center">
                    <i class="bi bi-list text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Menú Desplegable / Sidebar Lateral (Drawer) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity opacity-0"></div>
    <aside id="sidebar-menu" class="fixed top-0 right-0 h-full w-80 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col justify-between">
        <div>
            <!-- Cabecera del Sidebar -->
            <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <span class="font-bold text-gray-800 text-lg">Menú de Gestión</span>
                <button id="close-sidebar" class="text-gray-500 hover:text-red-600 text-xl cursor-pointer">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Identificación del Usuario en el Menú -->
            <div class="p-6 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-[#2e7d32] text-white flex items-center justify-center font-bold text-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Enlaces del Menú -->
            <nav class="p-6 space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-gray-700 hover:bg-[#f1f8f3] hover:text-[#2e7d32] rounded-xl font-medium transition">
                    <i class="bi bi-speedometer2 text-lg mr-3 text-[#2e7d32]"></i> Inicio / Resumen
                </a>
                
                <a href="{{ route('admin.galleries.index') }}" class="flex items-center p-3 text-gray-700 hover:bg-[#f1f8f3] hover:text-[#2e7d32] rounded-xl font-medium transition">
                    <i class="bi bi-images text-lg mr-3 text-[#2e7d32]"></i> Galería Multimedia
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.settings.edit') }}" class="flex items-center p-3 text-gray-700 hover:bg-[#f1f8f3] hover:text-[#2e7d32] rounded-xl font-medium transition">
                        <i class="bi bi-gear text-lg mr-3 text-[#2e7d32]"></i> Configuración y Apariencia
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 text-gray-700 hover:bg-[#f1f8f3] hover:text-[#2e7d32] rounded-xl font-medium transition">
                        <i class="bi bi-people text-lg mr-3 text-[#2e7d32]"></i> Acceso de Usuarios
                    </a>
                @endif

                <hr class="my-2 border-gray-100">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center p-3 text-gray-700 hover:bg-gray-100 rounded-xl font-medium transition">
                    <i class="bi bi-globe text-lg mr-3 text-gray-500"></i> Ver Sitio Público
                </a>
            </nav>
        </div>

        <!-- Botón de Cerrar Sesión en el pie del Sidebar -->
        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl transition flex items-center justify-center cursor-pointer shadow-sm">
                    <i class="bi bi-box-arrow-right mr-2"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <!-- Tarjeta de Bienvenida -->
        <div class="bg-white border-l-4 border-[#2e7d32] shadow-sm rounded-2xl p-8 mb-8">
            <h2 class="text-3xl font-black text-gray-800 mb-2">¡Bienvenido al Panel de Control!</h2>
            <p class="text-gray-600 text-base">Desde este entorno centralizado puedes administrar las publicaciones multimedia, la apariencia institucional y los accesos de usuario del sistema.</p>
        </div>

        <!-- Tarjetas de Acceso Rápido (Se ajustan automáticamente según el rol) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Galería (Visible para Admin y Editor) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-[#f1f8f3] text-[#2e7d32] rounded-xl flex items-center justify-center text-2xl mb-4 font-bold">
                        <i class="bi bi-images"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Galería Multimedia</h3>
                    <p class="text-gray-600 text-sm mb-6">Administra, sube o elimina fotos y videos públicos de la plataforma.</p>
                </div>
                <a href="{{ route('admin.galleries.index') }}" class="inline-block btn-institucional px-5 py-2.5 rounded-xl text-center text-sm font-semibold shadow-sm">Gestionar Galería</a>
            </div>

            @if(auth()->user()->role === 'admin')
                <!-- Apariencia (Solo Administrador) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-[#f1f8f3] text-[#2e7d32] rounded-xl flex items-center justify-center text-2xl mb-4 font-bold">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Configuración y Apariencia</h3>
                        <p class="text-gray-600 text-sm mb-6">Personaliza el Favicon, Fondo de Login y el Logo del Menú institucional.</p>
                    </div>
                    <a href="{{ route('admin.settings.edit') }}" class="inline-block btn-institucional px-5 py-2.5 rounded-xl text-center text-sm font-semibold shadow-sm">Configurar Apariencia</a>
                </div>

                <!-- Accesos de Usuario (Solo Administrador) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-[#f1f8f3] text-[#2e7d32] rounded-xl flex items-center justify-center text-2xl mb-4 font-bold">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Acceso de Usuarios</h3>
                        <p class="text-gray-600 text-sm mb-6">Crea nuevos administradores, elimina cuentas o desactívalas de forma segura.</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="inline-block btn-institucional px-5 py-2.5 rounded-xl text-center text-sm font-semibold shadow-sm">Gestionar Usuarios</a>
                </div>
            @endif
        </div>
    </main>

    <!-- Script para el control del menú lateral tipo hamburguesa -->
    <script>
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const sidebarMenu = document.getElementById('sidebar-menu');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const closeSidebar = document.getElementById('close-sidebar');

        function toggleMenu() {
            sidebarMenu.classList.toggle('translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            setTimeout(() => sidebarOverlay.classList.toggle('opacity-0'), 10);
        }

        hamburgerBtn.addEventListener('click', toggleMenu);
        closeSidebar.addEventListener('click', toggleMenu);
        sidebarOverlay.addEventListener('click', toggleMenu);
    </script>
</body>
</html>