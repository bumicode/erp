<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTermTemplates extends Model
{
    use HasFactory;

    protected $table = 'payment_terms_templates';

    protected $fillable = [
        'name',
    ];
}
