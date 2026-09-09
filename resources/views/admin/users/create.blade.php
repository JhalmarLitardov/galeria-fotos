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
    <title>Crear Usuario - Panel de Administración</title>
    @if($favicon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="https://esmeraldas.gob.ec/wp-content/uploads/2020/06/cropped-favicon-gadme-32x32.png">
    @endif
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .form-control-custom {
            border-radius: 12px !important;
            border: 1.5px solid #d1d5db !important;
            padding: 12px 18px !important;
            background-color: #fff !important;
            transition: all 0.3s ease;
            width: 100%;
            outline: none;
        }
        .form-control-custom:focus {
            border-color: #2e7d32 !important;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15) !important;
        }
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

    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-14 object-contain">
                    @else
                        <img src="./assets/logo_c.png" alt="Logo" class="h-14 object-contain">
                    @endif
                </a>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-gray-600 hover:text-[#2e7d32] transition">
                    <i class="bi bi-arrow-left"></i> Volver a la lista
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-12">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
            <h1 class="text-2xl font-black text-gray-800 mb-2">Crear Nuevo Usuario</h1>
            <p class="text-gray-600 text-sm mb-6">Ingresa los datos y define el rol del nuevo usuario en la plataforma.</p>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nombre completo</label>
                    <input type="text" name="name" class="form-control-custom text-gray-800" value="{{ old('name') }}" placeholder="Ej. Juan Pérez" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control-custom text-gray-800" value="{{ old('email') }}" placeholder="correo@esmeraldas.gob.ec" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contraseña temporal</label>
                    <input type="password" name="password" class="form-control-custom text-gray-800" placeholder="Mínimo 6 caracteres" required>
                </div>

                <!-- SELECCIÓN DE ROL -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Rol del Usuario</label>
                    <select name="role" class="form-control-custom text-gray-800" required>
                        <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Usuario Normal / Editor (Solo administra y gestiona galería)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador (Control total de usuarios y sistema)</option>
                    </select>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">Cancelar</a>
                    <button type="submit" class="btn-institucional px-6 py-3 rounded-xl text-sm font-bold shadow-sm">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>