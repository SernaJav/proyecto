@extends('layouts.app')

@section('title', 'Pagos')

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

                        <i class="fas fa-money-check-alt mr-2"></i>
                        Gestión de Pagos

                    </h1>

                </div>

                <div class="col-sm-6 text-right">
                    <div class="d-flex justify-content-end">
                        <a
                            href="{{ route('pagos.excel') }}"
                            class="btn btn-success btn-modern mr-2"
                        >
                            <i class="fas fa-file-excel mr-1"></i>
                            Excel
                        </a>
                        <a
                            href="{{ route('pagos.create') }}"
                            class="btn btn-primary btn-modern"
                        >
                            <i class="fas fa-plus mr-1"></i>
                            Nuevo Pago
                        </a>
                    </div>
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

                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <h3 class="card-title">

                                <i class="fas fa-wallet mr-2"></i>
                                Lista de Pagos

                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- TABLA --}}
                        {{-- ========================= --}}
                        <div class="card-body">

                            <div class="table-responsive">

                                <table
                                    id="example1"
                                    class="table custom-table table-hover datatable"
                                >

                                    <thead>

                                        <tr>

                                            <th width="10px" data-priority="1">ID</th>

                                            <th data-priority="2">Orden</th>

                                            <th data-priority="4">Método</th>

                                            <th data-priority="5">Fecha</th>

                                            <th data-priority="6">Monto</th>

                                            <th data-priority="7">Registrado por</th>

                                            <th class="all" width="120px" data-priority="1">Acciones</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($pagos as $pago)

                                            <tr>

                                                {{-- ID --}}
                                                <td>

                                                    <strong>

                                                        #{{ $pago->id }}

                                                    </strong>

                                                </td>

                                                {{-- Orden --}}
                                                <td>

                                                    <div>

                                                        <strong>

                                                            Orden #{{ $pago->ordencompra_id }}

                                                        </strong>

                                                    </div>

                                                    <small class="text-muted">

                                                        {{ $pago->ordencompra?->proveedor?->nombre ?? 'Proveedor no encontrado' }}

                                                    </small>

                                                </td>

                                                {{-- Método --}}
                                                <td>

                                                    <span class="badge badge-info px-3 py-2">

                                                        {{ $pago->metodopago->nombre ?? 'Sin método' }}

                                                    </span>

                                                </td>

                                                {{-- Fecha --}}
                                                <td>

                                                    {{ \Carbon\Carbon::parse($pago->fechapago)->format('d/m/Y') }}

                                                </td>

                                                {{-- Monto --}}
                                                <td>

                                                    <span class="badge badge-success px-3 py-2">

                                                        ${{ number_format($pago->monto, 2) }}

                                                    </span>

                                                </td>

                                                {{-- Registrado por --}}
                                                <td>

                                                    <span class="badge badge-secondary px-3 py-2">

                                                        {{ $pago->registradopor }}

                                                    </span>

                                                </td>

                                                {{-- Acciones --}}
                                                <td class="text-center text-nowrap">

                                                    <div class="btn-group btn-group-sm">

                                                        {{-- VER --}}
                                                        <a
                                                            href="{{ route('pagos.show', $pago->id) }}"
                                                            class="btn btn-info btn-action"
                                                            title="Ver pago"
                                                        >
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        {{-- PDF --}}
                                                        <a
                                                            href="{{ route('pagos.pdf', $pago->id) }}"
                                                            class="btn btn-secondary btn-action"
                                                            target="_blank"
                                                            title="Exportar PDF"
                                                            style="background-color: #e056fd; border-color: #e056fd; color: #fff;"
                                                        >
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>

                                                        {{-- EDITAR --}}
                                                        <a
                                                            href="{{ route('pagos.edit', $pago->id) }}"
                                                            class="btn btn-primary btn-action"
                                                            title="Editar pago"
                                                        >

                                                            <i class="fas fa-pencil-alt"></i>

                                                        </a>

                                                        {{-- ELIMINAR --}}
                                                        <form
                                                            class="d-inline delete-form"
                                                            action="{{ route('pagos.destroy', $pago->id) }}"
                                                            method="POST"
                                                        >

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger btn-action"
                                                                title="Eliminar pago"
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

                                {{ $pagos->links() }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection