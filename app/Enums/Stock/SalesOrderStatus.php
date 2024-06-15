<?php

namespace App\Enums\Stock;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SalesOrderStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case OnHold = 'on hold';
    case ToDeliverAndBill = 'to deliver and bill';
    case ToBill = 'to bill';
    case ToDeliver = 'to deliver';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Closed = 'closed';


    public static function toSelectArray(): array
    {
        return [
            self::Draft->value => self::Draft->getLabel(),
            self::OnHold->value => self::OnHold->getLabel(),
            self::ToDeliverAndBill->value => self::ToDeliverAndBill->getLabel(),
            self::ToBill->value => self::ToBill->getLabel(),
            self::ToDeliver->value => self::ToDeliver->getLabel(),
            self::Completed->value => self::Completed->getLabel(),
            self::Cancelled->value => self::Cancelled->getLabel(),
            self::Closed->value => self::Closed->getLabel(),
        ];
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft, self::Closed => 'gray',
            self::OnHold => 'yellow',
            self::ToDeliverAndBill, self::ToBill, self::ToDeliver => 'blue',
            self::Completed => 'green',
            self::Cancelled => 'red',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::OnHold => 'On Hold',
            self::ToDeliverAndBill => 'To Deliver and Bill',
            self::ToBill => 'To Bill',
            self::ToDeliver => 'To Deliver',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::Closed => 'Closed',
        };
    }
}
