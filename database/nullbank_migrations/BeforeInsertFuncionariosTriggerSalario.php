<?php

namespace Database\NullBankMigrations;

class BeforeInsertFuncionariosTriggerSalario implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_salario_base
                BEFORE INSERT ON funcionarios
                FOR EACH ROW
            BEGIN

                IF NEW.salario < 2286 THEN
                    SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'Salário deve ser maior do que o base (2.286,00)';
                END IF;
            END;
        ";
    }
}
