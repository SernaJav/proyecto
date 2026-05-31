@extends('layouts.app')

@section('title','Crear Producto')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="page-title">
                        <i class="fas fa-box-open mr-2"></i>
                        Crear Producto
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

    {{-- ========================= --}}
    {{-- Mensajes --}}
    {{-- ========================= --}}
    @include('layouts.partial.msg')

    {{-- ========================= --}}
    {{-- Contenido --}}
    {{-- ========================= --}}
    <section class="content">

        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-lg-10">

                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- Header --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <h3 class="card-title">

                                <i class="fas fa-box mr-2"></i>

                                Información del producto

                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- Formulario --}}
                        {{-- ========================= --}}
                        <form
                            method="POST"
                            action="{{ route('productos.store') }}"
                            enctype="multipart/form-data"
                        >

                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    {{-- ========================= --}}
                                    {{-- Nombre --}}
                                    {{-- ========================= --}}
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
                                                    value="{{ old('nombre') }}"
                                                >

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- Precio --}}
                                    {{-- ========================= --}}
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
                                                    value="{{ old('preciocompra') }}"
                                                >

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- Stock --}}
                                    {{-- ========================= --}}
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
                                                    value="{{ old('stockmaximo') }}"
                                                >

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- Imagen --}}
                                    {{-- ========================= --}}
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label class="form-label">

                                                Imagen

                                            </label>

                                            <div class="image-upload-container">

                                                <div class="image-preview-wrapper" id="imagePreviewWrapper">

                                                    <div class="image-preview-placeholder" id="imagePreviewPlaceholder">
                                                        <i class="fas fa-image fa-3x text-muted"></i>
                                                        <p class="text-muted mt-2">Vista previa de la imagen</p>
                                                    </div>

                                                    <img 
                                                        id="imagePreview" 
                                                        class="image-preview" 
                                                        src="#" 
                                                        alt="Vista previa" 
                                                        style="display: none;"
                                                    >

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

                                    {{-- ========================= --}}
                                    {{-- Descripción --}}
                                    {{-- ========================= --}}
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
                                                >{{ old('descripcion') }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                {{-- ========================= --}}
                                {{-- Campos ocultos --}}
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
                            {{-- Footer --}}
                            {{-- ========================= --}}
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/dist/css/productos.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('backend/dist/js/image-preview.js') }}"></script>
@endpush
