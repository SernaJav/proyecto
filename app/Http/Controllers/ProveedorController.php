<?php

namespace App\Http\Controllers;

// =========================
// IMPORTAR MODELO
// =========================
use App\Models\Proveedor;
use App\Http\Requests\ProveedorRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
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
    public function store(ProveedorRequest $request)
    {
        $data = $request->validated();

        $data['estado'] = 1;
        $data['registradopor'] = auth()->user()->name;

        Proveedor::create($data);

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
    public function update(ProveedorRequest $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $data = $request->validated();

        $proveedor->update($data);

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
        $proveedor = Proveedor::findOrFail($id);

        try {
            if ($proveedor->ordenesCompra()->count() > 0) {
                return redirect()
                    ->back()
                    ->withErrors('El registro tiene información relacionada');
            }

            $proveedor->delete();

            return redirect()
                ->route('proveedores.index')
                ->with('success', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('proveedores.index')
                ->withErrors('El registro tiene información relacionada');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('proveedores.index')
                ->withErrors('Ocurrió un error inesperado');
        }
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