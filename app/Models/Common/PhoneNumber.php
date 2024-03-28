<?php

namespace App\Models\Common;

use App\Models\CRM\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class PhoneNumber extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'is_primary',
    ];

    public function contacts(): MorphToMany
    {
        return $this->morphedByMany(Contact::class, 'phonenumberable');
    }
}
