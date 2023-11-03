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

    public function numberDigits(): int {
        return match ($this) {
            self::ID => 8,
            self::FOREIGN_CARD => 12
        };
    }

    public function validateNumberDigits(int $length): bool {
        return $this->numberDigits() == $length;
    }
}
