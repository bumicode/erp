<?php

namespace App\Models\CRM;

use App\Models\Selling\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    public function customers(): MorphToMany
    {
        return $this->morphedByMany(Customer::class, 'contactable');
    }
}
