@extends('layouts.app')

@section('title', 'Ver Orden de Compra')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1 style="font-weight:bold;">
                Detalle de Orden de Compra
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
                        {{-- INFORMACIÓN GENERAL --}}
                        {{-- ========================= --}}
                        <div class="col-md-6">
                            <label><b>Orden ID</b></label>
                            <p>{{ $ordencompra->id }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Fecha y Hora</b></label>
                            <p>
                                @if($ordencompra->fecha)
                                    @if(is_string($ordencompra->fecha))
                                        {{ \Carbon\Carbon::parse($ordencompra->fecha)->format('d/m/Y H:i') }}
                                    @else
                                        {{ $ordencompra->fecha->format('d/m/Y H:i') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Proveedor</b></label>
                            <p>{{ $ordencompra->proveedor->nombre ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Total</b></label>
                            <p>${{ number_format($ordencompra->total, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Tipo de Pago</b></label>
                            <p>{{ $ordencompra->tipopago ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Saldo Pendiente</b></label>
                            <p>${{ number_format($ordencompra->saldopendiente, 2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Estado</b></label>
                            <p>
                                @if($ordencompra->estado == 1)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label><b>Registrado por</b></label>
                            <p>{{ $ordencompra->registradopor }}</p>
                        </div>

                    </div>

                    {{-- ========================================== --}}
                    {{-- TABLA DE DETALLES DE PRODUCTOS --}}
                    {{-- ========================================== --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4 style="font-weight: bold; color: #1e3d59; border-bottom: 2px solid #1e3d59; padding-bottom: 8px; margin-bottom: 15px;">
                                <i class="fas fa-box mr-2"></i> Productos Adquiridos
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Producto</th>
                                            <th style="width: 150px; text-align: right;">Precio Unitario</th>
                                            <th style="width: 120px; text-align: right;">Cantidad</th>
                                            <th style="width: 150px; text-align: right;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ordencompra->detallesCompras as $detalle)
                                            <tr>
                                                <td>
                                                    <strong>{{ $detalle->producto->nombre ?? 'N/A' }}</strong>
                                                    @if($detalle->producto && $detalle->producto->descripcion)
                                                        <br><small class="text-muted">{{ $detalle->producto->descripcion }}</small>
                                                    @endif
                                                </td>
                                                <td style="text-align: right;">
                                                    ${{ number_format($detalle->subtotal / ($detalle->cantidad ?: 1), 2) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ $detalle->cantidad }}
                                                </td>
                                                <td style="text-align: right;">
                                                    ${{ number_format($detalle->subtotal, 2) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No hay productos registrados en esta orden.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ========================= --}}
                {{-- FOOTER --}}
                {{-- ========================= --}}
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('ordencompras.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                    </a>
                    <a href="{{ route('ordencompras.pdf', $ordencompra->id) }}" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf mr-1"></i> Imprimir Comprobante
                    </a>
                </div>

            </div>

        </div>
    </section>

</div>

@endsection
