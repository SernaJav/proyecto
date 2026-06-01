<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $ext = $file->getClientOriginalExtension();
            $filename = $user->id . '_' . time() . '.' . $ext;

            $destination = public_path('uploads/users');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // move uploaded file
            $file->move($destination, $filename);

            // delete old photo if exists and is not default
            if ($user->photo && file_exists(public_path('uploads/users/' . $user->photo))) {
                @unlink(public_path('uploads/users/' . $user->photo));
            }

            $user->photo = $filename;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Foto de perfil actualizada');
    }
}
