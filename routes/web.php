<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| WEB PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| TEST RENDER
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return '✅ Laravel funcionando en Render';
});

Route::get('storage-file/{path}', function ($path) {
    if (! Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('storage.file');

/*
|--------------------------------------------------------------------------
| MIGRACIONES
|--------------------------------------------------------------------------
*/

Route::get('/migrar', function () {

    try {

        Artisan::call('migrate', [
            '--force' => true
        ]);

        return nl2br(Artisan::output());

    } catch (\Exception $e) {

        return $e->getMessage();

    }

});


Route::get('/seed', function () {

    try {

        Artisan::call('db:seed', [
            '--force' => true
        ]);

        return nl2br(Artisan::output());

    } catch (\Exception $e) {

        return $e->getMessage();

    }

});


/*
|--------------------------------------------------------------------------
| CACHE CLEAR
|--------------------------------------------------------------------------
*/

Route::get('/clear', function () {

    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return '✅ Cache limpiada';

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | PROVEEDORES
    |--------------------------------------------------------------------------
    */

    Route::resource('proveedores', ProveedorController::class);

    Route::get(
        'cambioestadoproveedor',
        [ProveedorController::class, 'cambioestado']
    )->name('cambioestadoproveedor');

    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS
    |--------------------------------------------------------------------------
    */

    Route::resource('productos', ProductoController::class);

    Route::get(
        'cambioestadoproducto',
        [ProductoController::class, 'cambioestado']
    )->name('cambioestadoproducto');

    /*
    |--------------------------------------------------------------------------
    | ORDENES DE COMPRA
    |--------------------------------------------------------------------------
    */

    Route::resource('ordencompras', OrdenCompraController::class);

    Route::get(
        'cambioestadoordencompra',
        [OrdenCompraController::class, 'cambioestado']
    )->name('cambioestadoordencompra');

    /*
    |--------------------------------------------------------------------------
    | METODOS DE PAGO
    |--------------------------------------------------------------------------
    */

    Route::resource('metodopagos', MetodoPagoController::class);

    Route::get(
        'cambioestadometodopago',
        [MetodoPagoController::class, 'cambioestado']
    )->name('cambioestadometodopago');

    /*
    |--------------------------------------------------------------------------
    | PAGOS
    |--------------------------------------------------------------------------
    */

    Route::resource('pagos', PagoController::class);

    Route::get(
        'cambioestadopago',
        [PagoController::class, 'cambioestado']
    )->name('cambioestadopago');

    // PROFILE
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

});