@extends('layouts.app')

@section('title','Métodos de Pago')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-3">

                <div class="col-sm-6">

                    <h1 class="page-title">

                        <i class="fas fa-credit-card mr-2"></i>
                        Métodos de Pago

                    </h1>

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

            <div class="row">

                <div class="col-12">

                    {{-- ========================= --}}
                    {{-- CARD PRINCIPAL --}}
                    {{-- ========================= --}}
                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <div class="d-flex justify-content-between align-items-center">

                                <h3 class="card-title">

                                    <i class="fas fa-money-check-alt mr-2"></i>
                                    Gestión de Métodos de Pago

                                </h3>

                                {{-- ========================= --}}
                                {{-- BOTÓN NUEVO --}}
                                {{-- ========================= --}}
                                <a
                                    href="{{ route('metodopagos.create') }}"
                                    class="btn btn-success btn-modern shadow-sm"
                                >

                                    <i class="fas fa-plus mr-1"></i>
                                    Nuevo Método

                                </a>

                            </div>

                        </div>

                        {{-- ========================= --}}
                        {{-- BODY --}}
                        {{-- ========================= --}}
                        <div class="card-body">

                            <div class="table-responsive">

                                {{-- ========================= --}}
                                {{-- TABLA --}}
                                {{-- ========================= --}}
                                <table
                                    id="example1"
                                    class="table modern-table table-hover align-middle"
                                >

                                    <thead>

                                        <tr>

                                            <th width="80px" data-priority="1">ID</th>

                                            <th data-priority="2">Método</th>

                                            <th data-priority="4">Descripción</th>

                                            <th width="120px" data-priority="3">Estado</th>

                                            <th data-priority="5">Registrado por</th>

                                            <th class="all" width="140px" class="text-center" data-priority="1">
                                                Acciones
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($metodopagos as $metodopago)

                                            <tr>

                                                {{-- ========================= --}}
                                                {{-- ID --}}
                                                {{-- ========================= --}}
                                                <td>

                                                    <span class="badge badge-dark px-3 py-2">

                                                        #{{ $metodopago->id }}

                                                    </span>

                                                </td>

                                                {{-- ========================= --}}
                                                {{-- NOMBRE --}}
                                                {{-- ========================= --}}
                                                <td>

                                                    <div class="d-flex align-items-center">

                                                        <div
                                                            style="
                                                                width: 42px;
                                                                height: 42px;
                                                                border-radius: 10px;
                                                                background: #ecfdf5;
                                                                display: flex;
                                                                align-items: center;
                                                                justify-content: center;
                                                                margin-right: 12px;
                                                            "
                                                        >

                                                            <i
                                                                class="fas fa-wallet"
                                                                style="
                                                                    color: #10b981;
                                                                    font-size: 18px;
                                                                "
                                                            ></i>

                                                        </div>

                                                        <div>

                                                            <strong
                                                                style="
                                                                    color: #1e293b;
                                                                    font-size: 15px;
                                                                "
                                                            >

                                                                {{ $metodopago->nombre }}

                                                            </strong>

                                                        </div>

                                                    </div>

                                                </td>

                                                {{-- ========================= --}}
                                                {{-- DESCRIPCIÓN --}}
                                                {{-- ========================= --}}
                                                <td>

                                                    <span class="text-muted">

                                                        {{ $metodopago->descripcion ?? 'Sin descripción registrada' }}

                                                    </span>

                                                </td>

                                                {{-- ========================= --}}
                                                {{-- ESTADO --}}
                                                {{-- ========================= --}}
                                                <td class="text-center">

                                                    <input
                                                        data-type="metodopago"
                                                        data-id="{{ $metodopago->id }}"
                                                        class="toggle-class"
                                                        type="checkbox"
                                                        data-onstyle="success"
                                                        data-offstyle="danger"
                                                        data-toggle="toggle"
                                                        data-on="Activo"
                                                        data-off="Inactivo"
                                                        {{ $metodopago->estado == '1' ? 'checked' : '' }}
                                                    >

                                                </td>

                                                {{-- ========================= --}}
                                                {{-- REGISTRADO POR --}}
                                                {{-- ========================= --}}
                                                <td>

                                                    <span
    class="badge"
    style="
        background: #e2e8f0;
        color: #1e293b;
        padding: 8px 12px;
        font-size: 12px;
        border-radius: 8px;
        font-weight: 600;
    "
>

    <i class="fas fa-user mr-1"></i>

    {{ $metodopago->registradopor }}

</span>

                                                </td>

                                                {{-- ========================= --}}
                                                {{-- ACCIONES --}}
                                                {{-- ========================= --}}
                                                <td class="text-center text-nowrap">

                                                    <div class="btn-group btn-group-sm">

                                                        {{-- VER --}}
                                                        <a
                                                            href="{{ route('metodopagos.show', $metodopago->id) }}"
                                                            class="btn btn-info btn-action"
                                                            title="Ver método"
                                                        >

                                                            <i class="fas fa-eye"></i>

                                                        </a>

                                                        {{-- EDITAR --}}
                                                        <a
                                                            href="{{ route('metodopagos.edit', $metodopago->id) }}"
                                                            class="btn btn-primary btn-action"
                                                            title="Editar método"
                                                        >

                                                            <i class="fas fa-pencil-alt"></i>

                                                        </a>

                                                        {{-- ELIMINAR --}}
                                                        <form
                                                            class="d-inline delete-form"
                                                            action="{{ route('metodopagos.destroy', $metodopago->id) }}"
                                                            method="POST"
                                                        >

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger btn-action"
                                                                title="Eliminar método"
                                                            >

                                                                <i class="fas fa-trash-alt"></i>

                                                            </button>

                                                        </form>

                                                    </div>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                            {{-- ========================= --}}
                            {{-- PAGINACIÓN --}}
                            {{-- ========================= --}}
                            <div class="mt-4 d-flex justify-content-center">

                                {{ $metodopagos->links() }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection