<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_group',
        'status',
        'name',
        'employee',
        'parent_id',
        'commission_rate',
    ];

    public function parent()
    {
        return $this->belongsTo(SalesPerson::class, 'parent_id');
    }
}
