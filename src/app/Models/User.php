<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'avatar_url',
        'name',
        'email',
        'password',
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
     * Avatar yang dipakai Filament untuk sidebar/user menu.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        if (! empty($this->avatar_url)) {
            $avatarPath = (string) $this->avatar_url;

            /*
            |--------------------------------------------------------------------------
            | Jika avatar sudah berbentuk URL lengkap
            |--------------------------------------------------------------------------
            */
            if (str_starts_with($avatarPath, 'http://') || str_starts_with($avatarPath, 'https://')) {
                return $avatarPath;
            }

            /*
            |--------------------------------------------------------------------------
            | Jika avatar tersimpan dengan awalan storage/
            |--------------------------------------------------------------------------
            */
            if (str_starts_with($avatarPath, 'storage/')) {
                return asset($avatarPath);
            }

            /*
            |--------------------------------------------------------------------------
            | Jika avatar tersimpan di disk public
            |--------------------------------------------------------------------------
            | Contoh isi database:
            | - avatars/admin.jpg
            | - admin.jpg
            |--------------------------------------------------------------------------
            */
            return Storage::disk('public')->url($avatarPath);
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback avatar jika user belum upload foto
        |--------------------------------------------------------------------------
        */
        $hash = md5(mb_strtolower(mb_trim((string) $this->email)));

        return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
    }

    /**
     * Hanya role super_admin yang boleh masuk ke panel admin Filament.
     * Role karyawan tidak bisa masuk ke halaman /admin.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('super_admin');
    }

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
}