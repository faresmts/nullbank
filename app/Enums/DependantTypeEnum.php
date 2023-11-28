<?php

namespace App\Enums;

use InvalidArgumentException;

enum DependantTypeEnum: string
{
    case FILHO = 'F';
    case CONJUGE = 'C';
    case GENITOR = 'G';

    public static function toText($type): string
    {
        return match ($type) {
            self::FILHO->value => 'Filho',
            self::CONJUGE->value => 'Cônjuge',
            self::GENITOR->value => 'Genitor',
            default => throw new InvalidArgumentException('Tipo de dependente inválido')
        };
    }

    public static function toArray(): array
    {
        return [
            self::FILHO->value => 'Filho',
            self::CONJUGE->value => 'Conjuge',
            self::GENITOR->value => 'Genitor',
        ];
    }
}
