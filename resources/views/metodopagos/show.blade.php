@extends('layouts.app')

@section('title', 'Ver Método de Pago')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1 style="font-weight:bold;">
                Detalle del Método de Pago
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
                        {{-- NOMBRE --}}
                        {{-- ========================= --}}
                        <div class="col-md-6">
                            <label><b>Nombre</b></label>
                            <p>{{ $metodoPago->nombre }}</p>
                        </div>

                        {{-- ========================= --}}
                        {{-- ESTADO --}}
                        {{-- ========================= --}}
                        <div class="col-md-6">
                            <label><b>Estado</b></label>
                            <p>
                                @if($metodoPago->estado == 1)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>

                        {{-- ========================= --}}
                        {{-- DESCRIPCIÓN --}}
                        {{-- ========================= --}}
                        <div class="col-md-12">
                            <label><b>Descripción</b></label>
                            <p>{{ $metodoPago->descripcion ?? 'Sin descripción' }}</p>
                        </div>

                        {{-- ========================= --}}
                        {{-- REGISTRADO POR --}}
                        {{-- ========================= --}}
                        <div class="col-md-6">
                            <label><b>Registrado por</b></label>
                            <p>{{ $metodoPago->registradopor }}</p>
                        </div>

                        {{-- ========================= --}}
                        {{-- FECHA DE CREACIÓN --}}
                        {{-- ========================= --}}
                        <div class="col-md-6">
                            <label><b>Fecha de Creación</b></label>
                            <p>
                                @if($metodoPago->created_at)
                                    @if(is_string($metodoPago->created_at))
                                        {{ \Carbon\Carbon::parse($metodoPago->created_at)->format('d/m/Y H:i') }}
                                    @else
                                        {{ $metodoPago->created_at->format('d/m/Y H:i') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                    </div>

                </div>

                {{-- ========================= --}}
                {{-- FOOTER --}}
                {{-- ========================= --}}
                <div class="card-footer">

                    <a href="{{ route('metodopagos.index') }}" class="btn btn-danger">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>

                </div>

            </div>

        </div>
    </section>

</div>

@endsection
