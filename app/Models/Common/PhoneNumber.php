<?php

namespace App\Models\Common;

use App\Models\CRM\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Wildside\Userstamps\Userstamps;

class PhoneNumber extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'email',
        'is_primary',
    ];

    public function contacts(): MorphToMany
    {
        return $this->morphedByMany(Contact::class, 'phonenumberable');
    }
}
