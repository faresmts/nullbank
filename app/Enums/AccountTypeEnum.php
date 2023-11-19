<?php

namespace App\Enums;

enum AccountTypeEnum: string
{
    case CONTA_CORRENTE = 'CC';
    case CONTA_POUPANCA = 'CP';
    case CONTA_ESPECIAL = 'CE';
}
