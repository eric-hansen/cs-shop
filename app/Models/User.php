<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'superadmin',
        'shop_name',
        'card_brand',
        'card_last_four',
        'trial_starts_at',
        'trial_ends_at',
        'shop_domain',
        'is_enabled',
        'billing_plan',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'card_last_four',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'superadmin' => 'boolean',
        'trial_starts_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'is_enabled' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function inventory(): HasManyThrough
    {
        return $this->hasManyThrough(Inventory::class, Product::class, 'id', 'product_id');
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, Product::class);
    }
}
