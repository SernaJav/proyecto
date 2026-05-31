@extends('layouts.app')

@section('title','Editar Producto')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="page-title">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Producto
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a
                        href="{{ route('productos.index') }}"
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
                                <i class="fas fa-box mr-2"></i>
                                Información del producto
                            </h3>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('productos.update', $producto) }}"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Nombre del producto
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tag"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="text"
                                                    name="nombre"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese el nombre"
                                                    autocomplete="off"
                                                    value="{{ old('nombre', $producto->nombre) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Precio de compra
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
                                                    name="preciocompra"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese el precio"
                                                    value="{{ old('preciocompra', $producto->preciocompra) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Stock máximo
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-layer-group"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    type="number"
                                                    name="stockmaximo"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese el stock"
                                                    value="{{ old('stockmaximo', $producto->stockmaximo) }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Imagen
                                            </label>
                                            <div class="image-upload-container">
                                                <div class="image-preview-wrapper" id="imagePreviewWrapper">
                                                    @if($producto->imagen)
                                                        <img
                                                            id="imagePreview"
                                                            class="image-preview"
                                                            src="{{ asset($producto->imagen) }}"
                                                            alt="Vista previa"
                                                        >
                                                    @else
                                                        <div class="image-preview-placeholder" id="imagePreviewPlaceholder">
                                                            <i class="fas fa-image fa-3x text-muted"></i>
                                                            <p class="text-muted mt-2">Vista previa de la imagen</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="custom-file mt-2">
                                                    <input
                                                        type="file"
                                                        name="imagen"
                                                        class="custom-file-input"
                                                        id="imagen"
                                                        accept="image/jpeg,image/png,image/webp,image/jpg"
                                                    >
                                                    <label
                                                        class="custom-file-label"
                                                        for="imagen"
                                                    >
                                                        Seleccionar imagen
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle"></i>
                                                    Formatos: JPG, JPEG, PNG, WEBP. Máximo 2MB.
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Descripción
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-align-left"></i>
                                                    </span>
                                                </div>
                                                <textarea
                                                    name="descripcion"
                                                    rows="4"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese una descripción"
                                                >{{ old('descripcion', $producto->descripcion) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input
                                    type="hidden"
                                    name="estado"
                                    value="{{ old('estado', $producto->estado) }}"
                                >
                            </div>

                            <div class="card-footer modern-footer">
                                <div class="d-flex justify-content-between">
                                    <a
                                        href="{{ route('productos.index') }}"
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/dist/css/productos.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('backend/dist/js/image-preview.js') }}"></script>
@endpush
