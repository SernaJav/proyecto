<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetodopagoRequest extends FormRequest
{
    /**
     * =========================
     * AUTORIZACIÓN
     * =========================
     * Permite usar este request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * =========================
     * REGLAS
     * =========================
     */
    public function rules(): array
    {
        $id = $this->route('metodopagos') ?? $this->route('metodopago');

        return [
            // =========================
            // nombre
            // =========================
            'nombre' => 'required|string|max:100|unique:metodopagos,nombre,' . ($id ? $id : 'NULL'),

            // =========================
            // descripción
            // =========================
            'descripcion' => 'nullable|string|max:255',

            // =========================
            // estado
            // =========================
            'estado' => 'required|in:1,0',

            // =========================
            // registrado por (opcional, se puede asignar automáticamente)
            // =========================
            'registradopor' => 'nullable|integer|exists:users,id'
        ];
    }

    /**
     * =========================
     * MENSAJES
     * =========================
     */
    public function messages(): array
    {
        return [
            'nombre.required' =>
                'El nombre del método de pago es obligatorio.',

            'nombre.string' =>
                'El nombre debe ser una cadena de texto.',

            'nombre.max' =>
                'El nombre no puede superar los 100 caracteres.',

            'nombre.unique' =>
                'Este nombre de método de pago ya existe.',

            'descripcion.string' =>
                'La descripción debe ser una cadena de texto.',

            'descripcion.max' =>
                'La descripción no puede superar los 255 caracteres.',

            'estado.required' =>
                'El estado es obligatorio.',

            'estado.in' =>
                'El estado debe ser 1 o 0.',

            'registradopor.integer' =>
                'El campo registrado por debe ser un número entero.',

            'registradopor.exists' =>
                'El usuario registrado no existe en la base de datos.'
        ];
    }
}