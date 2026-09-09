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
    <title>Galería Multimedia - Alcaldía de Esmeraldas</title>
    
    <!-- Favicon dinámico desde la base de datos -->
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

    <!-- Menú / Cabecera -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ url('/') }}">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-14 object-contain">
                    @else
                        <img src="./assets/logo_c.png" alt="Logo" class="h-14 object-contain">
                    @endif
                </a>
            </div>
            
            <!-- Botón Dinámico según sesión -->
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-institucional px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm flex items-center">
                        <i class="bi bi-speedometer2 mr-2"></i> Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-institucional px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm flex items-center">
                        <i class="bi bi-person-circle mr-2"></i> Iniciar sesión
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-800">Galería Pública de Fotos y Videos</h1>
            <p class="text-gray-600 text-sm mt-1">Explora las últimas publicaciones multimedia. Haz clic en cualquiera para ampliarla.</p>
        </div>

        @if(isset($galleries) && $galleries->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($galleries as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                        <div class="overflow-hidden cursor-pointer relative group" onclick="openModal('{{ asset($item->file_path) }}', '{{ $item->type }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}')">
                            @if($item->type == 'image')
                                <img src="{{ asset($item->file_path) }}" alt="{{ $item->title }}" class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="relative w-full h-52 bg-black flex items-center justify-center">
                                    <video class="w-full h-full object-cover opacity-90 transition-transform duration-500 group-hover:scale-105">
                                        <source src="{{ asset($item->file_path) }}" type="video/mp4">
                                    </video>
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/10 transition">
                                        <i class="bi bi-play-circle-fill text-white text-5xl drop-shadow-lg"></i>
                                    </div>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-full font-semibold backdrop-blur-xs"><i class="bi bi-zoom-in mr-1"></i> Ampliar</span>
                            </div>
                        </div>
                        
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $item->title }}</h3>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $item->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                <i class="bi bi-images text-4xl text-gray-300 mb-3 block"></i>
                <p class="text-gray-500 text-base font-medium">No hay publicaciones disponibles todavía.</p>
            </div>
        @endif
    </main>

    <!-- Modal para Ampliar Imagen o Video -->
    <div id="mediaModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4 sm:p-6 transition-opacity opacity-0 duration-300">
        <div class="bg-white rounded-3xl max-w-4xl w-full overflow-hidden shadow-2xl relative transform scale-95 transition-transform duration-300" id="modalContainer" onclick="event.stopPropagation()">
            <!-- Botón Cerrar -->
            <button onclick="closeModal()" class="absolute top-4 right-4 z-10 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition cursor-pointer text-lg">
                <i class="bi bi-x-lg"></i>
            </button>

            <!-- Contenedor del contenido multimedia -->
            <div class="bg-black flex items-center justify-center max-h-[65vh] overflow-hidden" id="modalMediaContainer">
                <!-- Se inyecta dinámicamente imagen o video -->
            </div>

            <!-- Información del archivo -->
            <div class="p-6 bg-white">
                <h3 id="modalTitle" class="font-black text-xl text-gray-900 mb-1"></h3>
                <p id="modalDescription" class="text-gray-600 text-sm leading-relaxed"></p>
            </div>
        </div>
    </div>

    <!-- Script del Modal -->
    <script>
        const modal = document.getElementById('mediaModal');
        const modalContainer = document.getElementById('modalContainer');
        const modalMediaContainer = document.getElementById('modalMediaContainer');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');

        function openModal(filePath, type, title, description) {
            modalMediaContainer.innerHTML = '';
            
            if (type === 'image') {
                modalMediaContainer.innerHTML = `<img src="${filePath}" class="max-h-[65vh] w-auto object-contain mx-auto">`;
            } else {
                modalMediaContainer.innerHTML = `<video src="${filePath}" controls autoplay class="max-h-[65vh] w-auto object-contain mx-auto"></video>`;
            }

            modalTitle.textContent = title;
            modalDescription.textContent = description;

            modal.classList.remove('hidden');
            modal.classList.flex; // asegurar flex
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContainer.classList.remove('scale-95');
                modalContainer.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modalContainer.classList.remove('scale-100');
            modalContainer.classList.add('scale-95');
            
            // Pausar video si lo hay al cerrar
            const video = modalMediaContainer.querySelector('video');
            if (video) video.pause();

            setTimeout(() => {
                modal.classList.add('hidden');
                modalMediaContainer.innerHTML = '';
            }, 300);
        }

        // Cerrar al hacer clic fuera del cuadro blanco
        modal.addEventListener('click', closeModal);

        // Cerrar con la tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>

</body>
</html>