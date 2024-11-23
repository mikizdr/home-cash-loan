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

    /**
     * Since it's a good practice to store phone numbers in a consistent format.
     * Set the client's phone number to contain only numbers (as showcase for our case).
     * It also removes any special characters.
     * If the phone field is empty, it will be set to null.
     *
     * @param string|null $value
     * @return void
     */
    public function setPhoneAttribute(?string $value): void
    {
        $phone = preg_replace('/[^0-9]/', '', $value);
        $this->attributes['phone'] = !empty($phone) ? $phone : null;
    }

    /**
     * Set the client's email address to lowercase.
     *
     * @param string|null $value
     * @return void
     */
    public function setEmailAttribute(?string $value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Set the client's first name to capitalized.
     *
     * @param string $value
     * @return void
     */
    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    /**
     * Set the client's last name to capitalized.
     *
     * @param string $value
     * @return void
     */
    public function setLastNameAttribute(string $value): void
    {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }
}
