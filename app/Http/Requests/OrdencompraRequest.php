<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdencompraRequest extends FormRequest
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
        $id = $this->route('ordencompras') ?? $this->route('ordencompra');

        return [
            // =========================
            // fecha
            // =========================
            'fecha' => 'required|date|date_format:Y-m-d',

            // =========================
            // proveedor (relación)
            // =========================
            'proveedor_id' => 'required|integer|exists:proveedores,id',

            // =========================
            // producto (relación)
            // =========================
            'producto_id' => 'required|integer|exists:productos,id',

            // =========================
            // cantidad
            // =========================
            'cantidad' => 'required|integer|min:1',

            // =========================
            // precio
            // =========================
            'precio' => 'required|numeric|min:0',

            // =========================
            // subtotal
            // =========================
            'subtotal' => 'required|numeric|min:0',

            // =========================
            // total
            // =========================
            'total' => 'required|numeric|min:0',

            // =========================
            // tipo de pago
            // =========================
            'tipopago' => 'required|in:contado,credito',

            // =========================
            // saldo pendiente
            // =========================
            'saldopendiente' => 'nullable|numeric|min:0',

            // =========================
            // estado
            // =========================
            'estado' => 'nullable|in:1,0',

            // =========================
            // registrado por (opcional, se puede asignar automáticamente)
            // =========================
            'registradopor' => 'nullable|string'
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
            'fecha.required' =>
                'La fecha es obligatoria.',

            'fecha.date' =>
                'La fecha debe ser una fecha válida.',

            'fecha.date_format' =>
                'La fecha debe tener el formato YYYY-MM-DD.',

            'proveedor_id.required' =>
                'El proveedor es obligatorio.',

            'proveedor_id.integer' =>
                'El ID del proveedor debe ser un número entero.',

            'proveedor_id.exists' =>
                'El proveedor especificado no existe.',

            'total.required' =>
                'El total es obligatorio.',

            'total.numeric' =>
                'El total debe ser un valor numérico.',

            'total.min' =>
                'El total no puede ser negativo.',

            'tipopago.required' =>
                'El tipo de pago es obligatorio.',

            'tipopago.in' =>
                'El tipo de pago debe ser "contado" o "credito".',

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
                'La cantidad debe ser al menos 1.',

            'precio.required' =>
                'El precio es obligatorio.',

            'precio.numeric' =>
                'El precio debe ser un número decimal.',

            'precio.min' =>
                'El precio no puede ser negativo.',

            'subtotal.required' =>
                'El subtotal es obligatorio.',

            'subtotal.numeric' =>
                'El subtotal debe ser un número decimal.',

            'subtotal.min' =>
                'El subtotal no puede ser negativo.',

            'saldopendiente.numeric' =>
                'El saldo pendiente debe ser un valor numérico.',

            'saldopendiente.min' =>
                'El saldo pendiente no puede ser negativo.',

            'estado.in' =>
                'El estado debe ser 1 o 0.'
        ];
    }
}