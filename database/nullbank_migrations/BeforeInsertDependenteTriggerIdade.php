<?php

namespace Database\NullBankMigrations;

class BeforeInsertDependenteTriggerIdade implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_idade_dependentes_insert
                BEFORE INSERT ON dependentes
                FOR EACH ROW
            BEGIN
                -- Calcular a idade
                SET NEW.idade = TIMESTAMPDIFF(YEAR, NEW.nascido_em, NOW());
            END;
        ";
    }
}
