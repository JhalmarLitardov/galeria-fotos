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
    <title>Panel de Configuración - Apariencia</title>
    
    <!-- FAVICON DINÁMICO -->
    @if($favicon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="https://esmeraldas.gob.ec/wp-content/uploads/2020/06/cropped-favicon-gadme-32x32.png">
    @endif

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <!-- Barra superior con accesos a Dashboard y Login -->
    <nav class="bg-[#2e7d32] text-white shadow-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-sliders text-xl"></i>
                    <span class="font-bold text-lg">Panel de Administración - Configuración</span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center">
                        <i class="fa-solid fa-gauge mr-2"></i> Ir al Dashboard
                    </a>
                    <a href="{{ route('login') }}" class="text-sm bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Ir al Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 sm:p-10">
            
            <div class="mb-8 border-b border-gray-100 pb-4">
                <h1 class="text-2xl font-black text-gray-900">Apariencia del Sistema</h1>
                <p class="text-sm text-gray-500 mt-1">Sube las imágenes institucionales que se mostrarán en la plataforma y el login.</p>
            </div>

            <!-- Alerta de éxito -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-[#2e7d32] text-emerald-800 rounded-r-xl text-sm">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl text-sm">
                    <p class="font-semibold mb-1">Corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario con método POST y enctype para archivos -->
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- 1. LOGO INSTITUCIONAL -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center p-4 bg-gray-50 rounded-2xl border border-gray-200">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-gray-800">Logo Institucional</label>
                        <p class="text-xs text-gray-500 mt-1">Aparece en la parte superior izquierda del login y el dashboard.</p>
                    </div>
                    <div class="md:col-span-2 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        @if(isset($settings->system_logo) && $settings->system_logo)
                            <div class="w-24 h-24 bg-white border border-gray-200 rounded-xl flex items-center justify-center p-2 shadow-sm">
                                <img src="{{ asset('storage/' . $settings->system_logo) }}" alt="Logo Actual" class="max-h-full max-w-full object-contain">
                            </div>
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-xl flex items-center justify-center text-xs text-gray-400 text-center p-2">Sin logo</div>
                        @endif
                        <div class="w-full">
                            <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#2e7d32]/10 file:text-[#2e7d32] hover:file:bg-[#2e7d32]/20 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- 2. FAVICON -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center p-4 bg-gray-50 rounded-2xl border border-gray-200">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-gray-800">Favicon</label>
                        <p class="text-xs text-gray-500 mt-1">Icono de la pestaña del navegador.</p>
                    </div>
                    <div class="md:col-span-2 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        @if(isset($settings->favicon) && $settings->favicon)
                            <div class="w-16 h-16 bg-white border border-gray-200 rounded-xl flex items-center justify-center p-2 shadow-sm">
                                <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon Actual" class="max-h-full max-w-full object-contain">
                            </div>
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-xl flex items-center justify-center text-xs text-gray-400 text-center p-2">Sin favicon</div>
                        @endif
                        <div class="w-full">
                            <input type="file" name="favicon" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#2e7d32]/10 file:text-[#2e7d32] hover:file:bg-[#2e7d32]/20 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- 3. FONDO DE LOGIN -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center p-4 bg-gray-50 rounded-2xl border border-gray-200">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-gray-800">Fondo del Login</label>
                        <p class="text-xs text-gray-500 mt-1">Imagen decorativa del panel lateral del login.</p>
                    </div>
                    <div class="md:col-span-2 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        @if(isset($settings->login_background) && $settings->login_background)
                            <div class="w-32 h-20 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                <img src="{{ asset('storage/' . $settings->login_background) }}" alt="Fondo Actual" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-32 h-20 bg-gray-200 rounded-xl flex items-center justify-center text-xs text-gray-400 text-center p-2">Sin fondo</div>
                        @endif
                        <div class="w-full">
                            <input type="file" name="login_background" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#2e7d32]/10 file:text-[#2e7d32] hover:file:bg-[#2e7d32]/20 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Botón Guardar -->
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="btn-institucional px-8 py-3.5 rounded-xl font-bold transition shadow-lg cursor-pointer text-sm flex items-center">
                        <i class="fa-solid fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>