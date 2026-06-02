<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'foto',
        'no_telp',
        'alamat',
        'hak_akses',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

     /**
     * Accessor untuk URL foto
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto && $this->foto != 'default.jpg') {
            // Cek apakah file benar-benar ada di storage
            if (Storage::disk('public')->exists('users/' . $this->foto)) {
                return asset('storage/users/' . $this->foto);
            }
        }
        
        // Return default avatar jika foto tidak ada
        return asset('images/default-avatar.png');
    }

    // Relasi
    public function guru()
    {
        return $this->hasOne(\App\Models\MasterData\Guru::class, 'user_id', 'id');
    }

    public function siswa()
    {
        return $this->hasOne(\App\Models\MasterData\Siswa::class, 'user_id', 'id');
    }

    public function logAktivitas()
    {
        return $this->hasMany(\App\Models\Operasional\LogAktivitas::class, 'user_id', 'id');
    }

    // Helper methods untuk pengecekan hak akses
    public function isSuperAdmin()
    {
        return $this->hak_akses === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->hak_akses === 'admin';
    }

    public function isGuru()
    {
        return $this->hak_akses === 'guru';
    }

    public function isBK()
    {
        return $this->hak_akses === 'bk';
    }

    public function isSiswa()
    {
        return $this->hak_akses === 'siswa';
    }

    public function isOrtu()
    {
        return $this->hak_akses === 'ortu';
    }

    public function canAccessAdmin()
    {
        return in_array($this->hak_akses, ['superadmin', 'admin', 'bk']);
    }

    public function canInputData()
    {
        return in_array($this->hak_akses, ['superadmin', 'admin', 'guru', 'bk']);
    }

    public function canManageMaster()
    {
        return in_array($this->hak_akses, ['superadmin', 'admin']);
    }

    /**
 * Cek apakah user bisa mengelola users lain
 */
public function canManageUsers()
{
    return in_array($this->hak_akses, ['superadmin', 'admin']);
}

/**
 * Cek apakah user bisa menghapus user lain
 */
public function canDeleteUser(User $targetUser)
{
    // Superadmin bisa hapus semua kecuali superadmin lain dan diri sendiri
    if ($this->hak_akses == 'superadmin') {
        return $targetUser->id != $this->id && $targetUser->hak_akses != 'superadmin';
    }
    
    // Admin hanya bisa hapus user dengan hak akses di bawahnya
    if ($this->hak_akses == 'admin') {
        return !in_array($targetUser->hak_akses, ['superadmin', 'admin']) 
            && $targetUser->id != $this->id;
    }
    
    return false;
}

/**
 * Cek apakah user bisa mengedit user lain
 */
public function canEditUser(User $targetUser)
{
    // Superadmin bisa edit semua
    if ($this->hak_akses == 'superadmin') {
        return true;
    }
    
    // Admin bisa edit semua kecuali superadmin
    if ($this->hak_akses == 'admin') {
        return $targetUser->hak_akses != 'superadmin';
    }
    
    return false;
}
}