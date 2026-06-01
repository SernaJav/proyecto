<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
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

                    try {
                        $file->move($directorio, $nombre);
                        $rutaImagen = 'storage/productos/' . $nombre;
                    } catch (\Exception $e) {
                        // fallback: guardar como data-URL en BD
                        $contents = file_get_contents($file->getPathname());
                        $base64 = base64_encode($contents);
                        $mime = $file->getClientMimeType();
                        $rutaImagen = "data:{$mime};base64,{$base64}";
                    }

                // =========================
                // obtener archivo
                // =========================
                $file = $request->file('imagen');

                // =========================
                // crear nombre único
                // =========================
                $nombre = time() . '.' .
                    $file->getClientOriginalExtension();

                // =========================
                // crear directorio si no existe
                // =========================
                $directorio = storage_path('app/public/productos');

                if (! File::exists($directorio)) {
                    File::makeDirectory($directorio, 0755, true);
                }

                // =========================
                // mover imagen
                // =========================
                $file->move(
                    $directorio,
                    $nombre
                );

                // =========================
                // guardar ruta pública (servible vía storage symlink)
                // =========================
                $rutaImagen =
                    'storage/productos/' . $nombre;
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
                'stock' => 0,

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

                $directorio = storage_path('app/public/productos');

                if (! File::exists($directorio)) {
                    File::makeDirectory($directorio, 0755, true);
                }

                $file->move(
                    $directorio,
                    $nombre
                );

                $rutaImagen =
                    'storage/productos/' . $nombre;
            }

            // =========================
            // actualizar producto
            // =========================
            $producto->update([

                'nombre' => $request->nombre,

                'preciocompra' => $request->preciocompra,

                'descripcion' => $request->descripcion,

                'stockmaximo' => $request->stockmaximo,

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
}