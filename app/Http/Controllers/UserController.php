<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Obtener todos los roles disponibles para el formulario de creación de usuario
        $roles = Role::all();

        // Retornar la vista de creación de usuarios, pasando los roles
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|exists:roles,id',  // Verifica que el rol exista
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Asignar el rol al usuario
        $user->assignRole(Role::findById($validatedData['roles']));

        // Redirigir al index de usuarios con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Validar la entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Actualizar el usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Sincronizar roles
        $roles = $request->roles; // IDs de roles seleccionados
        $roleNames = Role::whereIn('id', $roles)->pluck('name'); // Obtener nombres de roles
        $user->syncRoles($roleNames); // Sincronizar roles por nombre

        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }
}
