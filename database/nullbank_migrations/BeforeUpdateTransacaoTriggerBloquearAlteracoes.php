<?php

namespace Database\NullBankMigrations;

class BeforeUpdateTransacaoTriggerBloquearAlteracoes implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_bloquear_updates_transacoes
                BEFORE UPDATE ON transacoes
                FOR EACH ROW
            BEGIN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Deleções nesta tabela são bloqueadas';
            END;
        ";
    }
}
