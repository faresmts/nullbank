<?php

namespace Database\NullBankMigrations;

class BeforeInsertTransacaoTriggerSaldoECreditoNaoPodemFicarNegativados implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_saldo_e_credito_nao_podem_ficar_negativados
                BEFORE INSERT ON transacoes
                FOR EACH ROW
            BEGIN
                DECLARE saldo_conta DECIMAL(12,2);
                DECLARE limite_credito_conta DECIMAL(10,2);

                SELECT contas.saldo
                INTO saldo_conta
                FROM contas
                WHERE contas.id = NEW.conta_id;

                SELECT contas.limite_credito
                INTO limite_credito_conta
                FROM contas
                WHERE contas.id = NEW.conta_id;

                IF NEW.valor > saldo_conta AND NEW.origem = 'Saldo' THEN
                    SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'O valor não pode ser maior do que o saldo disponível';
                END IF;

                IF NEW.valor > limite_credito_conta AND NEW.origem = 'Credito' THEN
                    SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'O valor não pode ser maior do que o limite de crédito disponível';
                END IF;
            END;
        ";
    }
}
