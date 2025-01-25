<?php

namespace App\Traits;

trait InteractingWithEnums
{
    /**
    * Get all ENUM names
    *
    * @return array
    */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

        /**
    * Get all ENUM values
    *
    * @return array
    */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}