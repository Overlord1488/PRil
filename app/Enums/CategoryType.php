<?php

namespace App\Enums;

enum CategoryType: string
{
    case Programs = 'programs';
    case Nutrition = 'nutrition';
    case Equipment = 'equipment';

    public function label(): string
    {
        return match ($this) {
            self::Programs => __('Программы'),
            self::Nutrition => __('Питание'),
            self::Equipment => __('Инвентарь'),
        };
    }
}
