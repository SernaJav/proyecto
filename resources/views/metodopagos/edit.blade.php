@extends('layouts.app')

@section('title','Editar Método de Pago')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="page-title">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Método de Pago
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

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card modern-card">
                        <div class="card-header modern-card-header">
                            <h3 class="card-title">
                                <i class="fas fa-wallet mr-2"></i>
                                Información del Método de Pago
                            </h3>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('metodopagos.update', $metodoPago) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="card-body">
                                <div class="row">
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
                                                    value="{{ old('nombre', $metodoPago->nombre) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

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
                                                    value="{{ old('descripcion', $metodoPago->descripcion) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input
                                    type="hidden"
                                    name="estado"
                                    value="{{ old('estado', $metodoPago->estado) }}"
                                >
                            </div>

                            <div class="card-footer modern-footer">
                                <div class="d-flex justify-content-between">
                                    <a
                                        href="{{ route('metodopagos.index') }}"
                                        class="btn btn-outline-secondary btn-modern"
                                    >
                                        <i class="fas fa-times mr-1"></i>
                                        Cancelar
                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-success btn-modern shadow-sm"
                                    >
                                        <i class="fas fa-save mr-1"></i>
                                        Actualizar
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
