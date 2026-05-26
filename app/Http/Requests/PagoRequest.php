<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
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
        $id = $this->route('pagos') ?? $this->route('pago');

        return [
            // =========================
            // orden de compra (relación)
            // =========================
            'ordencompra_id' => 'required|integer|exists:ordencompras,id',

            // =========================
            // fecha de pago
            // =========================
            'fechapago' => 'required|date|date_format:Y-m-d',

            // =========================
            // monto
            // =========================
            'monto' => 'required|numeric|min:0.01',

            // =========================
            // método de pago (relación)
            // =========================
            'metodopago_id' => 'required|integer|exists:metodopagos,id',

            // =========================
            // estado
            // =========================
            'estado' => 'required|in:pendiente,aprobado,rechazado,anulado',

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

            'fechapago.required' =>
                'La fecha de pago es obligatoria.',

            'fechapago.date' =>
                'La fecha de pago debe ser una fecha válida.',

            'fechapago.date_format' =>
                'La fecha debe tener el formato YYYY-MM-DD.',

            'monto.required' =>
                'El monto es obligatorio.',

            'monto.numeric' =>
                'El monto debe ser un valor numérico.',

            'monto.min' =>
                'El monto debe ser mayor a 0.',

            'metodopago_id.required' =>
                'El método de pago es obligatorio.',

            'metodopago_id.integer' =>
                'El ID del método de pago debe ser un número entero.',

            'metodopago_id.exists' =>
                'El método de pago especificado no existe.',

            'estado.required' =>
                'El estado es obligatorio.',

            'estado.in' =>
                'El estado debe ser: pendiente, aprobado, rechazado o anulado.',

            'registradopor.integer' =>
                'El campo registrado por debe ser un número entero.',

            'registradopor.exists' =>
                'El usuario registrado no existe en la base de datos.'
        ];
    }
}