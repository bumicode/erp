<?php

namespace App\Models\CRM;

use App\Models\Selling\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'is_primary_contact',
        'is_billing_contact',
        'first_name',
        'middle_name',
        'last_name',
        'full_name',
        'address_id',
        'status',
        'salutation_id',
        'designation',
        'gender',
        'user_id',
        'company_name',
    ];

    protected $appends = ['full_name'];

    public function customers(): MorphToMany
    {
        return $this->morphedByMany(Customer::class, 'contactable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function salutation(): BelongsTo
    {
        return $this->belongsTo(Salutation::class);
    }

    public function getFullNameAttribute(): string
    {
        $parts = [$this->first_name, $this->middle_name, $this->last_name];

        return implode(' ', array_filter($parts));
    }
}
