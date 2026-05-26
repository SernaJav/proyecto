<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\OrdenCompra;
use App\Models\MetodoPago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    // =========================
    // LISTAR
    // =========================
    public function index()
    {
        $pagos = Pago::with(['ordenCompra', 'metodoPago'])
            ->paginate(10);

        return view('pagos.index', compact('pagos'));
    }

    // =========================
    // CREAR
    // =========================
    public function create()
    {
        $ordenes = OrdenCompra::all();
        $metodos = MetodoPago::where('estado', 1)->get();

        return view('pagos.create', compact('ordenes', 'metodos'));
    }

    // =========================
    // MOSTRAR
    // =========================
    public function show($id)
    {
        $pago = Pago::with(['ordenCompra', 'metodoPago'])
            ->findOrFail($id);

        return view('pagos.show', compact('pago'));
    }

    // =========================
    // GUARDAR
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'ordencompra_id' => 'required',
            'metodopago_id' => 'required',
            'monto' => 'required|numeric'
        ]);

        // =========================
        // Guardar pago
        // =========================
        Pago::create([
            'ordencompra_id' => $request->ordencompra_id,
            'metodopago_id' => $request->metodopago_id,
            'fechapago' => $request->fechapago ?? now()->toDateString(),
            'monto' => $request->monto,
            'registradopor' => auth()->user()->name
        ]);

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    // =========================
    // EDITAR
    // =========================
    public function edit($id)
    {
        $pago = Pago::findOrFail($id);

        $ordenes = OrdenCompra::all();
        $metodos = MetodoPago::where('estado', 1)->get();

        return view('pagos.edit', compact('pago', 'ordenes', 'metodos'));
    }

    // =========================
    // ACTUALIZAR
    // =========================
    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);

        $pago->update([
            'ordencompra_id' => $request->ordencompra_id,
            'metodopago_id' => $request->metodopago_id,
            'fechapago' => $request->fechapago,
            'monto' => $request->monto
        ]);

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago actualizado.');
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago eliminado.');
    }

}