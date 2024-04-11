<?php

namespace App\Enums\Stock;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StockEntryListPurpose: string implements HasColor, HasLabel
{
    case Material_Issue = 'material issue';
    case Material_Receipt = 'material receipt';
    case Material_Transfer = 'material transfer';
    case Material_Transfer_For_Manufacture = 'material transfer for manufacture';
    case Material_Consumption_For_Manufacture = 'material consumption for manufacture';
    case Manufacture = 'manufacture';
    case Repack = 'repack';
    case Send_To_Subcontractor = 'send to subcontractor';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Material_Issue => 'gray',
            self::Material_Receipt => 'gray',
            self::Material_Transfer => 'gray',
            self::Material_Transfer_For_Manufacture => 'gray',
            self::Material_Consumption_For_Manufacture => 'gray',
            self::Manufacture => 'gray',
            self::Repack => 'gray',
            self::Send_To_Subcontractor => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Material_Issue => 'Material Issue',
            self::Material_Receipt => 'Material Receipt',
            self::Material_Transfer => 'Material Transfer',
            self::Material_Transfer_For_Manufacture => 'Material Transfer For Manufacture',
            self::Material_Consumption_For_Manufacture => 'Material Consumption For Manufacture',
            self::Manufacture => 'Manufacture',
            self::Repack => 'Repack',
            self::Send_To_Subcontractor => 'Send To Subcontractor',
        };
    }
}
