@extends('layouts.app')

@section('title','Crear Orden de Compra')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- Encabezado --}}
    {{-- ========================= --}}
    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="page-title">

                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        Crear Orden de Compra

                    </h1>

                </div>

                <div class="col-sm-6 text-right">

                    <a
                        href="{{ route('ordencompras.index') }}"
                        class="btn btn-secondary shadow-sm"
                    >

                        <i class="fas fa-arrow-left mr-1"></i>
                        Volver

                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- ========================= --}}
    {{-- Mensajes --}}
    {{-- ========================= --}}
    @include('layouts.partial.msg')

    {{-- ========================= --}}
    {{-- Contenido --}}
    {{-- ========================= --}}
    <section class="content">

        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-lg-10">

                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- Header --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <h3 class="card-title">

                                <i class="fas fa-shopping-cart mr-2"></i>
                                Información de la Orden

                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- Formulario --}}
                        {{-- ========================= --}}
                        <form
                            method="POST"
                            action="{{ route('ordencompras.store') }}"
                        >

                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    {{-- Fecha --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Fecha y Hora <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="datetime-local"
                                                    name="fecha"
                                                    class="form-control modern-input"
                                                    value="{{ date('Y-m-d\TH:i') }}"
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Proveedor (Select2) --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Proveedor <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-truck"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="proveedor_id"
                                                    id="proveedor_id"
                                                    class="form-control modern-input select2"
                                                    required
                                                >
                                                    <option value="">Seleccione proveedor</option>
                                                    @foreach($proveedores as $proveedor)
                                                        <option value="{{ $proveedor->id }}">
                                                            {{ $proveedor->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Producto (Select2 con data-precio) --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Producto <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-box"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="producto_id"
                                                    id="producto_id"
                                                    class="form-control modern-input select2"
                                                    required
                                                >
                                                    <option value="">Seleccione producto</option>
                                                    @foreach($productos as $producto)
                                                        <option value="{{ $producto->id }}" data-precio="{{ $producto->preciocompra }}">
                                                            {{ $producto->nombre }} (Stock actual: {{ $producto->stock }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Cantidad --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Cantidad <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-sort-numeric-up-alt"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="number"
                                                    name="cantidad"
                                                    id="cantidad"
                                                    class="form-control modern-input"
                                                    placeholder="Cantidad a comprar"
                                                    min="1"
                                                    value="1"
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Precio de Compra --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Precio Unitario <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tag"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="precio"
                                                    id="precio"
                                                    class="form-control modern-input"
                                                    placeholder="Precio unitario"
                                                    readonly
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Subtotal --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Subtotal
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-coins"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="subtotal"
                                                    id="subtotal"
                                                    class="form-control modern-input"
                                                    value="0"
                                                    readonly
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Total de la Compra --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Total de la Compra
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="total"
                                                    id="total"
                                                    class="form-control modern-input"
                                                    value="0"
                                                    readonly
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tipo de Pago --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Tipo de Pago <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-credit-card"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="tipopago"
                                                    id="tipopago"
                                                    class="form-control modern-input"
                                                    required
                                                >
                                                    <option value="">Seleccione tipo de pago</option>
                                                    <option value="contado">Contado</option>
                                                    <option value="credito">Crédito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Método de Pago --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Método de Pago <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="metodopago_id"
                                                    id="metodopago_id"
                                                    class="form-control modern-input"
                                                    required
                                                >
                                                    <option value="">Seleccione método de pago</option>
                                                    @foreach($metodospago as $metodo)
                                                        <option value="{{ $metodo->id }}">
                                                            {{ $metodo->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Abono --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Abono <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-hand-holding-usd"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="abono"
                                                    id="abono"
                                                    class="form-control modern-input"
                                                    value="0"
                                                    min="0"
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Saldo Pendiente --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Saldo Pendiente
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-wallet"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="saldopendiente"
                                                    id="saldopendiente"
                                                    class="form-control modern-input"
                                                    value="0"
                                                    readonly
                                                >
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            {{-- ========================= --}}
                            {{-- Footer --}}
                            {{-- ========================= --}}
                            <div class="card-footer modern-footer">

                                <div class="d-flex justify-content-between">

                                    <a
                                        href="{{ route('ordencompras.index') }}"
                                        class="btn btn-secondary btn-modern"
                                    >

                                        <i class="fas fa-times mr-1"></i>
                                        Cancelar

                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-success btn-modern shadow-sm"
                                    >

                                        <i class="fas fa-save mr-1"></i>
                                        Guardar

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar Select2
        $('.select2').select2({
            width: '100%',
            placeholder: "Selecciona una opción",
            allowClear: true
        });

        // Al cambiar de producto, cargar el precio de compra
        $('#producto_id').on('change', function() {
            let precio = $(this).find(':selected').data('precio') || 0;
            $('#precio').val(parseFloat(precio).toFixed(2));
            calcularTotales();
        });

        // Al ingresar cantidad o precio, calcular
        $('#cantidad').on('input', function() {
            calcularTotales();
        });

        // Al ingresar abono, calcular
        $('#abono').on('input', function() {
            calcularTotales();
        });

        // Al cambiar el tipo de pago, recalcular saldo pendiente
        $('#tipopago').on('change', function() {
            calcularTotales();
        });

        // Inicializar
        calcularTotales();

        function calcularTotales() {
            let cantidad = parseFloat($('#cantidad').val()) || 0;
            let precio = parseFloat($('#precio').val()) || 0;
            let subtotal = cantidad * precio;
            
            $('#subtotal').val(subtotal.toFixed(2));
            $('#total').val(subtotal.toFixed(2));

            let tipoPago = $('#tipopago').val();
            let abonoInput = $('#abono');
            let abono = parseFloat(abonoInput.val()) || 0;

            if (tipoPago === 'contado') {
                abonoInput.val(subtotal.toFixed(2));
                abonoInput.prop('readonly', true);
                $('#saldopendiente').val((0).toFixed(2));
            } else if (tipoPago === 'credito') {
                abonoInput.prop('readonly', false);
                if (abono > subtotal) {
                    abono = subtotal;
                    abonoInput.val(abono.toFixed(2));
                }
                let saldo = subtotal - abono;
                $('#saldopendiente').val(saldo.toFixed(2));
            } else {
                abonoInput.val((0).toFixed(2));
                abonoInput.prop('readonly', true);
                $('#saldopendiente').val((0).toFixed(2));
            }
        }
    });
</script>
@endpush
