<?php

namespace App\Enums;

enum ProductType: string
{
    case Digital = 'digital';
    case Physical = 'physical';
    case Program = 'program';

    public function label(): string
    {
        return match ($this) {
            self::Digital => __('Цифровой'),
            self::Physical => __('Физический'),
            self::Program => __('Программа'),
        };
    }

    public function isDigital(): bool
    {
        return in_array($this, [self::Digital, self::Program]);
    }
}
