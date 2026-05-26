<?php

namespace App\Http\Controllers;

use App\Models\Ordencompra;
use App\Models\Proveedor;
use App\Models\Metodopago;
use Illuminate\Http\Request;

class OrdencompraController extends Controller
{
    // =========================
    // LISTAR
    // =========================
    public function index()
    {
$ordencompras = Ordencompra::all();

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
        $metodospago = Metodopago::where(
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
    public function store(Request $request)
    {
        try {

            // =========================
            // crear orden
            // =========================
            Ordencompra::create([

                'fecha' => now(),

                'proveedor_id' => $request->proveedor_id,

                'total' => $request->total,

                'tipopago' => $request->tipopago,

                'saldopendiente' =>
                    $request->saldopendiente ?? 0,

                'estado' => 1,

                'registradopor' =>
                    auth()->user()->name
            ]);

            return redirect()
                ->route('ordencompras.index')
                ->with(
                    'success',
                    'Orden creada correctamente'
                );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    // =========================
    // MOSTRAR
    // =========================
    public function show($id)
    {
        $ordencompra = Ordencompra::findOrFail($id);

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
        $ordencompra = Ordencompra::findOrFail($id);

        $proveedores = Proveedor::where(
            'estado',
            1
        )->get();

        $metodospago = Metodopago::where(
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
        Request $request,
        $id
    )
    {
        try {

            $ordencompra =
                Ordencompra::findOrFail($id);

            $ordencompra->update([

                'proveedor_id' =>
                    $request->proveedor_id,

                'total' => $request->total,

                'tipopago' =>
                    $request->tipopago,

                'saldopendiente' =>
                    $request->saldopendiente
            ]);

            return redirect()
                ->route('ordencompras.index')
                ->with(
                    'success',
                    'Orden actualizada correctamente'
                );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy($id)
    {
        try {

            $ordencompra =
                Ordencompra::findOrFail($id);

            // =========================
            // ELIMINAR DETALLES ASOCIADOS
            // =========================
            $ordencompra->detallesCompras()->delete();

            // =========================
            // ELIMINAR PAGOS ASOCIADOS
            // =========================
            $ordencompra->pagos()->delete();

            // =========================
            // ELIMINAR ORDEN
            // =========================
            $ordencompra->delete();

            return redirect()
                ->route('ordencompras.index')
                ->with(
                    'success',
                    'Orden eliminada correctamente'
                );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}