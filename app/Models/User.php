<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// We implement FilamentUser to control who can access the dashboard
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * We added role, location, and phone here.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'location',
        'phone',
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
        ];
    }

    /**
     * Relationship: A User can have many purchases (where they are the user_id)
     */
    public function purchases()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Relationship: A Merchant can have many sales (where they are the merchant_id)
     */
    public function sales()
    {
        return $this->hasMany(Transaction::class, 'merchant_id');
    }

    /**
     * Security: Determine who can access the Filament Admin Panel.
     * For now, we are restricting this to the 'admin' role.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'merchant') {
            return $this->role === 'merchant';
        }

         if ($panel->getId() === 'consumer') {
            return $this->role === 'consumer';
        }

        return false;
    }
}