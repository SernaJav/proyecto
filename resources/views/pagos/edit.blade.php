@extends('layouts.app')

@section('title','Editar Pago')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="page-title">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Pago
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a
                        href="{{ route('pagos.index') }}"
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
                                Información del Pago
                            </h3>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('pagos.update', $pago) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Orden de Compra
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="ordencompra_id"
                                                    class="form-control modern-input"
                                                    required
                                                >
                                                    <option value="">Seleccione una orden</option>
                                                    @foreach($ordenes as $orden)
                                                        <option
                                                            value="{{ $orden->id }}"
                                                            {{ old('ordencompra_id', $pago->ordencompra_id) == $orden->id ? 'selected' : '' }}
                                                        >
                                                            Orden #{{ $orden->id }} - {{ $orden->proveedor->nombre ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Método de Pago
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-credit-card"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="metodopago_id"
                                                    class="form-control modern-input"
                                                    required
                                                >
                                                    <option value="">Seleccione un método</option>
                                                    @foreach($metodos as $metodo)
                                                        <option
                                                            value="{{ $metodo->id }}"
                                                            {{ old('metodopago_id', $pago->metodopago_id) == $metodo->id ? 'selected' : '' }}
                                                        >
                                                            {{ $metodo->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Fecha de Pago
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="date"
                                                    name="fechapago"
                                                    class="form-control modern-input"
                                                    value="{{ old('fechapago', $pago->fechapago->format('Y-m-d')) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Monto
                                                <span class="text-danger">*</span>
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
                                                    name="monto"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese el monto"
                                                    required
                                                    value="{{ old('monto', $pago->monto) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input
                                    type="hidden"
                                    name="estado"
                                    value="{{ old('estado', $pago->estado) }}"
                                >
                            </div>

                            <div class="card-footer modern-footer">
                                <div class="d-flex justify-content-between">
                                    <a
                                        href="{{ route('pagos.index') }}"
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
