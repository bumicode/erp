<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrgTenant;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use BelongsToOrgTenant;
}
