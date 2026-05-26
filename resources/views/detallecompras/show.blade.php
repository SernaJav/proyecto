@extends('layouts.app')

@section('title', 'Ver Detalle de Compra')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1 style="font-weight:bold;">
                Detalle de Compra
            </h1>
        </div>
    </section>

    {{-- ========================= --}}
    {{-- MENSAJES --}}
    {{-- ========================= --}}
    @include('layouts.partial.msg')

    {{-- ========================= --}}
    {{-- CONTENIDO --}}
    {{-- ========================= --}}
    <section class="content">
        <div class="container-fluid">

            <div class="card custom-card">

                <div class="card-body">

                    <div class="row">

                        {{-- ========================= --}}
                        {{-- INFORMACIÓN GENERAL --}}
                        {{-- ========================= --}}
                        <div class="col-md-6">
                            <label><b>Detalle ID</b></label>
                            <p>{{ $detalle->id }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Orden de Compra</b></label>
                            <p>{{ $detalle->ordenCompra->id ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Producto</b></label>
                            <p>{{ $detalle->producto->nombre ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Cantidad</b></label>
                            <p>{{ $detalle->cantidad }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Subtotal</b></label>
                            <p>${{ number_format($detalle->subtotal, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Registrado por</b></label>
                            <p>{{ $detalle->registradopor }}</p>
                        </div>

                        {{-- ========================= --}}
                        {{-- INFORMACIÓN ADICIONAL --}}
                        {{-- ========================= --}}
                        <div class="col-md-12">
                            <label><b>Descripción del Producto</b></label>
                            <p>{{ $detalle->producto->descripcion ?? 'Sin descripción' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Precio Unitario</b></label>
                            <p>${{ number_format($detalle->producto->preciocompra ?? 0, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Stock Máximo</b></label>
                            <p>{{ $detalle->producto->stockmaximo ?? 'N/A' }}</p>
                        </div>

                    </div>

                </div>

                {{-- ========================= --}}
                {{-- FOOTER --}}
                {{-- ========================= --}}
                <div class="card-footer">

                    <a href="{{ route('detallecompras.index') }}" class="btn btn-danger">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>

                </div>

            </div>

        </div>
    </section>

</div>

@endsection
