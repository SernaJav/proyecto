@extends('layouts.app')

@section('title','Crear Método de Pago')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="page-title">

                        <i class="fas fa-credit-card mr-2"></i>
                        Crear Método de Pago

                    </h1>

                </div>

                <div class="col-sm-6 text-right">

                    <a
                        href="{{ route('metodopagos.index') }}"
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
    {{-- MENSAJES --}}
    {{-- ========================= --}}
    @include('layouts.partial.msg')

    {{-- ========================= --}}
    {{-- CONTENIDO --}}
    {{-- ========================= --}}
    <section class="content">

        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-lg-10">

                    {{-- ========================= --}}
                    {{-- CARD PRINCIPAL --}}
                    {{-- ========================= --}}
                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <h3 class="card-title">

                                <i class="fas fa-wallet mr-2"></i>
                                Información del Método de Pago

                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- FORMULARIO --}}
                        {{-- ========================= --}}
                        <form
                            method="POST"
                            action="{{ route('metodopagos.store') }}"
                        >

                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    {{-- ========================= --}}
                                    {{-- NOMBRE --}}
                                    {{-- ========================= --}}
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label class="form-label">

                                                Nombre del Método

                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">

                                                        <i class="fas fa-money-bill-wave"></i>

                                                    </span>

                                                </div>

                                                <input
                                                    type="text"
                                                    name="nombre"
                                                    class="form-control modern-input"
                                                    placeholder="Ej: Efectivo"
                                                    autocomplete="off"
                                                    required
                                                >

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- DESCRIPCIÓN --}}
                                    {{-- ========================= --}}
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label class="form-label">

                                                Descripción

                                            </label>

                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">

                                                        <i class="fas fa-align-left"></i>

                                                    </span>

                                                </div>

                                                <input
                                                    type="text"
                                                    name="descripcion"
                                                    class="form-control modern-input"
                                                    placeholder="Descripción opcional"
                                                    autocomplete="off"
                                                >

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                {{-- ========================= --}}
                                {{-- CAMPOS OCULTOS --}}
                                {{-- ========================= --}}
                                <input
                                    type="hidden"
                                    name="estado"
                                    value="1"
                                >

                                <input
                                    type="hidden"
                                    name="registradopor"
                                    value="{{ Auth::user()->name }}"
                                >

                            </div>

                            {{-- ========================= --}}
                            {{-- FOOTER --}}
                            {{-- ========================= --}}
                            <div class="card-footer modern-footer">

                                <div class="d-flex justify-content-between">

                                    {{-- CANCELAR --}}
                                    <a
                                        href="{{ route('metodopagos.index') }}"
                                        class="btn btn-outline-secondary btn-modern"
                                    >

                                        <i class="fas fa-times mr-1"></i>
                                        Cancelar

                                    </a>

                                    {{-- GUARDAR --}}
                                    <button
                                        type="submit"
                                        class="btn btn-success btn-modern shadow-sm"
                                    >

                                        <i class="fas fa-save mr-1"></i>
                                        Guardar Método

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