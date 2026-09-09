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
    <title>Alcaldía de Esmeraldas - Sistema de Galería</title>
    @if($favicon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="https://esmeraldas.gob.ec/wp-content/uploads/2020/06/cropped-favicon-gadme-32x32.png">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Estilo "Pill" más grande y espacioso para los inputs */
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

        /* Contenedor para el icono del ojo */
        .password-wrapper { position: relative; }
        .toggle-password {
            position: absolute;
            right: 28px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #2e7d32;
            font-size: 1.3rem;
        }

        /* Estilo botón más grande */
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

        /* Estilo para el botón de Registro (Secundario / Outline) */
        .btn-registro {
            border-radius: 50px !important;
            background-color: transparent !important;
            border: 2px solid #2e7d32 !important;
            padding: 14px 0 !important;
            color: #2e7d32 !important;
            font-weight: bold;
            width: 100%;
            font-size: 1rem !important;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-registro:hover {
            background-color: #f1f8f3 !important;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15);
        }

        /* Estilo para el botón de Sitio Público */
        .btn-publico {
            border-radius: 50px !important;
            background-color: #f1f8f3 !important;
            border: 2px solid #2e7d32 !important;
            padding: 14px 0 !important;
            color: #2e7d32 !important;
            font-weight: bold;
            width: 100%;
            font-size: 1rem !important;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-publico:hover {
            background-color: #2e7d32 !important;
            color: white !important;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
        }

        /* Efectos */
        .forgot-link { transition: all 0.3s ease; display: inline-block; color: #2e7d32; text-decoration: none; }
        .forgot-link:hover { color: #1b5e20 !important; transform: translateX(5px); }

        /* Fondo derecho con curva mucho más pronunciada y alargada */
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
    <div id="auth" class="min-h-screen w-full">
        <div class="flex flex-col lg:flex-row h-screen w-full items-center justify-between">
            
            <!-- Columna Izquierda: Logo y Formulario Centrados y con Escala Ampliada -->
            <div class="w-full lg:w-5/12 h-screen overflow-y-auto px-10 sm:px-14 py-10 flex flex-col justify-between items-center text-center bg-white z-10">
                <div class="w-full max-w-md mx-auto my-auto">
                    <!-- Logo más grande -->
                    <div class="mb-10 flex justify-center">
                        <a href="{{ route('login') }}">
                            @if($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-40 object-contain mx-auto transition-transform duration-500 hover:scale-105">
                            @else
                                <img src="./assets/logo_c.png" alt="Logo" class="h-40 object-contain mx-auto transition-transform duration-500 hover:scale-105">
                            @endif
                        </a>
                    </div>
                    
                    <!-- Título más grande -->
                    <h1 class="text-2xl font-black text-slate-800 mb-8 tracking-tight text-center">Inicio de sesión</h1>
                    
                    @if($errors->any())
                        <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-2xl text-sm text-left">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario con mejor presencia visual -->
                    <form id="formLogin" action="{{ route('login') }}" method="POST" class="w-full space-y-5">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control-custom text-gray-800" id="email" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" required>
                        </div>
                        
                        <!-- Contraseña con icono de ojo -->
                        <div class="form-group password-wrapper">
                            <input type="password" class="form-control-custom text-gray-800" id="password" name="password" placeholder="Contraseña" required>
                            <i class="bi bi-eye toggle-password" id="togglePassword"></i>
                        </div>

                        <div class="text-center pt-1">
                            <p><a class="font-bold forgot-link text-sm" href="{{ route('password.request') }}"><i class="bi bi-shield-x"></i> Olvidé mi contraseña</a></p>
                        </div>

                        <button class="btn btn-institucional shadow-lg cursor-pointer mt-2" type="submit">Acceder</button>
                    </form>
                    
                    <!-- Botón de Crear Cuenta / Registro para nuevos usuarios -->
                    <div class="w-full mt-4">
                        <a href="{{ route('register') }}" class="btn-registro shadow-sm">
                            <i class="bi bi-person-plus-fill mr-2"></i> Crear cuenta nueva
                        </a>
                    </div>

                    <!-- Botón de Sitio Público -->
                    <div class="w-full mt-3">
                        <a href="{{ url('/') }}" class="btn-publico shadow-sm">
                            <i class="bi bi-globe mr-2"></i> Sitio Público
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

            <!-- Columna Derecha: Gráfica con curva muy alargada y redondeada -->
            <div class="hidden lg:flex lg:w-7/12 h-screen items-center justify-end pr-4 bg-white">
                <div id="auth-right" class="shadow-md flex items-center justify-center">
                    @if(!$loginBackground)
                        <div class="flex items-center justify-center h-full text-gray-400 text-sm p-8 text-center bg-white/80 rounded-l-[350px]">
                            <span>(Sube tu imagen de fondo con la curva desde /admin/settings)</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        const togglePasswordBtn = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        }
    </script>
</body>
</html>