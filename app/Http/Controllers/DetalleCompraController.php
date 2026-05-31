<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetallecompraRequest;
use App\Models\DetalleCompra;
use App\Models\OrdenCompra;
use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;

class DetalleCompraController extends Controller
{
    // =========================
    // LISTAR
    // =========================
    public function index()
    {
        // 🔥 cargamos orden y producto para poder mostrar datos relacionados
        $detalles = DetalleCompra::with(['ordenCompra', 'producto'])
            ->paginate(10);

        return view('detallecompras.index', compact('detalles'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $ordenes = OrdenCompra::where('estado', 1)->get();
        $productos = Producto::where('estado', 1)->get();

        return view('detallecompras.create', compact('ordenes', 'productos'));
    }

    // =========================
    // MOSTRAR
    // =========================
    public function show($id)
    {
        $detalle = DetalleCompra::with(['ordenCompra', 'producto'])
            ->findOrFail($id);

        return view('detallecompras.show', compact('detalle'));
    }

    // =========================
    // STORE
    // =========================
    public function store(DetallecompraRequest $request)
    {
        try {
            $data = $request->validated();

            $producto = Producto::findOrFail($data['producto_id']);
            $producto->stockmaximo += $data['cantidad'];
            $producto->save();

            $detalle = DetalleCompra::create([
                'ordencompra_id' => $data['ordencompra_id'],
                'producto_id' => $data['producto_id'],
                'cantidad' => $data['cantidad'],
                'subtotal' => $data['subtotal'],
                'registradopor' => auth()->user()->name
            ]);

            $orden = OrdenCompra::findOrFail($data['ordencompra_id']);
            $orden->total += $data['subtotal'];
            $orden->saldopendiente = $orden->total;
            $orden->save();

            return redirect()->route('detallecompras.index')
                ->with('success', 'Compra registrada correctamente');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error al registrar la compra');
        }
    }

    // =========================
    // EDITAR
    // =========================
    public function edit($id)
    {
        $detalle = DetalleCompra::findOrFail($id);
        $ordenes = OrdenCompra::where('estado', 1)->get();
        $productos = Producto::where('estado', 1)->get();

        return view('detallecompras.edit', compact('detalle', 'ordenes', 'productos'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(DetallecompraRequest $request, $id)
    {
        try {
            $detalle = DetalleCompra::findOrFail($id);
            $data = $request->validated();

            $producto = Producto::findOrFail($data['producto_id']);
            $producto->stockmaximo -= $detalle->cantidad;
            $producto->stockmaximo += $data['cantidad'];
            $producto->save();

            $detalle->update([
                'ordencompra_id' => $data['ordencompra_id'],
                'producto_id' => $data['producto_id'],
                'cantidad' => $data['cantidad'],
                'subtotal' => $data['subtotal'],
                'registradopor' => auth()->user()->name
            ]);

            return redirect()->route('detallecompras.index')
                ->with('success', 'Actualizado correctamente');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error al actualizar el detalle');
        }
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        try {
            $detalle = DetalleCompra::findOrFail($id);
            $producto = Producto::findOrFail($detalle->producto_id);

            $producto->stockmaximo -= $detalle->cantidad;
            $producto->save();

            $detalle->delete();

            return redirect()->route('detallecompras.index')
                ->with('success', 'Eliminado correctamente');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect()->route('detallecompras.index')
                ->withErrors('El registro tiene información relacionada');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('detallecompras.index')
                ->withErrors('Ocurrió un error inesperado');
        }
    }
}
