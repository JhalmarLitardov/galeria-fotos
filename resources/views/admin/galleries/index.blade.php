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
    <title>Gestionar Galería - Panel de Administración</title>
    
    <!-- FAVICON DINÁMICO -->
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
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-14 object-contain">
                    @else
                        <img src="./assets/logo_c.png" alt="Logo" class="h-14 object-contain">
                    @endif
                </a>
            </div>
            <!-- Volver al Dashboard a la Derecha -->
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-[#2e7d32] transition flex items-center">
                    <i class="bi bi-arrow-left mr-1"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-800">Galería de Fotos y Videos</h1>
                <p class="text-gray-600 text-sm">Administra y controla el contenido multimedia público de la plataforma.</p>
            </div>
            <a href="{{ route('admin.galleries.create') }}" class="btn-institucional px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm flex items-center">
                <i class="bi bi-plus-circle-fill mr-2 text-lg"></i> Nueva Publicación
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl text-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de Contenido Multimedia -->
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 px-6">Archivo</th>
                            <th class="py-4 px-6">Título</th>
                            <th class="py-4 px-6">Tipo</th>
                            <th class="py-4 px-6 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse($galleries as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if($item->type == 'image')
                                        <img src="{{ asset($item->file_path) }}" class="h-16 w-24 object-cover rounded-xl border border-gray-200 shadow-xs">
                                    @else
                                        <video class="h-16 w-24 object-cover rounded-xl border border-gray-200 shadow-xs">
                                            <source src="{{ asset($item->file_path) }}" type="video/mp4">
                                        </video>
                                    @endif
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap font-semibold text-gray-900">{{ $item->title }}</td>
                                <td class="py-4 px-6 whitespace-nowrap text-gray-500 uppercase text-xs font-bold">
                                    <span class="px-2.5 py-1 bg-gray-100 rounded-md">{{ $item->type }}</span>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.galleries.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este archivo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-bold transition cursor-pointer">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-400">No hay publicaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6">
            {{ $galleries->links() }}
        </div>
    </main>

</body>
</html>