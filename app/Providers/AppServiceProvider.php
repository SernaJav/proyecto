<?php

namespace App\Providers;

// =========================
// Importamos Paginator
// para usar Bootstrap
// en la paginación Laravel
// =========================
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator; // 👈 AÑADIDO: Para forzar HTTPS

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios
     */
    public function register(): void
    {
        //
    }

    /**
     * Configuración al iniciar Laravel
     */
    public function boot(UrlGenerator $url): void // 👈 AÑADIDO: $url como parámetro
    {
        // =========================
        // Hace que la paginación
        // use estilos Bootstrap
        // y no Tailwind
        // =========================
        Paginator::useBootstrap();

        // =========================
        // FORZAR HTTPS EN PRODUCCIÓN
        // Importante para Render.com
        // =========================
        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }
    }
}