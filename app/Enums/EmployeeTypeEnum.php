<?php

namespace App\Enums;


use InvalidArgumentException;

enum EmployeeTypeEnum: string
{
    case GERENTE = 'G';
    case CAIXA = 'C';
    case ATENDENTE = 'A';

    public static function toText($type): string
    {
        return match ($type) {
            self::GERENTE->value => 'Gerente',
            self::CAIXA->value => 'Caixa',
            self::ATENDENTE->value => 'Atendente',
            default => throw new InvalidArgumentException('Invalid employee type')
        };
    }

    public static function toArray(): array
    {
        return [
            self::GERENTE->value => 'Gerente',
            self::CAIXA->value => 'Caixa',
            self::ATENDENTE->value => 'Atendente',
        ];
    }
}
