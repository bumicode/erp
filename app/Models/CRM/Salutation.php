<?php

namespace App\Models\CRM;

use App\Models\Selling\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wildside\Userstamps\Userstamps;

class Salutation extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'salutations';

    protected $fillable = [
        'name',
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
