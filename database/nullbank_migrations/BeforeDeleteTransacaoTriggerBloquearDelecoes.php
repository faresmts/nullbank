<?php

namespace Database\NullBankMigrations;

class BeforeDeleteTransacaoTriggerBloquearDelecoes implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            -- CREATE TRIGGER trigger_bloquear_delecoes_transacoes
               --  BEFORE DELETE ON transacoes
                -- FOR EACH ROW
            -- BEGIN
               --  SIGNAL SQLSTATE '45000'
                   --  SET MESSAGE_TEXT = 'Deleções nesta tabela são bloqueadas';
            -- END;
        ";
    }
}
