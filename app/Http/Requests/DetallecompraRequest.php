<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetallecompraRequest extends FormRequest
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
        $id = $this->route('detallecompras') ?? $this->route('detallecompra');

        return [
            // =========================
            // orden de compra (relación)
            // =========================
            'ordencompra_id' => 'required|integer|exists:ordencompras,id',

            // =========================
            // producto (relación)
            // =========================
            'producto_id' => 'required|integer|exists:productos,id',

            // =========================
            // cantidad
            // =========================
            'cantidad' => 'required|integer|min:1',

            // =========================
            // subtotal
            // =========================
            'subtotal' => 'required|numeric|min:0',

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
            'ordencompra_id.required' =>
                'La orden de compra es obligatoria.',

            'ordencompra_id.integer' =>
                'El ID de la orden de compra debe ser un número entero.',

            'ordencompra_id.exists' =>
                'La orden de compra especificada no existe.',

            'producto_id.required' =>
                'El producto es obligatorio.',

            'producto_id.integer' =>
                'El ID del producto debe ser un número entero.',

            'producto_id.exists' =>
                'El producto especificado no existe.',

            'cantidad.required' =>
                'La cantidad es obligatoria.',

            'cantidad.integer' =>
                'La cantidad debe ser un número entero.',

            'cantidad.min' =>
                'La cantidad mínima es 1.',

            'subtotal.required' =>
                'El subtotal es obligatorio.',

            'subtotal.numeric' =>
                'El subtotal debe ser un valor numérico.',

            'subtotal.min' =>
                'El subtotal no puede ser negativo.',

            'registradopor.integer' =>
                'El campo registrado por debe ser un número entero.',

            'registradopor.exists' =>
                'El usuario registrado no existe en la base de datos.'
        ];
    }
}