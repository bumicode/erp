<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_group_id',
        'credit_limit',
    ];

    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }
}
