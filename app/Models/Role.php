<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrgTenant;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use BelongsToOrgTenant;
}
