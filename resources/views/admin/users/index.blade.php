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
    <title>Gestión de Usuarios - Panel de Administración</title>
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
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-14 object-contain">
                    @else
                        <img src="./assets/logo_c.png" alt="Logo" class="h-14 object-contain">
                    @endif
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-[#2e7d32] transition">
                    <i class="bi bi-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-800">Control de Accesos y Usuarios</h1>
                <p class="text-gray-600 text-sm">Administra las cuentas y roles de los usuarios que tienen acceso al sistema.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-institucional px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm flex items-center">
                <i class="bi bi-person-plus-fill mr-2 text-lg"></i> Nuevo Usuario
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl text-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl text-sm border border-green-200">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de Usuarios -->
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 px-6">Nombre</th>
                            <th class="py-4 px-6">Correo Electrónico</th>
                            <th class="py-4 px-6">Rol</th>
                            <th class="py-4 px-6 text-center">Estado</th>
                            <th class="py-4 px-6 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-gray-900">{{ $user->name }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $user->email }}</td>
                                <td class="py-4 px-6">
                                    @if($user->role == 'admin')
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">Administrador</span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Usuario Normal</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($user->is_active ?? true)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Activo</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Desactivado</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <!-- Botón Desactivar / Activar -->
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ ($user->is_active ?? true) ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' }}" title="Cambiar Estado">
                                            {{ ($user->is_active ?? true) ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-bold transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>