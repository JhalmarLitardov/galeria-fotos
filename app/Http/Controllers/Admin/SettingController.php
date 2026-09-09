<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppearanceSetting;

class SettingController extends Controller
{
    public function edit()
    {
        // Obtenemos el primer registro de configuración (o un objeto vacío si no hay filas)
        $settings = AppearanceSetting::first() ?? new AppearanceSetting();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        // Buscamos el primer registro o creamos uno nuevo
        $setting = AppearanceSetting::first() ?? new AppearanceSetting();

        $fields = [
            'logo' => 'system_logo',
            'favicon' => 'favicon',
            'login_background' => 'login_background',
        ];

        foreach ($fields as $inputName => $columnName) {
            if ($request->hasFile($inputName)) {
                // Guarda en storage/app/public/settings y devuelve ej: settings/archivo.png
                $path = $request->file($inputName)->store('settings', 'public');
                
                // Asignamos directamente la ruta relativa para usarla con asset('storage/' . ...)
                $setting->$columnName = $path;
            }
        }

        $setting->save();

        return redirect()->route('admin.settings.edit')->with('success', '¡Imágenes actualizadas con éxito!');
    }
}