@extends('layouts.app')

@section('title','Ver Proveedor')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1 style="font-weight:bold;">
                Detalle del Proveedor
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

            <div class="row">

                <div class="col-12">

                    {{-- ========================= --}}
                    {{-- CARD PRINCIPAL --}}
                    {{-- ========================= --}}
                    <div class="card custom-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header bg-white border-0">

                            <h3 style="font-weight:600; margin:0; color:#343a40;">
                                <i class="fas fa-truck mr-2 text-primary"></i>
                                Detalle del Proveedor
                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- BODY --}}
                        {{-- ========================= --}}
                        <div class="card-body">

                            <div class="row">

                                {{-- ========================= --}}
                                {{-- NOMBRE --}}
                                {{-- ========================= --}}
                                <div class="col-md-6">
                                    <label><b>Nombre</b></label>
                                    <p>{{ $proveedor->nombre }}</p>
                                </div>

                                {{-- ========================= --}}
                                {{-- DOCUMENTO --}}
                                {{-- ========================= --}}
                                <div class="col-md-6">
                                    <label><b>Documento</b></label>
                                    <p>{{ $proveedor->documento }}</p>
                                </div>

                                {{-- ========================= --}}
                                {{-- TELÉFONO --}}
                                {{-- ========================= --}}
                                <div class="col-md-6">
                                    <label><b>Teléfono</b></label>
                                    <p>{{ $proveedor->telefono }}</p>
                                </div>

                                {{-- ========================= --}}
                                {{-- EMAIL --}}
                                {{-- ========================= --}}
                                <div class="col-md-6">
                                    <label><b>Email</b></label>
                                    <p>{{ $proveedor->email }}</p>
                                </div>

                                {{-- ========================= --}}
                                {{-- DIRECCIÓN --}}
                                {{-- ========================= --}}
                                <div class="col-md-12">
                                    <label><b>Dirección</b></label>
                                    <p>{{ $proveedor->direccion ?? 'Sin dirección' }}</p>
                                </div>

                                {{-- ========================= --}}
                                {{-- REGISTRADO POR --}}
                                {{-- ========================= --}}
                                <div class="col-md-6">
                                    <label><b>Registrado por</b></label>
                                    <p>{{ $proveedor->registradopor }}</p>
                                </div>

                                {{-- ========================= --}}
                                {{-- ESTADO --}}
                                {{-- ========================= --}}
                                <div class="col-md-6">
                                    <label><b>Estado</b></label>
                                    <p>
                                        @if($proveedor->estado == 1)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-danger">Inactivo</span>
                                        @endif
                                    </p>
                                </div>

                            </div>

                        </div>

                        {{-- ========================= --}}
                        {{-- FOOTER --}}
                        {{-- ========================= --}}
                        <div class="card-footer">

                            <a href="{{ route('proveedores.index') }}"
                               class="btn btn-danger">
                                <i class="fas fa-arrow-left"></i>
                                Volver
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection