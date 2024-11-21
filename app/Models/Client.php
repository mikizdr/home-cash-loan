<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * Eager loading of the home loan products.
     * @var array
     */
    protected $with = ['homeLoanProduct', 'cashLoanProduct'];

    /**
     * Get the advisor that owns the client.
     */
    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class,  'advisor_id');
    }

    /**
     * Get the home loan products for the client.
     */
    public function homeLoanProduct(): HasOne
    {
        return $this->hasOne(HomeLoanProduct::class);
    }

    /**
     * Get the cash loan products for the client.
     */
    public function cashLoanProduct(): HasOne
    {
        return $this->hasOne(CashLoanProduct::class);
    }
}
