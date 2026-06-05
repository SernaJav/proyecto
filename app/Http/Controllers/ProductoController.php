<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // =========================
    // LISTAR PRODUCTOS
    // =========================
    public function index()
    {
        // =========================
        // traer todos los productos
        // ordenados por ID ascendente, sin importar su estado
        // =========================
        $productos = Producto::orderBy('id', 'asc')->get();

        // =========================
        // enviar vista
        // =========================
        return view(
                    // =========================
                    // intentar guardar en storage público; si falla, usar data-URL
                    // =========================
            'productos.index',
            compact('productos')
        );
    }

    // =========================
    // FORMULARIO CREAR
    // =========================
    public function create()
    {
        return view('productos.create');
    }

    // =========================
    // GUARDAR PRODUCTO
    // =========================
    public function store(ProductoRequest $request)
    {
        try {
            $rutaImagen = null;

            // =========================
            // manejar imagen si fue subida
            // =========================
            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');

                // nombre único
                $nombre = time() . '.' . $file->getClientOriginalExtension();

                try {
                    if (! Storage::disk('public')->exists('productos')) {
                        Storage::disk('public')->makeDirectory('productos');
                    }

                    Storage::disk('public')->putFileAs('productos', $file, $nombre);
                    $rutaImagen = 'storage/productos/' . $nombre;
                } catch (\Exception $e) {
                    $contents = file_get_contents($file->getPathname());
                    $base64 = base64_encode($contents);
                    $mime = $file->getClientMimeType();
                    $rutaImagen = "data:{$mime};base64,{$base64}";
                }
            }

            // =========================
            // crear producto
            // =========================
            Producto::create([

                'nombre' => $request->nombre,

                'preciocompra' => $request->preciocompra,

                'descripcion' => $request->descripcion,

                'stockmaximo' => $request->stockmaximo,

                // =========================
                // stock inicial
                // =========================
                'stock' => $request->stock,

                'imagen' => $rutaImagen,

                'estado' => 1,

                'registradopor' => auth()->user()->name
            ]);

            // =========================
            // volver al index
            // =========================
            return redirect()
                ->route('productos.index')
                ->with(
                    'success',
                    'Producto creado correctamente'
                );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    // =========================
    // MOSTRAR PRODUCTO
    // =========================
    public function show($id)
    {
        // =========================
        // buscar producto
        // =========================
        $producto = Producto::findOrFail($id);

        // =========================
        // enviar vista
        // =========================
        return view(
            'productos.show',
            compact('producto')
        );
    }

    // =========================
    // FORMULARIO EDITAR
    // =========================
    public function edit($id)
    {
        // =========================
        // buscar producto
        // =========================
        $producto = Producto::findOrFail($id);

        // =========================
        // enviar vista
        // =========================
        return view(
            'productos.edit',
            compact('producto')
        );
    }

    // =========================
    // ACTUALIZAR PRODUCTO
    // =========================
    public function update(
        ProductoRequest $request,
        $id
    )
    {
        try {

            // =========================
            // buscar producto
            // =========================
            $producto = Producto::findOrFail($id);

            // =========================
            // mantener imagen actual
            // =========================
            $rutaImagen = $producto->imagen;

            // =========================
            // nueva imagen
            // =========================
            if ($request->hasFile('imagen')) {

                $file = $request->file('imagen');

                $nombre = time() . '.' .
                    $file->getClientOriginalExtension();

                try {
                    if (! Storage::disk('public')->exists('productos')) {
                        Storage::disk('public')->makeDirectory('productos');
                    }

                    Storage::disk('public')->putFileAs('productos', $file, $nombre);
                    $rutaImagen = 'storage/productos/' . $nombre;
                } catch (\Exception $e) {
                    $contents = file_get_contents($file->getPathname());
                    $base64 = base64_encode($contents);
                    $mime = $file->getClientMimeType();
                    $rutaImagen = "data:{$mime};base64,{$base64}";
                }
            }

            // =========================
            // actualizar producto
            // =========================
            $producto->update([

                'nombre' => $request->nombre,

                'preciocompra' => $request->preciocompra,

                'descripcion' => $request->descripcion,

                'stockmaximo' => $request->stockmaximo,

                'stock' => $request->stock,

                'imagen' => $rutaImagen
            ]);

            return redirect()
                ->route('productos.index')
                ->with(
                    'success',
                    'Producto actualizado correctamente'
                );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    // =========================
    // ELIMINAR PRODUCTO
    // =========================
    public function destroy($id)
    {
        try {

            // =========================
            // buscar producto
            // =========================
            $producto = Producto::findOrFail($id);

            // =========================
            // eliminar detalles asociados
            // =========================
            $producto->detallesCompras()->delete();

            // =========================
            // eliminar producto
            // =========================
            $producto->delete();

            return redirect()
                ->route('productos.index')
                ->with(
                    'success',
                    'Producto eliminado correctamente'
                );

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect()
                ->route('productos.index')
                ->withErrors('El registro tiene información relacionada');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with(
                'error',
                'Ocurrió un error inesperado'
            );
        }
    }

    // =========================
    // CAMBIAR ESTADO
    // =========================
    public function cambioestado(Request $request)
    {
        // =========================
        // buscar producto
        // =========================
        $producto = Producto::find($request->id);

        // =========================
        // validar existencia
        // =========================
        if (!$producto) {

            return response()->json([

                'success' => false,

                'message' => 'Producto no encontrado'
            ]);
        }

        // =========================
        // cambiar estado
        // =========================
        $producto->estado = $request->estado;
        
        $producto->save();

        // =========================
        // responder
        // =========================
        return response()->json([

            'success' => true,

            'message' => 'Estado actualizado'
        ]);
    }

    // =========================
    // EXPORTAR A EXCEL (CSV)
    // =========================
    public function exportExcel()
    {
        $productos = Producto::all();
        $filename = "productos_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Nombre', 'Código', 'Stock', 'Precio Compra', 'Precio Venta', 'Estado', 'Registrado Por'];

        $callback = function() use($productos, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($productos as $producto) {
                fputcsv($file, [
                    $producto->id,
                    $producto->nombre,
                    $producto->codigo,
                    $producto->stock,
                    $producto->preciocompra,
                    $producto->precioventa,
                    $producto->estado == 1 ? 'Activo' : 'Inactivo',
                    $producto->registradopor
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
        $producto = Producto::findOrFail($id);
        return view('productos.pdf', compact('producto'));
    }
}