<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashLoanProduct extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    /**
     * Attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'client_id',
        'loan_amount',
    ];

    /**
     * Get the client that owns the home loan product.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
