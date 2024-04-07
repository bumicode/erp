<?php

namespace App\Enums\Stock;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StockEntryStatus: string implements HasColor, HasLabel
{
    case Submitted = 'submitted';
    case Draft = 'draft';
    case Canceled = 'canceled';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Submitted => 'success',
            self::Draft => 'warning',
            self::Canceled => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Submitted => 'Submitted',
            self::Draft => 'Draft',
            self::Canceled => 'Canceled',
        };
    }
}
