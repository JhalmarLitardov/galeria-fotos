<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Apariencia</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-emerald-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Panel Administrador</h1>
            <a href="{{ url('/admin/dashboard') }}" class="hover:underline text-sm">Volver al Dashboard</a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Configuración de Apariencia del Sistema</h2>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.appearance.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Fondo del Login (Rojo) -->
                <div class="border-b pb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fondo de la Vista de Login</label>
                    @if($setting->login_background)
                        <div class="mb-2">
                            <img src="{{ asset($setting->login_background) }}" class="h-28 w-auto object-cover rounded border">
                        </div>
                    @endif
                    <input type="file" name="login_background" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <!-- Logo del Sistema (Amarillo) -->
                <div class="border-b pb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Logo del Menú / Sistema</label>
                    @if($setting->system_logo)
                        <div class="mb-2">
                            <img src="{{ asset($setting->system_logo) }}" class="h-16 w-auto object-contain rounded border bg-gray-50 p-1">
                        </div>
                    @endif
                    <input type="file" name="system_logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <!-- Favicon (Morado) -->
                <div class="pb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Favicon (Icono de pestaña)</label>
                    @if($setting->favicon)
                        <div class="mb-2">
                            <img src="{{ asset($setting->favicon) }}" class="h-10 w-10 object-contain rounded border p-1 bg-gray-50">
                        </div>
                    @endif
                    <input type="file" name="favicon" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-emerald-700 transition">
                    Guardar Cambios
                </button>
            </form>
        </div>
    </main>

</body>
</html>