@extends('layouts.app')

@section('title', 'Ver Orden de Compra')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1 style="font-weight:bold;">
                Detalle de Orden de Compra
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
                            <label><b>Orden ID</b></label>
                            <p>{{ $ordencompra->id }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Fecha</b></label>
                            <p>
                                @if($ordencompra->fecha)
                                    @if(is_string($ordencompra->fecha))
                                        {{ \Carbon\Carbon::parse($ordencompra->fecha)->format('d/m/Y') }}
                                    @else
                                        {{ $ordencompra->fecha->format('d/m/Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Proveedor</b></label>
                            <p>{{ $ordencompra->proveedor->nombre ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Total</b></label>
                            <p>${{ number_format($ordencompra->total, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Tipo de Pago</b></label>
                            <p>{{ $ordencompra->tipopago ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Saldo Pendiente</b></label>
                            <p>${{ number_format($ordencompra->saldopendiente, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Estado</b></label>
                            <p>
                                @if($ordencompra->estado == 1)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Registrado por</b></label>
                            <p>{{ $ordencompra->registradopor }}</p>
                        </div>

                    </div>

                </div>

                {{-- ========================= --}}
                {{-- FOOTER --}}
                {{-- ========================= --}}
                <div class="card-footer">

                    <a href="{{ route('ordencompras.index') }}" class="btn btn-danger">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>

                </div>

            </div>

        </div>
    </section>

</div>

@endsection
