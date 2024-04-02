<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class SalesOrder extends Model
{
    use HasFactory, Userstamps;
}
