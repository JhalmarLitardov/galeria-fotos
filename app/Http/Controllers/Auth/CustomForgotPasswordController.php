<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomForgotPasswordController extends Controller
{
    // Muestra el formulario para escribir el correo y la nueva contraseña
    public function showLinkRequestForm()
    {
        return view('auth.passwords.custom-reset');
    }

    // Procesa el cambio de contraseña directo
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.exists' => 'El correo electrónico no se encuentra registrado en el sistema.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Buscar al usuario y actualizar su contraseña directamente
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('status', '¡Contraseña actualizada exitosamente! Ya puedes iniciar sesión.');
    }
}