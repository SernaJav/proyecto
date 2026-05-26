{{-- ========================= --}}
{{-- ERRORES VALIDACION --}}
{{-- ========================= --}}
@if ($errors->any())

    @foreach ($errors->all() as $error)

        <div
            class="alert alert-danger alert-dismissible fade show shadow-sm"
            role="alert"
            style="
                border-left: 5px solid #dc3545;
                border-radius: 10px;
            "
        >

            {{-- icono --}}
            <i class="fas fa-exclamation-circle mr-2"></i>

            <strong>Advertencia:</strong>

            {{ $error }}

            {{-- botón cerrar --}}
            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

    @endforeach

@endif


{{-- ========================= --}}
{{-- MENSAJE SUCCESS --}}
{{-- ========================= --}}
@if(session('successMsg'))

    <div
        class="alert alert-success alert-dismissible fade show shadow-sm"
        role="alert"
        style="
            border-left: 5px solid #28a745;
            border-radius: 10px;
        "
    >

        {{-- icono --}}
        <i class="fas fa-check-circle mr-2"></i>

        <strong>Éxito:</strong>

        {{ session('successMsg') }}

        {{-- botón cerrar --}}
        <button
            type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"
        >
            <span aria-hidden="true">&times;</span>
        </button>

    </div>

@endif


{{-- ========================= --}}
{{-- MENSAJE ERROR --}}
{{-- ========================= --}}
@if(session('error'))

    <div
        class="alert alert-danger alert-dismissible fade show shadow-sm"
        role="alert"
        style="
            border-left: 5px solid #dc3545;
            border-radius: 10px;
        "
    >

        {{-- icono --}}
        <i class="fas fa-times-circle mr-2"></i>

        <strong>Error:</strong>

        {{ session('error') }}

        {{-- botón cerrar --}}
        <button
            type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"
        >
            <span aria-hidden="true">&times;</span>
        </button>

    </div>

@endif