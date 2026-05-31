@extends('layouts.app')

@section('title','Editar Orden de Compra')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="page-title">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Orden de Compra
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

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card modern-card">
                        <div class="card-header modern-card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Información de la Orden
                            </h3>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('ordencompras.update', $ordencompra) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Fecha
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="date"
                                                    name="fecha"
                                                    class="form-control modern-input"
                                                    value="{{ old('fecha', $ordencompra->fecha->format('Y-m-d')) }}"
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Proveedor
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-truck"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="proveedor_id"
                                                    class="form-control modern-input"
                                                    required
                                                >
                                                    <option value="">Seleccione proveedor</option>
                                                    @foreach($proveedores as $proveedor)
                                                        <option
                                                            value="{{ $proveedor->id }}"
                                                            {{ old('proveedor_id', $ordencompra->proveedor_id) == $proveedor->id ? 'selected' : '' }}
                                                        >
                                                            {{ $proveedor->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Total de la Compra
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
                                                    name="total"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese el total"
                                                    value="{{ old('total', $ordencompra->total) }}"
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Tipo de Pago
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-credit-card"></i>
                                                    </span>
                                                </div>
                                                <select
                                                    name="tipopago"
                                                    class="form-control modern-input"
                                                    required
                                                >
                                                    <option value="">Seleccione</option>
                                                    @foreach($metodospago as $metodo)
                                                        @if($metodo->estado == 1)
                                                            <option
                                                                value="{{ $metodo->nombre }}"
                                                                {{ old('tipopago', $ordencompra->tipopago) == $metodo->nombre ? 'selected' : '' }}
                                                            >
                                                                {{ $metodo->nombre }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Saldo Pendiente</label>
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
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese el saldo pendiente"
                                                    value="{{ old('saldopendiente', $ordencompra->saldopendiente) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input
                                    type="hidden"
                                    name="estado"
                                    value="{{ old('estado', $ordencompra->estado) }}"
                                >
                            </div>

                            <div class="card-footer modern-footer">
                                <div class="d-flex justify-content-between">
                                    <a
                                        href="{{ route('ordencompras.index') }}"
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
