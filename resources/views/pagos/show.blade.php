@extends('layouts.app')

@section('title', 'Ver Pago')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1 style="font-weight:bold;">
                Detalle del Pago
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
                            <label><b>Pago ID</b></label>
                            <p>{{ $pago->id }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Orden de Compra</b></label>
                            <p>{{ $pago->ordenCompra->id ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Método de Pago</b></label>
                            <p>{{ $pago->metodoPago->nombre ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Monto</b></label>
                            <p>${{ number_format($pago->monto, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Fecha de Pago</b></label>
                            <p>{{ $pago->fechapago }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Estado</b></label>
                            <p>
                                @if($pago->estado == 1)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Registrado por</b></label>
                            <p>{{ $pago->registradopor }}</p>
                        </div>

                        {{-- ========================= --}}
                        {{-- INFORMACIÓN ADICIONAL --}}
                        {{-- ========================= --}}
                        <div class="col-md-6">
                            <label><b>Total Orden</b></label>
                            <p>${{ number_format($pago->ordenCompra->total ?? 0, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Saldo Pendiente</b></label>
                            <p>${{ number_format($pago->ordenCompra->saldopendiente ?? 0, 2) }}</p>
                        </div>

                    </div>

                </div>

                {{-- ========================= --}}
                {{-- FOOTER --}}
                {{-- ========================= --}}
                <div class="card-footer">

                    <a href="{{ route('pagos.index') }}" class="btn btn-danger">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>

                </div>

            </div>

        </div>
    </section>

</div>

@endsection
