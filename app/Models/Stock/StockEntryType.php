<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'purpose'
    ];
}
