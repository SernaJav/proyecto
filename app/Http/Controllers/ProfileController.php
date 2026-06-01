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

            if (!Storage::disk('public')->exists('users')) {
                Storage::disk('public')->makeDirectory('users');
            }

            $file->storeAs('public/users', $filename);

            if ($user->photo && Storage::disk('public')->exists('users/' . $user->photo)) {
                Storage::disk('public')->delete('users/' . $user->photo);
            }

            $user->photo = $filename;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Foto de perfil actualizada');
    }
}
