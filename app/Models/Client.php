<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    /**
     * Attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'advisor_id',
    ];

    /**
     * Get the advisor that owns the client.
     */
    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class,  'advisor_id');
    }
}
