<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class PaymentTermTemplates extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'payment_terms_templates';

    protected $fillable = [
        'name',
    ];
}
