<?php
 
namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
 
class ProveedorRequest extends FormRequest
 {
     /**
      * Habilitar el uso del request.
      */
     public function authorize(): bool
     {
         return true;
     }
 
     /**
      * Reglas de validación.
      */
     public function rules(): array
     {
         $id = $this->route('proveedores') ?? $this->route('proveedor');
 
         return [
             'nombre' => 'required|string|max:100',
             'documento' => 'required|string|max:50|unique:proveedores,documento,' . ($id ? $id : 'NULL'),
             'direccion' => 'nullable|string|max:255',
             'telefono' => 'nullable|string|max:50',
             'email' => 'required|email|max:100|unique:proveedores,email,' . ($id ? $id : 'NULL'),
         ];
     }
 
     /**
      * Mensajes de error personalizados en español.
      */
     public function messages(): array
     {
         return [
             'nombre.required' => 'El nombre del proveedor es obligatorio.',
             'nombre.string' => 'El nombre debe ser una cadena de texto.',
             'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
             'documento.required' => 'El documento de identidad es obligatorio.',
             'documento.unique' => 'Este documento ya se encuentra registrado.',
             'documento.max' => 'El documento no puede superar los 50 caracteres.',
             'email.required' => 'El correo electrónico es obligatorio.',
             'email.email' => 'Ingrese un correo electrónico válido.',
             'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
             'email.max' => 'El correo electrónico no puede superar los 100 caracteres.',
             'direccion.max' => 'La dirección no puede superar los 255 caracteres.',
             'telefono.max' => 'El teléfono no puede superar los 50 caracteres.',
         ];
     }
 }
