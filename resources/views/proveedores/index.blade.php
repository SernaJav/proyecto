@extends('layouts.app')

@section('title', 'Proveedores')

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
                        Gestión de Proveedores
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
                                    <i class="fas fa-truck mr-2 text-primary"></i>
                                    @yield('title')
                                </h3>

                                {{-- ========================= --}}
                                {{-- BOTÓN NUEVO --}}
                                {{-- ========================= --}}
                                <a
                                    href="{{ route('proveedores.create') }}"
                                    class="btn btn-primary btn-modern"
                                >
                                    <i class="fas fa-plus mr-1"></i>
                                    Nuevo
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
                                    class="table custom-table table-hover datatable"
                                >

                                    <thead>

                                        <tr>
                                            <th width="10px" data-priority="1">ID</th>
                                            <th data-priority="2">Nombre</th>
                                            <th data-priority="4">Documento</th>
                                            <th data-priority="5">Teléfono</th>
                                            <th data-priority="6">Email</th>
                                            <th data-priority="7">Dirección</th>
                                            <th width="90px" data-priority="3">Estado</th>
                                            <th data-priority="8">Registrado por</th>
                                            <th class="all" width="130px" data-priority="1">Acciones</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($proveedores as $proveedor)

                                            <tr>

                                                {{-- ID --}}
                                                <td>
                                                    <strong>
                                                        #{{ $proveedor->id }}
                                                    </strong>
                                                </td>

                                                {{-- NOMBRE --}}
                                                <td>
                                                    <strong>
                                                        {{ $proveedor->nombre }}
                                                    </strong>
                                                </td>

                                                {{-- DOCUMENTO --}}
                                                <td>
                                                    <span class="badge" style="background: #e2e8f0; color: #1e293b; padding: 6px 10px; border: 1px solid #cbd5e1;">
                                                        {{ $proveedor->documento }}
                                                    </span>
                                                </td>

                                                {{-- TELÉFONO --}}
                                                <td>
                                                    <i class="fas fa-phone mr-1 text-muted"></i>
                                                    {{ $proveedor->telefono }}
                                                </td>

                                                {{-- EMAIL --}}
                                                <td>
                                                    <i class="fas fa-envelope mr-1 text-muted"></i>
                                                    {{ $proveedor->email }}
                                                </td>

                                                {{-- DIRECCIÓN --}}
                                                <td>
                                                    <span class="text-muted">
                                                        {{ $proveedor->direccion ?? '—' }}
                                                    </span>
                                                </td>

                                                {{-- ESTADO --}}
                                                <td>
                                                    <input
                                                        data-type="proveedor"
                                                        data-id="{{ $proveedor->id }}"
                                                        class="toggle-class"
                                                        type="checkbox"
                                                        data-onstyle="success"
                                                        data-offstyle="danger"
                                                        data-toggle="toggle"
                                                        data-on="Activo"
                                                        data-off="Inactivo"
                                                        {{ $proveedor->estado == '1' ? 'checked' : '' }}
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
                                                        {{ $proveedor->registradopor }}
                                                    </span>
                                                </td>

                                                {{-- ACCIONES --}}
                                                <td class="text-center text-nowrap">

                                                    <div class="btn-group btn-group-sm">

                                                        {{-- VER --}}
                                                        <a
                                                            href="{{ route('proveedores.show', $proveedor->id) }}"
                                                            class="btn btn-info btn-action"
                                                            title="Ver proveedor"
                                                        >
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        {{-- EDITAR --}}
                                                        <a
                                                            href="{{ route('proveedores.edit', $proveedor->id) }}"
                                                            class="btn btn-primary btn-action"
                                                            title="Editar proveedor"
                                                        >
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>

                                                        {{-- ELIMINAR --}}
                                                        <form
                                                            class="d-inline delete-form"
                                                            action="{{ route('proveedores.destroy', $proveedor->id) }}"
                                                            method="POST"
                                                        >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger btn-action"
                                                                title="Eliminar proveedor"
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