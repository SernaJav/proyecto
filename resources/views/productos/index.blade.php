@extends('layouts.app')

@section('title', 'Productos')

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
                    Gestión de Productos
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

    <i class="fas fa-box-open mr-2 text-primary"></i>

    @yield('title')

</h3>

                            {{-- ========================= --}}
                            {{-- BOTÓN NUEVO --}}
                            {{-- ========================= --}}
                            <a
                                href="{{ route('productos.create') }}"
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
                                stateSave: true,
                            >

                                <thead>

                                    <tr>

                                        <th width="10px" data-priority="1">ID</th>

                                        <th data-priority="4">Imagen</th>

                                        <th data-priority="2">Producto</th>

                                        <th data-priority="5">Precio</th>

                                        <th data-priority="6">Stock</th>

                                        <th width="90px" data-priority="3">Estado</th>

                                        <th data-priority="7">Registrado por</th>

                                        <th class="all" width="130px" data-priority="1">Acciones</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($productos as $producto)

                                        <tr>

                                            {{-- ID --}}
                                            <td>

                                                <strong>

                                                    #{{ $producto->id }}

                                                </strong>

                                            </td>

                                            {{-- IMAGEN --}}
                                            <td>

                                                @if($producto->imagen)

                                                    <img
                                                        src="{{ asset($producto->imagen) }}"
                                                        alt="{{ $producto->nombre }}"
                                                        style="
                                                            width: 55px;
                                                            height: 55px;
                                                            object-fit: cover;
                                                            border-radius: 10px;
                                                            border: 2px solid #dee2e6;
                                                        "
                                                    >

                                                @else

                                                    <div
                                                        style="
                                                            width: 55px;
                                                            height: 55px;
                                                            border-radius: 10px;
                                                            background: #f1f5f9;
                                                            display: flex;
                                                            align-items: center;
                                                            justify-content: center;
                                                        "
                                                    >

                                                        <i
                                                            class="fas fa-box"
                                                            style="
                                                                font-size: 22px;
                                                                color: #94a3b8;
                                                            "
                                                        ></i>

                                                    </div>

                                                @endif

                                            </td>

                                            {{-- PRODUCTO --}}
                                            <td>

                                                <div>

                                                    <strong>

                                                        {{ $producto->nombre }}

                                                    </strong>

                                                    <br>

                                                    <small class="text-muted">

                                                        {{ $producto->descripcion ?? 'Sin descripción' }}

                                                    </small>

                                                </div>

                                            </td>

                                            {{-- PRECIO --}}
                                            <td>

                                                <span
                                                    class="badge badge-success"
                                                    style="
                                                        padding: 8px 12px;
                                                        font-size: 13px;
                                                    "
                                                >

                                                    ${{ number_format($producto->preciocompra, 2) }}

                                                </span>

                                            </td>

                                            {{-- STOCK --}}
                                            <td>

                                                <span
                                                    class="badge badge-info"
                                                    style="
                                                        padding: 8px 12px;
                                                        font-size: 13px;
                                                    "
                                                >

                                                    {{ $producto->stockmaximo }} uds

                                                </span>

                                            </td>

                                            {{-- ESTADO --}}
                                            <td>

                                                <input
                                                    data-type="producto"
                                                    data-id="{{ $producto->id }}"
                                                    class="toggle-class"
                                                    type="checkbox"
                                                    data-onstyle="success"
                                                    data-offstyle="danger"
                                                    data-toggle="toggle"
                                                    data-on="Activo"
                                                    data-off="Inactivo"
                                                    {{ $producto->estado == '1' ? 'checked' : '' }}
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

                                                    {{ $producto->registradopor }}

                                                </span>

                                            </td>

                                            {{-- ACCIONES --}}
                                            <td class="text-center text-nowrap">

                                                <div class="btn-group btn-group-sm">

                                                    {{-- VER --}}
                                                    <a
                                                        href="{{ route('productos.show', $producto->id) }}"
                                                        class="btn btn-info btn-action"
                                                        title="Ver producto"
                                                    >

                                                        <i class="fas fa-eye"></i>

                                                    </a>

                                                    {{-- EDITAR --}}
                                                    <a
                                                        href="{{ route('productos.edit', $producto->id) }}"
                                                        class="btn btn-primary btn-action"
                                                        title="Editar producto"
                                                    >

                                                        <i class="fas fa-pencil-alt"></i>

                                                    </a>

                                                    {{-- ELIMINAR --}}
                                                    <form
                                                        class="d-inline delete-form"
                                                        action="{{ route('productos.destroy', $producto->id) }}"
                                                        method="POST"
                                                    >

                                                        @csrf

                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger btn-action"
                                                            title="Eliminar producto"
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
```

</div>

@endsection
