@extends('layouts.app')

@section('title', 'Órdenes de Compra')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1
                        style="
                            font-weight: bold;
                            color: #343a40;
                        "
                    >
                        Gestión de Órdenes de Compra
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
                    <div class="card custom-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header bg-white border-0">

                            <div class="d-flex justify-content-between align-items-center">

                                <h3
                                    style="
                                        font-weight: 600;
                                        color: #343a40;
                                        margin: 0;
                                    "
                                >

                                    <i class="fas fa-file-invoice-dollar mr-2 text-primary"></i>

                                    @yield('title')

                                </h3>

                                {{-- ========================= --}}
                                {{-- BOTONES DE ACCIÓN --}}
                                {{-- ========================= --}}
                                <div class="d-flex">
                                    <a
                                        href="{{ route('ordencompras.create') }}"
                                        class="btn btn-primary btn-modern mr-2"
                                    >
                                        <i class="fas fa-plus mr-1"></i>
                                        Nuevo
                                    </a>
                                    <a
                                        href="{{ route('ordencompras.excel') }}"
                                        class="btn btn-success btn-modern"
                                    >
                                        <i class="fas fa-file-excel mr-1"></i>
                                        Excel
                                    </a>
                                </div>

                            </div>

                        </div>

                        {{-- ========================= --}}
                        {{-- BODY --}}
                        {{-- ========================= --}}
                        <div class="card-body">

                            <div class="table-responsive">

                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >

                                    <thead>

                                        <tr>

                                            <th width="10px" data-priority="1">ID</th>

                                            <th data-priority="2">Proveedor</th>

                                            <th data-priority="4">Fecha</th>

                                            <th data-priority="5">Total</th>

                                            <th data-priority="6">Método Pago</th>

                                            <th data-priority="7">Saldo</th>

                                            <th width="90px" data-priority="3">Estado</th>

                                            <th data-priority="8">Registrado por</th>

                                            <th class="all" width="130px" data-priority="1">Acciones</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($ordencompras as $orden)

                                            <tr>

                                                {{-- ID --}}
                                                <td>

                                                    <strong>

                                                        #{{ $orden->id }}

                                                    </strong>

                                                </td>

                                                {{-- PROVEEDOR --}}
                                                <td>

                                                    <strong>

                                                        {{ $orden->proveedor->nombre ?? 'Sin proveedor' }}

                                                    </strong>

                                                </td>

                                                {{-- FECHA --}}
                                                <td>

                                                    {{ \Carbon\Carbon::parse($orden->fecha)->format('d/m/Y') }}

                                                </td>

                                                {{-- TOTAL --}}
                                                <td>

                                                    <span
                                                        class="badge badge-success"
                                                        style="
                                                            padding: 8px 12px;
                                                            font-size: 13px;
                                                        "
                                                    >

                                                        ${{ number_format($orden->total, 2) }}

                                                    </span>

                                                </td>

                                                {{-- MÉTODO PAGO --}}
                                                <td>

                                                    <span
                                                        class="badge badge-info"
                                                        style="
                                                            padding: 8px 12px;
                                                            font-size: 13px;
                                                        "
                                                    >

                                                        {{ $orden->tipopago }}

                                                    </span>

                                                </td>

                                                {{-- SALDO --}}
                                                <td>

                                                    @if($orden->saldopendiente > 0)

                                                        <span
                                                            class="badge badge-danger"
                                                            style="
                                                                padding: 8px 12px;
                                                                font-size: 13px;
                                                            "
                                                        >

                                                            ${{ number_format($orden->saldopendiente, 2) }}

                                                        </span>

                                                    @else

                                                        <span
                                                            class="badge badge-success"
                                                            style="
                                                                padding: 8px 12px;
                                                                font-size: 13px;
                                                            "
                                                        >

                                                            Pagado

                                                        </span>

                                                    @endif

                                                </td>

                                                {{-- ESTADO --}}
                                                <td>

                                                    <input
                                                        data-type="ordencompra"
                                                        data-id="{{ $orden->id }}"
                                                        class="toggle-class"
                                                        type="checkbox"
                                                        data-onstyle="success"
                                                        data-offstyle="danger"
                                                        data-toggle="toggle"
                                                        data-on="Activo"
                                                        data-off="Inactivo"
                                                        {{ $orden->estado == '1' ? 'checked' : '' }}
                                                    >

                                                </td>

                                                {{-- REGISTRADO POR --}}
                                                <td>

                                                    <span
                                                        class="badge badge-secondary"
                                                        style="
                                                            padding: 8px;
                                                            font-size: 12px;
                                                        "
                                                    >

                                                        {{ $orden->registradopor }}

                                                    </span>

                                                </td>

                                                {{-- ACCIONES --}}
                                                <td class="text-center text-nowrap">

                                                    <div class="btn-group btn-group-sm">

                                                        {{-- VER --}}
                                                        <a
                                                            href="{{ route('ordencompras.show', $orden->id) }}"
                                                            class="btn btn-info btn-action"
                                                            title="Ver orden"
                                                        >
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        {{-- EDITAR --}}
                                                        <a
                                                            href="{{ route('ordencompras.edit', $orden->id) }}"
                                                            class="btn btn-primary btn-action"
                                                            title="Editar orden"
                                                        >
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>

                                                        {{-- PDF --}}
                                                        <a
                                                            href="{{ route('ordencompras.pdf', $orden->id) }}"
                                                            class="btn btn-danger btn-action"
                                                            target="_blank"
                                                            title="Imprimir PDF"
                                                        >
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>

                                                        {{-- ELIMINAR --}}
                                                        <form
                                                            class="d-inline delete-form"
                                                            action="{{ route('ordencompras.destroy', $orden->id) }}"
                                                            method="POST"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger btn-action"
                                                                title="Eliminar orden"
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

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection

{{-- ========================= --}}
{{-- DATATABLE --}}
{{-- ========================= --}}
@push('scripts')

<script>

    $(function () {

        $("#example1").DataTable({

            "responsive": true,

            "lengthChange": true,

            "autoWidth": false,

            "pageLength": 10,

            "language": {

                "lengthMenu":
                    "Mostrar _MENU_ registros",

                "zeroRecords":
                    "No se encontraron registros",

                "info":
                    "Mostrando _START_ a _END_ de _TOTAL_ registros",

                "infoEmpty":
                    "No hay registros disponibles",

                "infoFiltered":
                    "(filtrado de _MAX_ registros)",

                "search":
                    "Buscar:",

                "paginate": {

                    "first": "Primero",

                    "last": "Último",

                    "next": "Siguiente",

                    "previous": "Anterior"
                }
            }
        });

    });

</script>

@endpush