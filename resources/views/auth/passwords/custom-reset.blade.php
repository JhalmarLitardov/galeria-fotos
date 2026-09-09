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
    <title>Recuperar Contraseña - Alcaldía de Esmeraldas</title>
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
            padding: 16px 28px !important;
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
            padding: 16px 0 !important;
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
    <div class="min-h-screen w-full">
        <div class="flex flex-col lg:flex-row h-screen w-full items-center justify-between">
            
            <div class="w-full lg:w-5/12 h-screen overflow-y-auto px-10 sm:px-14 py-10 flex flex-col justify-between items-center text-center bg-white z-10">
                <div class="w-full max-w-md mx-auto my-auto">
                    <div class="mb-8 flex justify-center">
                        <a href="{{ route('login') }}">
                            @if($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-32 object-contain mx-auto">
                            @else
                                <img src="./assets/logo_c.png" alt="Logo" class="h-32 object-contain mx-auto">
                            @endif
                        </a>
                    </div>
                    
                    <h1 class="text-2xl font-black text-slate-800 mb-6 tracking-tight">Restablecer Contraseña</h1>
                    
                    @if($errors->any())
                        <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-2xl text-sm text-left">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('password.update-custom') }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control-custom text-gray-800" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico registrado" required>
                        </div>
                        
                        <div class="form-group">
                            <input type="password" class="form-control-custom text-gray-800" name="password" placeholder="Nueva contraseña" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control-custom text-gray-800" name="password_confirmation" placeholder="Confirmar nueva contraseña" required>
                        </div>

                        <button class="btn btn-institucional shadow-lg cursor-pointer mt-2" type="submit">Actualizar Contraseña</button>
                    </form>

                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-[#2e7d32] hover:underline">
                            <i class="bi bi-arrow-left"></i> Volver al inicio de sesión
                        </a>
                    </div>
                </div>
                
                <div class="text-center text-xs pb-4 leading-relaxed">
                    <a target="_blank" href="https://www.esmeraldas.gob.ec/" class="text-gray-500 hover:text-[#2e7d32] transition">
                        Copyright © <script>document.write(new Date().getFullYear());</script> LA GALERÍA<br>
                        <span class="font-semibold text-[#2e7d32] text-sm">Galería de Fotos y Videos</span>
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex lg:w-7/12 h-screen items-center justify-end pr-4 bg-white">
                <div id="auth-right" class="shadow-md flex items-center justify-center"></div>
            </div>

        </div>
    </div>
</body>
</html>