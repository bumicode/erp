<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ItemStatus: string implements HasColor, HasIcon, HasLabel
{
    case Enabled = 'enabled';
    case Disabled = 'disabled';
    case Template = 'template';
    case Variant = 'variant';
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Enabled => 'info',
            self::Template => 'warning',
            self::Variant => 'success',
            self::Disabled => 'secondary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Enabled => 'heroicon-m-check-circle',
            self::Disabled => 'heroicon-m-x-circle',
            self::Template => 'heroicon-m-puzzle-piece',
            self::Variant => 'heroicon-m-clipboard-document-check',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Enabled => 'Enabled',
            self::Disabled => 'Disabled',
            self::Template => 'Template',
            self::Variant => 'Variant',
        };
    }
}
