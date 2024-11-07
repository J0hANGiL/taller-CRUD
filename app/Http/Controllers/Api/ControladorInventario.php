<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControladorInventario extends Controller
{
    public function index()
    {
        $inventario = Inventario::all();

        if ($inventario->isEmpty()) {
            $data = [
                'message' => 'No hay ningún producto registrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($inventario, 200);
    }

    public function agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required',
            'nombre' => 'required',
            'precio' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $inventario = Inventario::create([
            'fecha' => $request->fecha,
            'nombre' => $request->nombre,
            'precio' => $request->precio
        ]);

        if (!$inventario) {
            $data = [
                'message' => 'Error al agregar producto a inventario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'inventario' => $inventario,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required',
            'nombre' => 'required',
            'precio' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Buscar el producto en el inventario por ID
        $inventario = Inventario::find($id);

        if (!$inventario) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Actualizar los datos del producto
        $inventario->fecha = $request->fecha;
        $inventario->nombre = $request->nombre;
        $inventario->precio = $request->precio;
        $inventario->save();

        $data = [
            'message' => 'Producto actualizado con éxito',
            'inventario' => $inventario,
            'status' => 200
        ];

        return response()->json($data, 200);
    }


    public function eliminar($id)
    {
        // Buscar el producto en el inventario por ID
        $inventario = Inventario::find($id);

        if (!$inventario) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Eliminar el producto
        $inventario->delete();

        $data = [
            'message' => 'Producto eliminado con éxito',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
