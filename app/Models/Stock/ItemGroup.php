<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemGroup extends Model
{
    use HasFactory;

    protected $table = 'item_groups';

    protected $fillable = [
        'name',
        'parent_id',
        'is_group',
        'show_in_website',
        'created_by',
        'updated_by',
    ];
}
