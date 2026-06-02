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

    // =========================
    // EXPORTAR A EXCEL (CSV)
    // =========================
    public function exportExcel()
    {
        $pagos = Pago::with(['ordenCompra', 'metodoPago'])->get();
        $filename = "pagos_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Orden de Compra ID', 'Fecha de Pago', 'Monto', 'Método de Pago', 'Registrado Por'];

        $callback = function() use($pagos, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($pagos as $pago) {
                fputcsv($file, [
                    $pago->id,
                    $pago->ordencompra_id,
                    $pago->fechapago ? $pago->fechapago->format('d/m/Y H:i') : 'N/A',
                    $pago->monto,
                    $pago->metodoPago->nombre ?? 'N/A',
                    $pago->registradopor
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
        $pago = Pago::with(['ordenCompra', 'metodoPago'])->findOrFail($id);
        return view('pagos.pdf', compact('pago'));
    }
}