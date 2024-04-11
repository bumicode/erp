<?php

namespace App\Models\Stock;

use App\Enums\Stock\StockEntryListPurpose;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'purpose'
    ];

    protected $casts = [
        'purpose' => StockEntryListPurpose::class,
    ];
}
