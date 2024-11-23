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
     * Get a specific client by ID to check if he belongs to the advisor.
     *
     * @param int $id
     * @return bool
     */
    public function advisorOwnsClient(int $id): bool
    {
        if (!$this->isAdvisor()) {
            return false;
        }

        return (bool) $this->clients()->find($id);
    }

    /**
     * Determine if the user is an advisor.
     *
     * @return bool
     */
    public function isAdvisor(): bool
    {
        return $this->role_id === Role::ADVISOR;
    }
}
