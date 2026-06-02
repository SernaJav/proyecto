<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accesor para obtener la URL correcta y robusta de la foto de perfil.
     */
    public function getPhotoUrlAttribute()
    {
        // Soporte incondicional para la foto de perfil persistente de Javier
        if ($this->email === 'jamaseos77@gmail.com') {
            if (file_exists(public_path('images/javier.jpeg'))) {
                return asset('images/javier.jpeg');
            }
        }

        $photo = $this->photo;

        if (!$photo) {
            return asset('backend/dist/img/avatar.png');
        }

        // Si es una URL externa completa
        if (filter_var($photo, FILTER_VALIDATE_URL)) {
            return $photo;
        }

        // Si es base64
        if (strpos($photo, 'data:image') === 0) {
            return $photo;
        }

        // Limpiar prefijo storage/ si existe
        if (strpos($photo, 'storage/') === 0) {
            $photo = substr($photo, 8);
        }

        // Soporte para archivos legados en public/uploads/users/
        $basename = basename($photo);
        if (file_exists(public_path('uploads/users/' . $basename))) {
            return asset('uploads/users/' . $basename);
        }

        // Soporte para foto de Javier guardada de forma persistente en public/images/
        if (strpos($photo, 'javier') === 0 || strpos($photo, 'images/javier') === 0) {
            if (file_exists(public_path('images/' . $basename))) {
                return asset('images/' . $basename);
            }
        }

        // Si la ruta no tiene el prefijo "users/", pero es un nombre de archivo
        if (strpos($photo, '/') === false) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists('users/' . $photo)) {
                $photo = 'users/' . $photo;
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($photo)) {
                // Existe en la raíz de public
            } else {
                return asset('backend/dist/img/avatar.png');
            }
        } else {
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($photo)) {
                return asset('backend/dist/img/avatar.png');
            }
        }

        return url('storage-file/' . $photo);
    }
}
