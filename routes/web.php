<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OrdencompraController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PagoController;

// =========================
// RUTA PRINCIPAL
// =========================
Route::get('/', function () {
    return view('welcome');
});

// =========================
// RUTA TEMPORAL PARA MIGRACIONES (NO requiere autenticación)
// =========================
Route::get('/migrar', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return '✅ Migraciones ejecutadas correctamente!<br><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

// =========================
// RUTA PARA VER RUTAS DISPONIBLES (temporal)
// =========================
Route::get('/rutas', function() {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $output = '<h1>Rutas disponibles en tu aplicación:</h1><ul>';
    foreach($routes as $route) {
        if ($route->getName()) {
            $output .= '<li><strong>' . $route->uri() . '</strong> → ' . $route->getName() . '</li>';
        } else {
            $output .= '<li>' . $route->uri() . '</li>';
        }
    }
    $output .= '</ul>';
    return $output;
});

// =========================
// RUTAS DE PRUEBA (ERRORES)
// =========================
Route::get('/test-404', function () {
    throw new App\Exceptions\NotFoundHttpException('Recurso no encontrado');
});

Route::get('/test-403', function () {
    throw new App\Exceptions\ForbiddenException('Acceso denegado');
});

Route::get('/test-419', function () {
    throw new App\Exceptions\TokenMismatchException('Token expirado');
});

Route::get('/test-500', function () {
    throw new App\Exceptions\InternalServerErrorException('Error interno');
});

// =========================
// LOGIN
// =========================
Auth::routes();

// =========================
// RUTAS PROTEGIDAS (requieren autenticación)
// =========================
Route::middleware(['auth'])->group(function () {

    // =========================
    // HOME
    // =========================
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // =========================
    // PROVEEDORES
    // =========================
    Route::resource('proveedores', ProveedorController::class);

    Route::get('cambioestadoproveedor', [
        ProveedorController::class,
        'cambioestado'
    ])->name('cambioestadoproveedor');

    // =========================
    // PRODUCTOS
    // =========================
    Route::resource('productos', ProductoController::class);

    Route::get('cambioestadoproducto', [
        ProductoController::class,
        'cambioestado'
    ])->name('cambioestadoproducto');

    // =========================
    // ORDENES DE COMPRA
    // =========================
    Route::resource('ordencompras', OrdencompraController::class);

    Route::get('cambioestadoordencompra', [
        OrdencompraController::class,
        'cambioestado'
    ])->name('cambioestadoordencompra');

    // =========================
    // DETALLE COMPRAS
    // =========================
    Route::resource('detallecompras', DetalleCompraController::class);

    // =========================
    // METODOS DE PAGO
    // =========================
    Route::resource('metodopagos', MetodoPagoController::class);

    Route::get('cambioestadometodopago', [
        MetodoPagoController::class,
        'cambioestado'
    ])->name('cambioestadometodopago');

    // =========================
    // PAGOS
    // =========================
    Route::resource('pagos', PagoController::class);

    Route::get('cambioestadopago', [
        PagoController::class,
        'cambioestado'
    ])->name('cambioestadopago');
    
});