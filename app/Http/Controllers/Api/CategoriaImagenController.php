<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaImagen;
use Illuminate\Http\Request;

class CategoriaImagenController extends Controller
{
    /**
     * Mostrar una lista de los recursos.
     */
    public function index()
    {
        $categorias = CategoriaImagen::all();
        return response()->json($categorias, 200);
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = CategoriaImagen::create($validatedData);

        return response()->json([
            'mensaje' => 'Categoría creada exitosamente',
            'datos' => $categoria,
        ], 201);
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show(string $id)
    {
        $categoria = CategoriaImagen::find($id);

        if (!$categoria) {
            return response()->json(['mensaje' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria, 200);
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        $categoria = CategoriaImagen::find($id);

        if (!$categoria) {
            return response()->json(['mensaje' => 'Categoría no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
        ]);

        $categoria->update($validatedData);

        return response()->json([
            'mensaje' => 'Categoría actualizada exitosamente',
            'datos' => $categoria,
        ], 200);
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy(string $id)
    {
        $categoria = CategoriaImagen::find($id);

        if (!$categoria) {
            return response()->json(['mensaje' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['mensaje' => 'Categoría eliminada exitosamente'], 200);
    }
}
