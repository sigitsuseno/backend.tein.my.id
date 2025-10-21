<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasRolePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRolePermission, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'username',
        'email',
        'password',
        'type',
        'google_id',
        'avatar',
        'status',
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

    protected static function generateUniqueCustomId(string $prefix, string $type): string
    {
        do {
            $year = date('Y');
            $randomNumber = mt_rand(1, 9999999);
            $paddedNumber = str_pad($randomNumber, 7, '0', STR_PAD_LEFT);
            $customId = "{$prefix}{$year}-{$type}{$paddedNumber}";
            $exists = static::where('uuid', $customId)->exists();
        } while ($exists);

        return $customId;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = static::generateUniqueCustomId('MR', 'U');
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasPermission($permSlug)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->pluck('slug')->contains($permSlug)) {
                return true;
            }
        }

        return false;
    }

    public function details()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function medis()
    {
        return $this->hasOne(InformasiMedis::class);
    }

    public function kontakDarurat()
    {
        return $this->hasMany(KontakDarurat::class);
    }
}
