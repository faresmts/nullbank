<?php

namespace App\Enums;

use InvalidArgumentException;

enum TransactionTypeEnum: string
{
    case DEPOSITO = 'Deposito';
    case SAQUE = 'Saque';
    case TRANSFERENCIA = 'Transferencia';
    case ESTORNO = 'Estorno';
    case PAGAMENTO = 'Pagamento';

    public static function toText(string $type): string
    {
        return match ($type) {
            self::DEPOSITO->value => 'Depósito',
            self::SAQUE->value => 'Saque',
            self::TRANSFERENCIA->value => 'Transferência',
            self::ESTORNO->value => 'Estorno',
            self::PAGAMENTO->value => 'Pagamento',
            default => throw new InvalidArgumentException('Tipo de transação inválido')
        };
    }

    public static function toArray(): array
    {
        return [
            self::DEPOSITO->value => 'Depósito',
            self::SAQUE->value => 'Saque',
            self::TRANSFERENCIA->value => 'Transferência',
            self::ESTORNO->value => 'Estorno',
            self::PAGAMENTO->value => 'Pagamento',
        ];
    }
}
