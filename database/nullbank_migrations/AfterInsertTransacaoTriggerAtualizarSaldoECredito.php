<?php

namespace Database\NullBankMigrations;

class AfterInsertTransacaoTriggerAtualizarSaldoECredito implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_atualizar_saldo_insert
                AFTER INSERT ON transacoes
                FOR EACH ROW
            BEGIN
                IF NEW.origem = 'Saldo' THEN
                    UPDATE contas
                    SET contas.saldo = contas.saldo + NEW.valor
                    WHERE id = NEW.conta_id;
                END IF;

                IF NEW.origem = 'Credito' THEN
                    UPDATE contas
                    SET contas.limite_credito = contas.limite_credito - NEW.valor,
                        contas.credito_usado = contas.credito_usado + NEW.valor
                    WHERE id = NEW.conta_id;
                END IF;
            END;
        ";
    }
}
