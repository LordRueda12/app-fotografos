<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
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
        'phone',        // Added phone column
        'cedula',       // Added cedula column
        'certificado',  // Added certificado column
        'role_id',      // Added role_id column
        'profile_image', // Added profile_image column
        'description', // Added description column
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
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the imagenes associated with the user.
     */
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'user_id');
    }

    /**
     * Get the orders where the user is the client.
     */
    public function clientOrders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    /**
     * Get the orders where the user is the photographer.
     */
    public function photographerOrders()
    {
        return $this->hasMany(Order::class, 'photographer_id');
    }

    /**
     * Get the products where the user is the photographer.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'photographer_id');
    }
}
