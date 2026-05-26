<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * =========================
     * AUTORIZACIÓN
     * =========================
     * permite usar este request
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
        return [

            // =========================
            // nombre
            // =========================
            'nombre' => 'required|string|max:100|unique:productos,nombre',

            // =========================
            // precio
            // =========================
            'preciocompra' => 'required|numeric|min:0',

            // =========================
            // stock
            // =========================
            'stockmaximo' => 'required|integer|min:0',

            // =========================
            // descripción
            // =========================
            'descripcion' => 'nullable|string|max:255',

            // =========================
            // imagen
            // =========================
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
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
                'El nombre es obligatorio.',

            'preciocompra.required' =>
                'El precio es obligatorio.',

            'preciocompra.numeric' =>
                'El precio debe ser numérico.',

            'stockmaximo.required' =>
                'El stock es obligatorio.',

            'stockmaximo.integer' =>
                'El stock debe ser entero.',

            'imagen.image' =>
                'El archivo debe ser imagen.',

            'imagen.mimes' =>
                'La imagen debe ser jpg, jpeg, png o webp.',

            'imagen.max' =>
                'La imagen no puede superar 2MB.'
        ];
    }
}