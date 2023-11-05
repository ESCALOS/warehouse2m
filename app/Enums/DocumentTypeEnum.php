<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

Enum DocumentTypeEnum: string implements HasLabel, HasColor {
    case ID = 'DNI';
    case FOREIGN_CARD = 'Carnét de Extranjería';

    /**
     * Devuelve el tipo de documento
     */
    public function getLabel(): ?string
    {
        return $this->value;
    }

    /**
     * Devuelve los tipos de documento
     * @return Array Valores del tipo de documento
     */
    public static function getLabels(): Array {
        return [
            self::ID->value,
            self::FOREIGN_CARD->value
        ];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ID => 'info',
            self::FOREIGN_CARD => 'indigo',
        };
    }

    /**
     * Obtiene el tipo de documento según la longitud ingresada
     * @param int $length Longitud del número de documento
     * @return DocumentTypeEnum Tipo de documento
     */
    public static function getCase(int $length): DocumentTypeEnum {
        return match ($length) {
            8 => self::ID,
            12 => self::FOREIGN_CARD
        };
    }

    /**
     * Devuelve las longitudes que debe tener el número de documento
     * @return Array Longitudes aceptadas
     */
    public static function acceptedLengths(): Array {
        return [8,12];
    }

    /**
     * Devueve la longitud del tipo de documento
     * @return int Longitud del tipo de documento
     */
    public function numberDigits(): int {
        return match ($this) {
            self::ID => 8,
            self::FOREIGN_CARD => 12
        };
    }

    /**
     * Valida si el número de documento tiene la longitud correcta según el tipo
     * @param int $length Longitud del número de documento
     */
    public function validateNumberDigits(int $length): bool {
        return $this->numberDigits() == $length;
    }
}
