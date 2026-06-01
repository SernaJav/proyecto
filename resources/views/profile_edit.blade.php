@extends('layouts.app')

@section('content')
<div class="container" style="max-width:720px;margin:20px auto;">
    <div class="card">
        <div class="card-header">Editar perfil</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label>Foto actual</label>
                    <div>
                        @php
                            $photo = Auth::user()->photo;
                            $isDataUrl = is_string($photo) && strpos($photo, 'data:') === 0;
                            $storageKey = null;

                            if (! $isDataUrl && $photo) {
                                if (strpos($photo, 'storage/') === 0) {
                                    $storageKey = substr($photo, strlen('storage/'));
                                } elseif (strpos($photo, 'users/') === 0) {
                                    $storageKey = $photo;
                                } else {
                                    $storageKey = 'users/' . $photo;
                                }
                            }

                            $storagePhoto = $storageKey && Storage::disk('public')->exists($storageKey);
                            $storageUrl = $storagePhoto ? url('storage-file/' . $storageKey) : null;
                            $legacyPhoto = $photo && file_exists(public_path('uploads/users/' . basename($photo)));
                        @endphp

                        @if ($isDataUrl)
                            <img src="{{ $photo }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
                        @elseif ($storagePhoto)
                            <img src="{{ $storageUrl }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
                        @elseif ($legacyPhoto)
                            <img src="{{ asset('uploads/users/' . $photo) }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
                        @else
                            <img src="{{ asset('backend/dist/img/avatar.png') }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
                        @endif
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="photo">Nueva foto (jpeg/png)</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                    @error('photo')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <button class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
