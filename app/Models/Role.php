<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * This class represents roles in the system.
 * This is the only place where roles are defined and stored.
 * @package App\Models
 */
class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    /**
     * Default role ID for a user.
     * @var int
     */
    public const USER = 1;

    /**
     * ID of the advisor role.
     * @var int
     */
    public const ADVISOR = 2;

    /**
     * Possible roles in the system.
     * @var array<string, int>
     */
    public const ROLES = [
        'user' => self::USER,
        'advisor' => self::ADVISOR,
    ];

    /**
     * Get the users that have this role.
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all advisors that have this role.
     * @return HasMany
     */
    public function advisers(): HasMany
    {
        return $this->hasMany(User::class)
            ->where('role_id', self::ADVISOR);
    }
}
