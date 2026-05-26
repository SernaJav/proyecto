<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    // =========================
    // Listar métodos de pago
    // =========================
    public function index()
    {
        $metodopagos = MetodoPago::paginate(10);
        return view('metodopagos.index', compact('metodopagos'));
    }

    // =========================
    // Crear
    // =========================
    public function create()
    {
        return view('metodopagos.create');
    }

    // =========================
    // Mostrar
    // =========================
    public function show($id)
    {
        $metodoPago = MetodoPago::findOrFail($id);

        return view('metodopagos.show', compact('metodoPago'));
    }

    // =========================
    // Guardar
    // =========================
   public function store(Request $request)
{
    // =========================
    // Validación básica
    // =========================
    $request->validate([
        'nombre' => 'required'
    ]);

    // =========================
    // Guardado manual (NO usar all())
    // =========================
    MetodoPago::create([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'estado' => 1,
        'registradopor' => auth()->user()->name
    ]);

    return redirect()
        ->route('metodopagos.index')
        ->with('success', 'Método de pago creado exitosamente.');
}

    // =========================
    // Editar
    // =========================
    public function edit($id)
    {
        $metodoPago = MetodoPago::findOrFail($id);

        return view('metodopagos.edit', compact('metodoPago'));
    }

    // =========================
    // Actualizar
    // =========================
    public function update(Request $request, $id)
    {
        $metodoPago = MetodoPago::findOrFail($id);
        $metodoPago->update($request->all());

        return redirect()
            ->route('metodopagos.index')
            ->with('success', 'Actualizado correctamente.');
    }

    // =========================
    // Eliminar
    // =========================
    public function destroy($id)
    {
        $metodoPago = MetodoPago::findOrFail($id);

        if ($metodoPago->pagos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tiene pagos asociados.');
        }

        $metodoPago->delete();

        return redirect()
            ->route('metodopagos.index')
            ->with('success', 'Eliminado correctamente.');
    }

    // =========================
    // CAMBIO DE ESTADO
    // =========================
    public function cambioestado(Request $request)
    {
        $metodo = MetodoPago::find($request->id);

        if (!$metodo) {
            return response()->json(['success' => false]);
        }

        $metodo->estado = $request->estado;
        $metodo->save();

        return response()->json(['success' => true]);
    }
}