<?php

namespace Database\NullBankMigrations;

class BeforeInsertDependenteTriggerMaximoCincoDependentes implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_no_maximo_5_dependentes_insert
                BEFORE INSERT ON dependentes
                FOR EACH ROW
            BEGIN
                DECLARE total_dependentes INT;

                -- Contar o número de dependentes para o funcionário
                SELECT COUNT(*) INTO total_dependentes
                FROM dependentes
                WHERE funcionario_id = NEW.funcionario_id;

                -- Se a contagem for maior que 5, impedir a inserção
                IF total_dependentes >= 5 THEN
                    SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'O funcionário já possui o número máximo de dependentes permitido (5)';
                END IF;
            END;
        ";
    }
}
