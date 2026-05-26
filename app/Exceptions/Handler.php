<?php

namespace App\Exceptions;

use Throwable;

// =========================
// excepciones laravel
// =========================
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    // =========================
    // renderizar errores
    // =========================
    public function render($request, Throwable $e)
    {
        // =========================
        // ERROR 404
        // página no encontrada
        // =========================
        if ($e instanceof NotFoundHttpException) {

            return response()->view(
                'errors.404',
                [],
                404
            );
        }

        // =========================
        // ERROR 403
        // acceso denegado
        // =========================
        if ($e instanceof HttpException && $e->getStatusCode() == 403) {

            return response()->view(
                'errors.403',
                [],
                403
            );
        }

        // =========================
        // ERROR 419
        // sesión/token expirado
        // =========================
        if ($e instanceof AuthenticationException) {

            return response()->view(
                'errors.419',
                [],
                419
            );
        }

        // =========================
        // ERROR BASE DE DATOS
        // =========================
        if ($e instanceof QueryException) {

            return response()->view(
                'errors.500',
                [
                    'mensaje' => 'Error en base de datos'
                ],
                500
            );
        }

        // =========================
        // cualquier otro error
        // =========================
        return parent::render($request, $e);
    }
}