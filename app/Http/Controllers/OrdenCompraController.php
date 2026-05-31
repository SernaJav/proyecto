<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdencompraRequest;
use App\Models\OrdenCompra;
use App\Models\Proveedor;
use App\Models\MetodoPago;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;

class OrdenCompraController extends Controller
{
    // =========================
    // LISTAR
    // =========================
    public function index()
    {
        $ordencompras = OrdenCompra::with(['proveedor', 'pagos'])->get();

        return view(
            'ordencompras.index',
            compact('ordencompras')
        );
    }

    // =========================
    // FORMULARIO CREAR
    // =========================
    public function create()
    {
        // =========================
        // traer proveedores activos
        // =========================
        $proveedores = Proveedor::where(
            'estado',
            1
        )->get();

        // =========================
        // traer métodos de pago activos
        // =========================
        $metodospago = MetodoPago::where(
            'estado',
            1
        )->get();

        return view(
            'ordencompras.create',
            compact(
                'proveedores',
                'metodospago'
            )
        );
    }

    // =========================
    // GUARDAR
    // =========================
    public function store(OrdencompraRequest $request)
    {
        try {

            // =========================
            // crear orden
            // =========================
            $data = $request->validated();
            $data['fecha'] = $data['fecha'] ?? now()->format('Y-m-d');
            $data['estado'] = 1;
            $data['registradopor'] = auth()->user()->name;

            OrdenCompra::create($data);

            return redirect()
                ->route('ordencompras.index')
                ->with(
                    'success',
                    'Orden creada correctamente'
                );

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error inesperado al crear la orden');
        }
    }

    // =========================
    // MOSTRAR
    // =========================
    public function show($id)
    {
        $ordencompra = OrdenCompra::findOrFail($id);

        return view(
            'ordencompras.show',
            compact('ordencompra')
        );
    }

    // =========================
    // EDITAR
    // =========================
    public function edit($id)
    {
        $ordencompra = OrdenCompra::findOrFail($id);

        $proveedores = Proveedor::where(
            'estado',
            1
        )->get();

        $metodospago = MetodoPago::where(
            'estado',
            1
        )->get();

        return view(
            'ordencompras.edit',
            compact(
                'ordencompra',
                'proveedores',
                'metodospago'
            )
        );
    }

    // =========================
    // ACTUALIZAR
    // =========================
    public function update(
        OrdencompraRequest $request,
        $id
    )
    {
        try {

            $ordencompra = OrdenCompra::findOrFail($id);
            $data = $request->validated();

            $ordencompra->update($data);

            return redirect()
                ->route('ordencompras.index')
                ->with(
                    'success',
                    'Orden actualizada correctamente'
                );

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error inesperado al actualizar la orden');
        }
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy($id)
    {
        try {

            $ordencompra = OrdenCompra::findOrFail($id);

            $ordencompra->detallesCompras()->delete();
            $ordencompra->pagos()->delete();
            $ordencompra->delete();

            return redirect()
                ->route('ordencompras.index')
                ->with('success', 'El registro se eliminó exitosamente');

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('ordencompras.index')
                ->withErrors('El registro tiene información relacionada');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('ordencompras.index')
                ->withErrors('Ocurrió un error inesperado');
        }
    }

    public function cambioestado(Request $request)
    {
        $orden = OrdenCompra::find($request->id);

        if (!$orden) {
            return response()->json(['success' => false, 'message' => 'Orden no encontrada']);
        }

        $orden->estado = $request->estado;
        $orden->save();

        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }
}