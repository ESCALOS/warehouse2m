<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

Enum MovementTypeEnum: string implements HasLabel, HasColor {
    case INPUT = 'Ingreso';
    case OUTPUT = 'Salida';

    public function getLabel(): ?string
    {
        return match($this) {
            self::INPUT => 'Ingreso',
            self::OUTPUT => 'Salida'
        };
    }

    public static function getLabels(): Array {
        return [
            self::INPUT->value,
            self::OUTPUT->value
        ];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::INPUT => 'success',
            self::OUTPUT => 'danger',
        };
    }

    public static function isInput(string $value): bool {
        return $value === self::INPUT;
    }

    public static function isOutput(string $value): bool {
        return $value === self::OUTPUT;
    }
}
