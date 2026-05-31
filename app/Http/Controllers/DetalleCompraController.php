<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompra;
use App\Models\Ordencompra;
use App\Models\Producto;

use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    // =========================
    // LISTAR
    // =========================
    public function index()
    {
        // 🔥 cargamos orden y producto para poder mostrar datos relacionados
        $detalles = Detallecompra::with(['ordenCompra', 'producto'])
            ->paginate(10);

        return view('detallecompras.index', compact('detalles'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $ordenes = Ordencompra::where('estado', 1)->get();
        $productos = Producto::where('estado', 1)->get();

        return view('detallecompras.create', compact('ordenes', 'productos'));
    }

    // =========================
    // MOSTRAR
    // =========================
    public function show($id)
    {
        $detalle = Detallecompra::with(['ordenCompra', 'producto'])
            ->findOrFail($id);

        return view('detallecompras.show', compact('detalle'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'ordencompra_id' => 'required|exists:ordencompras,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        // 💡 aumenta stock
        $producto->stockmaximo += $request->cantidad;
        $producto->save();

        // 💡 crear detalle
        $detalle = Detallecompra::create([
            'ordencompra_id' => $request->ordencompra_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'subtotal' => $request->subtotal,
            'registradopor' => auth()->user()->name
        ]);

        // 💡 actualizar orden
        $orden = Ordencompra::findOrFail($request->ordencompra_id);
        $orden->total += $request->subtotal;
        $orden->saldopendiente = $orden->total;
        $orden->save();



        return redirect()->route('detallecompras.index')
            ->with('success', 'Compra registrada correctamente');
    }

    // =========================
    // EDITAR
    // =========================
    public function edit($id)
    {
        $detalle = Detallecompra::findOrFail($id);
        $ordenes = Ordencompra::where('estado', 1)->get();
        $productos = Producto::where('estado', 1)->get();

        return view('detallecompras.edit', compact('detalle', 'ordenes', 'productos'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $detalle = Detallecompra::findOrFail($id);

        $request->validate([
            'ordencompra_id' => 'required|exists:ordencompras,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        // revertir stock anterior
        $producto->stockmaximo -= $detalle->cantidad;

        // aplicar nuevo stock
        $producto->stockmaximo += $request->cantidad;

        $producto->save();

        $detalle->update([
            'ordencompra_id' => $request->ordencompra_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'subtotal' => $request->subtotal,
            'registradopor' => auth()->user()->name
        ]);



        return redirect()->route('detallecompras.index')
            ->with('success', 'Actualizado correctamente');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $detalle = Detallecompra::findOrFail($id);

        $producto = Producto::findOrFail($detalle->producto_id);

        $producto->stockmaximo -= $detalle->cantidad;
        $producto->save();



        $detalle->delete();

        return redirect()->route('detallecompras.index')
            ->with('success', 'Eliminado correctamente');
    }
}
