<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

Enum DocumentTypeEnum: string implements HasLabel, HasColor {
    case ID = 'DNI';
    case FOREIGN_CARD = 'Carnét de Extranjería';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ID => 'info',
            self::FOREIGN_CARD => 'indigo',
        };
    }

    public static function getLabels(): Array {
        return [
            self::ID->value,
            self::FOREIGN_CARD->value
        ];
    }

    public static function isId(string $value): bool {
        return $value === self::ID->value;
    }

    public static function isForeignCard(string $value): bool {
        return $value === self::FOREIGN_CARD->value;
    }
}
