<?php

namespace App\Models;

use App\Models\MasterData\Guru;
use App\Models\MasterData\Siswa;
use App\Models\Operasional\LogAktivitas;
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
        return $this->hasOne(Guru::class, 'user_id', 'id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'user_id', 'id');
    }

    // Helper methods menggunakan Spatie Role
    public function isSuperAdmin()
    {
        return $this->hasRole('superadmin');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isGuru()
    {
        return $this->hasRole('guru');
    }

    public function isBK()
    {
        return $this->hasRole('bk');
    }

    public function isSiswa()
    {
        return $this->hasRole('siswa');
    }

    public function isOrtu()
    {
        return $this->hasRole('ortu');
    }

    public function canAccessAdmin()
    {
        return $this->hasAnyRole(['superadmin', 'admin', 'bk']);
    }

    public function canInputData()
    {
        return $this->hasAnyRole(['superadmin', 'admin', 'guru', 'bk']);
    }

    public function canManageMaster()
    {
        return $this->hasAnyRole(['superadmin', 'admin']);
    }

    /**
     * Cek apakah user bisa mengelola users lain
     */
    public function canManageUsers()
    {
        return $this->hasAnyRole(['superadmin', 'admin']);
    }

    /**
     * Cek apakah user bisa menghapus user lain
     */
    public function canDeleteUser(User $targetUser)
    {
        // Superadmin bisa hapus semua kecuali superadmin lain dan diri sendiri
        if ($this->hasRole('superadmin')) {
            return $targetUser->id != $this->id && !$targetUser->hasRole('superadmin');
        }
        
        // Admin hanya bisa hapus user dengan hak akses di bawahnya
        if ($this->hasRole('admin')) {
            return !$targetUser->hasAnyRole(['superadmin', 'admin']) 
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
        if ($this->hasRole('superadmin')) {
            return true;
        }
        
        // Admin bisa edit semua kecuali superadmin
        if ($this->hasRole('admin')) {
            return !$targetUser->hasRole('superadmin');
        }
        
        return false;
    }
}