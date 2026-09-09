@php
    $settings = \App\Models\AppearanceSetting::first();
    $logo = $settings->system_logo ?? null;
    $favicon = $settings->favicon ?? null;
    $loginBackground = $settings->login_background ?? null;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Alcaldía de Esmeraldas</title>
    @if($favicon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="https://esmeraldas.gob.ec/wp-content/uploads/2020/06/cropped-favicon-gadme-32x32.png">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <style>
        .form-control-custom {
            border-radius: 50px !important;
            border: 2px solid #2e7d32 !important;
            padding: 14px 28px !important;
            background-color: transparent !important;
            transition: all 0.3s ease;
            width: 100%;
            outline: none;
            font-size: 1rem !important;
        }
        .form-control-custom:focus {
            box-shadow: 0 0 12px rgba(46, 125, 50, 0.35) !important;
            border-color: #1b5e20 !important;
            background-color: #fff !important;
        }
        .btn-institucional {
            border-radius: 50px !important;
            background-color: #2e7d32 !important;
            border: none !important;
            padding: 15px 0 !important;
            color: white !important;
            font-weight: bold;
            width: 100%;
            font-size: 1.05rem !important;
            transition: all 0.3s ease;
        }
        .btn-institucional:hover {
            background-color: #1b5e20 !important;
            transform: scale(1.02);
            box-shadow: 0 6px 18px rgba(0,0,0,0.2);
        }
        .btn-volver {
            border-radius: 50px !important;
            background-color: #f1f8f3 !important;
            border: 2px solid #2e7d32 !important;
            padding: 12px 0 !important;
            color: #2e7d32 !important;
            font-weight: bold;
            width: 100%;
            font-size: 1rem !important;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-volver:hover {
            background-color: #2e7d32 !important;
            color: white !important;
        }
        #auth-right {
            background-image: url('{{ $loginBackground ? asset('storage/' . $loginBackground) : '' }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 94vh;
            width: 100%;
            border-top-left-radius: 350px;
            border-bottom-left-radius: 350px;
        }
    </style>
</head>
<body class="bg-white m-0 p-0 overflow-hidden font-sans">
    <div class="min-h-screen w-full flex flex-col lg:flex-row h-screen items-center justify-between">
        
        <!-- Columna Izquierda: Formulario de Registro -->
        <div class="w-full lg:w-5/12 h-screen overflow-y-auto px-10 sm:px-14 py-8 flex flex-col justify-between items-center text-center bg-white z-10">
            <div class="w-full max-w-md mx-auto my-auto">
                <div class="mb-6 flex justify-center">
                    <a href="{{ route('login') }}">
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-32 object-contain mx-auto">
                        @else
                            <img src="./assets/logo_c.png" alt="Logo" class="h-32 object-contain mx-auto">
                        @endif
                    </a>
                </div>
                
                <h1 class="text-2xl font-black text-slate-800 mb-6 tracking-tight">Crear Cuenta Nueva</h1>
                
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-2xl text-sm text-left">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="POST" class="w-full space-y-4">
                    @csrf
                    <div>
                        <input type="text" class="form-control-custom text-gray-800" name="name" value="{{ old('name') }}" placeholder="Nombre Completo" required>
                    </div>
                    
                    <div>
                        <input type="email" class="form-control-custom text-gray-800" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" required>
                    </div>
                    
                    <div>
                        <input type="password" class="form-control-custom text-gray-800" name="password" placeholder="Contraseña (mínimo 6 caracteres)" required>
                    </div>

                    <div>
                        <input type="password" class="form-control-custom text-gray-800" name="password_confirmation" placeholder="Confirmar Contraseña" required>
                    </div>

                    <button class="btn btn-institucional shadow-lg cursor-pointer mt-2" type="submit">Registrarse</button>
                </form>
                
                <div class="w-full mt-4">
                    <a href="{{ route('login') }}" class="btn-volver shadow-sm">
                        <i class="bi bi-arrow-left mr-2"></i> Ya tengo una cuenta (Iniciar Sesión)
                    </a>
                </div>
            </div>
            <!-- Footer institucional -->
            <div class="text-center text-xs pb-4 leading-relaxed">
                <a target="_blank" href="https://www.esmeraldas.gob.ec/" class="text-gray-500 hover:text-[#2e7d32] transition">
                    Copyright © <script>document.write(new Date().getFullYear());</script> LA GALERÍA<br>
                    <span class="font-semibold text-[#2e7d32] text-sm">Galería de Fotos y Videos</span>
                </a>
            </div>
        </div>

        <!-- Columna Derecha: Fondo Institucional -->
        <div class="hidden lg:flex lg:w-7/12 h-screen items-center justify-end pr-4 bg-white">
            <div id="auth-right" class="shadow-md flex items-center justify-center"></div>
        </div>

    </div>
</body>
</html>