<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeLoanProduct extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    /**
     * Attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'client_id',
        'property_value',
        'down_payment',
    ];

    /**
     * Get the client that owns the home loan product.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
