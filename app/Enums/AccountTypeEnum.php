<?php

namespace App\Enums;

use InvalidArgumentException;

enum AccountTypeEnum: string
{
    case CONTA_CORRENTE = 'CC';
    case CONTA_POUPANCA = 'CP';
    case CONTA_ESPECIAL = 'CE';

    public static function toText($type): string
    {
        return match ($type) {
            self::CONTA_CORRENTE->value => 'Conta Corrente',
            self::CONTA_POUPANCA->value => 'Conta Poupança',
            self::CONTA_ESPECIAL->value => 'Conta Especial',
            default => throw new InvalidArgumentException('Tipo de conta inválido')
        };
    }

    public static function toArray(): array
    {
        return [
            self::CONTA_CORRENTE->value => 'Conta Corrente',
            self::CONTA_POUPANCA->value => 'Conta Poupança',
            self::CONTA_ESPECIAL->value => 'Conta Especial',
        ];
    }
}
