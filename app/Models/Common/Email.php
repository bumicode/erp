<?php

namespace App\Models\Common;

use App\Models\CRM\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Email extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'is_primary_phone',
        'is_primary_mobile',
    ];

    public function contacts(): MorphToMany
    {
        return $this->morphedByMany(Contact::class, 'emailable');
    }
}
