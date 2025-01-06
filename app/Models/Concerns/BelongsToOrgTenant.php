<?php

namespace App\Models\Concerns;

use App\Models\TenantOrganization;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrgTenant
{
    protected static function bootBelongsToOrganization(): void
    {
        static::creating(function ($model) {
            if (Filament::getTenant()) {
                $model->orgTenant()->associate(Filament::getTenant());
            }
        });

        static::addGlobalScope('orgTenant', function (Builder $query) {
            if (Filament::getTenant()) {
                $query->whereBelongsTo(Filament::getTenant());
            }
        });
    }

    public function tenantOrganization(): BelongsTo
    {
        return $this->belongsTo(TenantOrganization::class, 'tenant_organization_id', 'id');
    }
}
