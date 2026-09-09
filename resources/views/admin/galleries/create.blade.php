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
    <title>Nueva Publicación - Panel de Administración</title>
    
    <!-- FAVICON DINÁMICO -->
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
            <!-- Volver a la Galería a la Derecha -->
            <div>
                <a href="{{ route('admin.galleries.index') }}" class="text-sm font-semibold text-gray-600 hover:text-[#2e7d32] transition flex items-center">
                    <i class="bi bi-arrow-left mr-1"></i> Volver a la Galería
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-12">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
            <h1 class="text-2xl font-black text-gray-800 mb-2">Subir Nueva Foto o Video</h1>
            <p class="text-gray-600 text-sm mb-6">Completa los campos para publicar contenido multimedia en la plataforma.</p>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl text-sm border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Título</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="form-control-custom text-gray-800" placeholder="Título de la publicación">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Descripción (Opcional)</label>
                    <textarea name="description" rows="3" class="form-control-custom text-gray-800" placeholder="Breve descripción del contenido...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Archivo</label>
                    <select name="type" required class="form-control-custom text-gray-800">
                        <option value="image">Imagen (JPG, PNG, GIF, etc.)</option>
                        <option value="video">Video (MP4, MOV, MKV, etc.)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Archivo Multimedia</label>
                    <input type="file" name="file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-[#2e7d32]/10 file:text-[#2e7d32] hover:file:bg-[#2e7d32]/20 cursor-pointer border border-gray-200 rounded-xl p-2">
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <a href="{{ route('admin.galleries.index') }}" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">Cancelar</a>
                    <button type="submit" class="btn-institucional px-6 py-3 rounded-xl text-sm font-bold shadow-sm cursor-pointer">
                        Guardar y Publicar
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>