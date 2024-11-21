<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
     * Default values for the user model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role_id' => Role::USER,
    ];

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get all of the clients for this user.
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'advisor_id');
    }

    /**
     * Get the home loan product for a client that belongs to this advisor.
     */
    public function homeLoanProduct(): HasOneThrough
    {
        return $this->hasOneThrough(
            related: HomeLoanProduct::class,
            through: Client::class,
            firstKey: 'advisor_id',
            secondKey: 'client_id'
        );
    }

    /**
     * Get a specific client by ID or any other attribute.
     *
     * @param mixed $attribute
     * @param mixed $value
     * @return Client|null
     */
    public function getClientByAttribute($attribute, $value): ?Client
    {
        return $this->clients()->where($attribute, $value)->first();
    }
}
