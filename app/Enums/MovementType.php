<?php
namespace App\Enums;

class MovementType {

    const INGRESO = 'i';

    const SALIDA = 's';

    /**
     * Devuelve los valores de los tipo de de movimiento
     */
    public static function getValues(): Array {
        return [
            self::INGRESO,
            self::SALIDA
        ];
    }
}
