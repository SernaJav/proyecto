<?php

namespace App\Http\Controllers;

// =========================
// IMPORTAR MODELO
// =========================
use App\Models\Proveedor;

// =========================
// REQUEST
// =========================
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // =========================
    // LISTAR
    // =========================
    public function index()
    {
        $proveedores = Proveedor::all();

        return view(
            'proveedores.index',
            compact('proveedores')
        );
    }

    // =========================
    // FORM CREAR
    // =========================
    public function create()
    {
        return view('proveedores.create');
    }

    // =========================
    // MOSTRAR
    // =========================
    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view(
            'proveedores.show',
            compact('proveedor')
        );
    }

    // =========================
    // GUARDAR
    // =========================
    public function store(Request $request)
    {
        // =========================
        // VALIDAR
        // =========================
        $request->validate([

            'nombre' => 'required',

            'documento' => 'required',

            'email' => 'required|email'

        ]);

        // =========================
        // CREAR
        // =========================
        Proveedor::create([

            'nombre' => $request->nombre,

            'documento' => $request->documento,

            'direccion' => $request->direccion,

            'telefono' => $request->telefono,

            'email' => $request->email,

            'estado' => 1,

            'registradopor' => auth()->user()->name

        ]);

        return redirect()
            ->route('proveedores.index')
            ->with(
                'success',
                'Proveedor creado exitosamente.'
            );
    }

    // =========================
    // EDITAR
    // =========================
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view(
            'proveedores.edit',
            compact('proveedor')
        );
    }

    // =========================
    // ACTUALIZAR
    // =========================
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update([

            'nombre' => $request->nombre,

            'documento' => $request->documento,

            'direccion' => $request->direccion,

            'telefono' => $request->telefono,

            'email' => $request->email

        ]);

        return redirect()
            ->route('proveedores.index')
            ->with(
                'success',
                'Proveedor actualizado exitosamente.'
            );
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy($id)
    {
        // =========================
        // BUSCAR
        // =========================
        $proveedor = Proveedor::findOrFail($id);

        // =========================
        // VALIDAR ORDENES
        // =========================
        if ($proveedor->ordenesCompra()->count() > 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'No se puede eliminar el proveedor porque tiene órdenes de compra asociadas.'
                );
        }

        // =========================
        // ELIMINAR
        // =========================
        $proveedor->delete();

        return redirect()
            ->route('proveedores.index')
            ->with(
                'success',
                'Proveedor eliminado exitosamente.'
            );
    }

    // =========================
    // CAMBIAR ESTADO
    // =========================
    public function cambioestado(Request $request)
    {
        // =========================
        // BUSCAR
        // =========================
        $proveedor = Proveedor::find($request->id);

        // =========================
        // VALIDAR
        // =========================
        if (!$proveedor) {

            return response()->json([

                'success' => false,

                'message' => 'Proveedor no encontrado'

            ]);
        }

        // =========================
        // CAMBIAR ESTADO
        // =========================
        $proveedor->estado = $request->estado;

        // =========================
        // GUARDAR
        // =========================
        $proveedor->save();

        // =========================
        // RESPUESTA
        // =========================
        return response()->json([

            'success' => true,

            'message' => 'Estado actualizado correctamente'

        ]);
    }
}