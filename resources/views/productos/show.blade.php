@extends('layouts.app')

@section('title', 'Ver Producto')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1 style="font-weight:bold;">
                Detalle del Producto
            </h1>
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

            <div class="card custom-card">

                <div class="card-body">

                    <div class="row">

                        {{-- ========================= --}}
                        {{-- IMAGEN --}}
                        {{-- ========================= --}}
                        <div class="col-md-4 text-center">

                            @if($producto->imagen)

                                <img
                                    src="{{ asset($producto->imagen) }}"
                                    style="width: 250px; height: 250px; object-fit: cover; border-radius: 12px;"
                                >

                            @else

                                <div style="width:250px;height:250px;background:#eee;display:flex;align-items:center;justify-content:center;border-radius:12px;">
                                    Sin imagen
                                </div>

                            @endif

                        </div>

                        {{-- ========================= --}}
                        {{-- INFO --}}
                        {{-- ========================= --}}
                        <div class="col-md-8">

                            <h3>{{ $producto->nombre }}</h3>

                            <p><b>Descripción:</b> {{ $producto->descripcion ?? 'Sin descripción' }}</p>

                            <p><b>Precio:</b> ${{ number_format($producto->preciocompra, 2) }}</p>

                            <p><b>Stock:</b> {{ $producto->stockmaximo }}</p>

                            <p><b>Estado:</b>
                                @if($producto->estado == 1)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </p>

                            <p><b>Registrado por:</b> {{ $producto->registradopor }}</p>

                            <a href="{{ route('productos.index') }}" class="btn btn-danger">
                                Volver
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

</div>

@endsection