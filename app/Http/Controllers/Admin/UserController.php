<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,editor', // Validación para asegurar que el rol sea correcto
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Guardamos el rol seleccionado (admin o editor)
            'is_active' => true, // Por defecto activo
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function destroy(User $user)
    {
        // Evitar que el usuario se elimine a sí mismo
        if(auth()->id() === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function toggleStatus(User $user)
    {
        // Cambiar el estado de activación (desactivar para que no pueda ingresar)
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Estado del usuario actualizado exitosamente.');
    }
}