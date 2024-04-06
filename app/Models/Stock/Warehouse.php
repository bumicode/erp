<?php

namespace App\Models\Stock;

use App\Models\Accounting\Account;
use App\Models\CRM\Address;
use App\Models\CRM\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'is_group',
        'name',
        'warehouse_type_id',
        'parent_id',
        'in_transit_warehouse_id',
        'account_id',
        'address_id',
        'contact_id',
        'created_by',
        'updated_by',
    ];

    public function warehouseType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WarehouseType::class);
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'parent_id');
    }

    public function inTransitWarehouse(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'in_transit_warehouse_id')->where('warehouse_type_id', 1);
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable')
            ->wherePivot('addressable_id', $this->id);
    }

    public function contacts(): MorphToMany
    {
        return $this->morphToMany(Contact::class, 'contactable')
            ->wherePivot('contactable_id', $this->id);
    }
}
