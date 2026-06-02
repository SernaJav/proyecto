<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetodopagoRequest;
use App\Models\MetodoPago;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
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
    public function store(MetodopagoRequest $request)
    {
        try {
            $data = $request->validated();
            $data['estado'] = 1;
            $data['registradopor'] = auth()->user()->name;

            MetodoPago::create($data);

            return redirect()
                ->route('metodopagos.index')
                ->with('success', 'Método de pago creado exitosamente.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error inesperado al crear el método de pago');
        }
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
    public function update(MetodopagoRequest $request, $id)
    {
        try {
            $metodoPago = MetodoPago::findOrFail($id);
            $metodoPago->update($request->validated());

            return redirect()
                ->route('metodopagos.index')
                ->with('success', 'Actualizado correctamente.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error inesperado al actualizar el método de pago');
        }
    }

    // =========================
    // Eliminar
    // =========================
    public function destroy($id)
    {
        $metodoPago = MetodoPago::findOrFail($id);

        try {
            if ($metodoPago->pagos()->count() > 0) {
                return redirect()
                    ->route('metodopagos.index')
                    ->withErrors('El registro tiene información relacionada');
            }

            $metodoPago->delete();

            return redirect()
                ->route('metodopagos.index')
                ->with('success', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('metodopagos.index')
                ->withErrors('El registro tiene información relacionada');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('metodopagos.index')
                ->withErrors('Ocurrió un error inesperado');
        }
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

    // =========================
    // EXPORTAR A EXCEL (CSV)
    // =========================
    public function exportExcel()
    {
        $metodos = MetodoPago::all();
        $filename = "metodopagos_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Nombre', 'Estado', 'Registrado Por'];

        $callback = function() use($metodos, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($metodos as $metodo) {
                fputcsv($file, [
                    $metodo->id,
                    $metodo->nombre,
                    $metodo->estado == 1 ? 'Activo' : 'Inactivo',
                    $metodo->registradopor
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =========================
    // EXPORTAR A PDF (PRINT VIEW)
    // =========================
    public function exportPdf($id)
    {
        $metodopago = MetodoPago::findOrFail($id);
        return view('metodopagos.pdf', compact('metodopago'));
    }
}
