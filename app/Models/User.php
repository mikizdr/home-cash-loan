<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helper\CustomPaginator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    /**
     * Get the cash and home loan products for the user
     * sorted by updated_at attribute.
     */
    public function getSortedProducts(bool $returnNonPaginated = false): array|LengthAwarePaginator
    {
        $products = [];
        $clients = $this->clients;
        $sortedBy = 'updated_at';

        foreach ($clients as $client) {
            if ($client->cashLoanProduct) {
                array_push($products, [
                    'type' => 'Cash Loan',
                    'loan_amount' => $client->cashLoanProduct->loan_amount,
                    $sortedBy => $client->cashLoanProduct[$sortedBy],
                ]);
            }

            if ($client->homeLoanProduct) {
                array_push($products, [
                    'type' => 'Home Loan',
                    'property_value' => $client->homeLoanProduct->property_value,
                    'down_payment' => $client->homeLoanProduct->down_payment,
                    $sortedBy => $client->homeLoanProduct[$sortedBy],
                ]);
            }
        }

        usort($products, fn($a, $b) => strtotime($b[$sortedBy]) <=> strtotime($a[$sortedBy]));

        if ($returnNonPaginated) {
            return $products;
        }

        $paginatedProducts = CustomPaginator::paginate($products, 10);

        return $paginatedProducts;
    }
}
