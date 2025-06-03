<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    /**
     * Mostrar una lista de los recursos.
     */
    public function index()
    {
        $imagenes = Imagen::all();
        return response()->json($imagenes, 200);
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ruta' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'titulo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categoria_imagenes,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Store the uploaded file
        $filePath = $request->file('ruta')->store('imagenes', 'public');

        // Save the image record in the database
        $imagen = Imagen::create([
            'ruta' => $filePath,
            'titulo' => $validatedData['titulo'],
            'nombre' => $validatedData['nombre'],
            'categoria_id' => $validatedData['categoria_id'],
            'user_id' => $validatedData['user_id'],
        ]);

        return response()->json([
            'mensaje' => 'Imagen subida exitosamente',
            'datos' => $imagen,
        ], 201);
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show(string $id)
    {
        $imagen = Imagen::find($id);

        if (!$imagen) {
            return response()->json(['mensaje' => 'Imagen no encontrada'], 404);
        }

        return response()->json($imagen, 200);
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        $imagen = Imagen::find($id);

        if (!$imagen) {
            return response()->json(['mensaje' => 'Imagen no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'ruta' => 'sometimes|required|string|max:255',
            'categoria_id' => 'sometimes|required|exists:categoria_imagenes,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'nombre' => 'sometimes|required|string|max:255',
        ]);

        $imagen->update($validatedData);

        return response()->json([
            'mensaje' => 'Imagen actualizada exitosamente',
            'datos' => $imagen,
        ], 200);
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy(string $id)
    {
        $imagen = Imagen::find($id);

        if (!$imagen) {
            return response()->json(['mensaje' => 'Imagen no encontrada'], 404);
        }

        $imagen->delete();

        return response()->json(['mensaje' => 'Imagen eliminada exitosamente'], 200);
    }

    /**
     * Obtener todas las imágenes de un usuario específico.
     */
    public function getImagesByUser(string $userId)
    {
        $imagenes = Imagen::where('user_id', $userId)->get();

        if ($imagenes->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron imágenes para este usuario'], 404);
        }

        return response()->json($imagenes, 200);
    }
}
