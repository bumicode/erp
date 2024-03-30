<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomerSalesPerson extends Model
{
    use HasFactory;

    protected $table = 'customer_sales_person';

    protected $fillable = [
        'id',
        'customer_id',
        'sales_person_id',
        'contribution',
        'commission_rate',
        'contribution_to_net_total',
        'incentives',
    ];

    public function salesPerson(): HasOne
    {
        return $this->hasOne(SalesPerson::class, 'id', 'sales_person_id');
    }
}
