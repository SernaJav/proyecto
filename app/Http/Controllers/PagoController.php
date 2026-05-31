<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoRequest;
use App\Models\Pago;
use App\Models\OrdenCompra;
use App\Models\MetodoPago;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;

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
    public function store(PagoRequest $request)
    {
        try {
            $data = $request->validated();
            $data['fechapago'] = $data['fechapago'] ?? now()->toDateString();
            $data['registradopor'] = auth()->user()->name;

            Pago::create($data);

            return redirect()
                ->route('pagos.index')
                ->with('success', 'Pago registrado correctamente.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->withErrors('Ocurrió un error inesperado al registrar el pago');
        }
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
    public function update(PagoRequest $request, $id)
    {
        try {
            $pago = Pago::findOrFail($id);
            $data = $request->validated();

            $pago->update($data);

            return redirect()
                ->route('pagos.index')
                ->with('success', 'Pago actualizado.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->withErrors('Ocurrió un error inesperado al actualizar el pago');
        }
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy($id)
    {
        try {
            $pago = Pago::findOrFail($id);
            $pago->delete();

            return redirect()
                ->route('pagos.index')
                ->with('success', 'Pago eliminado.');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('pagos.index')
                ->withErrors('El registro tiene información relacionada');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('pagos.index')
                ->withErrors('Ocurrió un error inesperado');
        }
    }

}