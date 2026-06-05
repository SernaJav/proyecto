@extends('layouts.app')

@section('title','Registrar Pago')

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

                        <i class="fas fa-money-check-alt mr-2"></i>
                        Registrar Pago

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

                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <h3 class="card-title">

                                <i class="fas fa-wallet mr-2"></i>
                                Información del Pago

                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- FORMULARIO --}}
                        {{-- ========================= --}}
                        <form
                            method="POST"
                            action="{{ route('pagos.store') }}"
                        >

                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    {{-- ========================= --}}
                                    {{-- ORDEN DE COMPRA --}}
                                    {{-- ========================= --}}
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
                                                    class="form-control modern-input select2"
                                                    required
                                                >

                                                    <option value="">
                                                        Seleccione una orden
                                                    </option>

                                                    @foreach($ordenes as $orden)

                                                        <option value="{{ $orden->id }}">

                                                            Orden #{{ $orden->id }}
                                                            -
                                                            {{ $orden->proveedor->nombre ?? '' }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- MÉTODO DE PAGO --}}
                                    {{-- ========================= --}}
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
                                                    class="form-control modern-input select2"
                                                    required
                                                >

                                                    <option value="">
                                                        Seleccione un método
                                                    </option>

                                                    @foreach($metodos as $metodo)

                                                        <option value="{{ $metodo->id }}">

                                                            {{ $metodo->nombre }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- FECHA --}}
                                    {{-- ========================= --}}
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
                                                >

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- MONTO --}}
                                    {{-- ========================= --}}
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
        $('.select2').select2({
            width: '100%',
            placeholder: "Selecciona una opción",
            allowClear: true
        });
    });
</script>
@endpush