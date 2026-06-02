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

            // nombre único
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // guardar en storage/app/public/users
            Storage::disk('public')->putFileAs('users', $file, $filename);

            // borrar foto anterior (si existe)
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // guardar SOLO ruta limpia
            $user->photo = 'users/' . $filename;
            $user->save();
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Foto de perfil actualizada correctamente');
    }
}