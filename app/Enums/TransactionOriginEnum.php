<?php

namespace App\Enums;

use InvalidArgumentException;

enum TransactionOriginEnum: string
{
    case SALDO = 'Saldo';
    case CREDITO = 'Credito';

    public static function toText(string $type): string
    {
        return match ($type) {
            self::SALDO->value => 'Saldo',
            self::CREDITO->value => 'Crédito',
            default => throw new InvalidArgumentException('Tipo de origem de transação inválido')
        };
    }

    public static function toArray(): array
    {
        return [
            self::SALDO->value => 'Saldo',
            self::CREDITO->value => 'Crédito',
        ];
    }
}
