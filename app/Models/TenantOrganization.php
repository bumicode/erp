<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TenantOrganization extends Model
{
    use HasUuid;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
