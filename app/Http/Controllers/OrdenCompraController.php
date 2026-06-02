<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdencompraRequest;
use App\Models\OrdenCompra;
use App\Models\Proveedor;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Models\DetalleCompra;
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

        // =========================
        // traer productos activos
        // =========================
        $productos = Producto::where(
            'estado',
            1
        )->get();

        return view(
            'ordencompras.create',
            compact(
                'proveedores',
                'metodospago',
                'productos'
            )
        );
    }

    // =========================
    // GUARDAR
    // =========================
    public function store(OrdencompraRequest $request)
    {
        try {
            \DB::beginTransaction();

            // =========================
            // crear orden
            // =========================
            $data = $request->validated();
            $data['fecha'] = $data['fecha'] ?? now()->format('Y-m-d');
            $data['estado'] = 1;
            $data['registradopor'] = auth()->user()->name;

            // Lógica de saldo pendiente según el tipo de pago
            if ($data['tipopago'] == 'contado') {
                $data['saldopendiente'] = 0;
            } else {
                $data['saldopendiente'] = $data['total'];
            }

            $orden = OrdenCompra::create($data);

            // =========================
            // crear detalle de compra
            // =========================
            DetalleCompra::create([
                'ordencompra_id' => $orden->id,
                'producto_id' => $data['producto_id'],
                'cantidad' => $data['cantidad'],
                'subtotal' => $data['subtotal'],
                'registradopor' => auth()->user()->name
            ]);

            // =========================
            // actualizar stock de producto
            // =========================
            if ($data['tipopago'] == 'contado') {
                $producto = Producto::findOrFail($data['producto_id']);
                $producto->stock -= $data['cantidad'];
                $producto->save();
            }

            \DB::commit();

            return redirect()
                ->route('ordencompras.index')
                ->with(
                   'success',
                   'Orden creada correctamente'
                );

        } catch (Exception $e) {
            \DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error inesperado al crear la orden: ' . $e->getMessage());
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

        $productos = Producto::where(
            'estado',
            1
        )->get();

        $detalle = $ordencompra->detallesCompras()->first();

        return view(
            'ordencompras.edit',
            compact(
                'ordencompra',
                'proveedores',
                'metodospago',
                'productos',
                'detalle'
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
            \DB::beginTransaction();

            $ordencompra = OrdenCompra::findOrFail($id);
            $data = $request->validated();

            // Lógica de saldo pendiente según el tipo de pago
            if ($data['tipopago'] == 'contado') {
                $data['saldopendiente'] = 0;
            } else {
                $data['saldopendiente'] = $data['total'];
            }

            // ==========================================
            // REVERTIR stock anterior si era contado
            // ==========================================
            $prevDetalle = $ordencompra->detallesCompras()->first();
            if ($prevDetalle) {
                if ($ordencompra->tipopago == 'contado') {
                    $prevProd = Producto::find($prevDetalle->producto_id);
                    if ($prevProd) {
                        $prevProd->stock += $prevDetalle->cantidad;
                        $prevProd->save();
                    }
                }
            }

            // Actualizar la orden
            $ordencompra->update($data);

            // ==========================================
            // ACTUALIZAR o crear detalle
            // ==========================================
            if ($prevDetalle) {
                $prevDetalle->update([
                    'producto_id' => $data['producto_id'],
                    'cantidad' => $data['cantidad'],
                    'subtotal' => $data['subtotal'],
                    'registradopor' => auth()->user()->name
                ]);
            } else {
                DetalleCompra::create([
                    'ordencompra_id' => $ordencompra->id,
                    'producto_id' => $data['producto_id'],
                    'cantidad' => $data['cantidad'],
                    'subtotal' => $data['subtotal'],
                    'registradopor' => auth()->user()->name
                ]);
            }

            // ==========================================
            // APLICAR nuevo stock si es de contado
            // ==========================================
            if ($data['tipopago'] == 'contado') {
                $newProd = Producto::findOrFail($data['producto_id']);
                $newProd->stock -= $data['cantidad'];
                $newProd->save();
            }

            \DB::commit();

            return redirect()
                ->route('ordencompras.index')
                ->with(
                    'success',
                    'Orden actualizada correctamente'
                );

        } catch (Exception $e) {
            \DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors('Ocurrió un error inesperado al actualizar la orden: ' . $e->getMessage());
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

    // =========================
    // EXPORTAR A EXCEL (CSV)
    // =========================
    public function exportExcel()
    {
        $ordencompras = OrdenCompra::with('proveedor')->get();
        $filename = "ordenes_compra_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Proveedor', 'Fecha', 'Total', 'Tipo Pago', 'Saldo Pendiente', 'Estado', 'Registrado Por'];

        $callback = function() use($ordencompras, $columns) {
            $file = fopen('php://output', 'w');
            // Agregar BOM UTF-8 para que Excel detecte correctamente la codificación y los acentos
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($ordencompras as $orden) {
                fputcsv($file, [
                    $orden->id,
                    $orden->proveedor->nombre ?? 'Sin proveedor',
                    $orden->fecha ? $orden->fecha->format('d/m/Y') : 'N/A',
                    $orden->total,
                    $orden->tipopago,
                    $orden->saldopendiente,
                    $orden->estado == 1 ? 'Activo' : 'Inactivo',
                    $orden->registradopor
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
        $ordencompra = OrdenCompra::with(['proveedor', 'detallesCompras.producto'])->findOrFail($id);
        return view('ordencompras.pdf', compact('ordencompra'));
    }
}