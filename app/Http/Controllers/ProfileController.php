<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile_edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Intentar guardar en disco público (storage/app/public/users)
            try {
                if (! Storage::disk('public')->exists('users')) {
                    Storage::disk('public')->makeDirectory('users');
                }

                Storage::disk('public')->putFileAs('users', $file, $filename);

                // eliminar foto antigua en storage o en uploads legacy
                if ($user->photo) {
                    if (Storage::disk('public')->exists('users/' . $user->photo)) {
                        Storage::disk('public')->delete('users/' . $user->photo);
                    } elseif (file_exists(public_path('uploads/users/' . $user->photo))) {
                        @unlink(public_path('uploads/users/' . $user->photo));
                    }
                }

                $user->photo = $filename;
                $user->save();
            } catch (\Exception $e) {
                // Si falla la escritura en disco (por permisos en el servidor),
                // guardamos la imagen en la BD como data-URL para que se muestre.
                $contents = file_get_contents($file->getPathname());
                $base64 = base64_encode($contents);
                $mime = $file->getClientMimeType();
                $dataUrl = "data:{$mime};base64,{$base64}";

                $user->photo = $dataUrl;
                $user->save();
            }
        }

        return redirect()->route('profile.edit')->with('success', 'Foto de perfil actualizada');
    }
}
