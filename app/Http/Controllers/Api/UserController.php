<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all photographers (users with role_id = 2).
     */
    public function getPhotographers()
    {
        $photographers = User::where('role_id', 2)->with('imagenes', 'products', 'clientOrders', 'photographerOrders')->get();

        if ($photographers->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron fotógrafos'], 404);
        }

        return response()->json($photographers, 200);
    }

    /**
     * Get all users.
     */
    public function index()
    {
        $users = User::with('imagenes', 'products', 'clientOrders', 'photographerOrders')->get();
        return response()->json($users, 200);
    }

    /**
     * Get a specific user by ID.
     */
    public function show($id)
    {
        $user = User::with('imagenes', 'products', 'clientOrders', 'photographerOrders')->find($id);

        if (!$user) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update a specific user by ID.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $id,
            'phone' => 'sometimes|required|string|max:15',
            'cedula' => 'nullable|string|max:20',
            'certificado' => 'nullable|image|max:2048',
            'profile_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:1500',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && \Storage::exists($user->profile_image)) {
                \Storage::delete($user->profile_image);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $validatedData['profile_image'] = $path;
        }

        $user->update($validatedData);

        return response()->json(['mensaje' => 'Usuario actualizado exitosamente', 'datos' => $user], 200);
    }

    /**
     * Delete a specific user by ID.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['mensaje' => 'Usuario eliminado exitosamente'], 200);
    }
}