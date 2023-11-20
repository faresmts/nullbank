<?php

namespace Database\NullBankMigrations;

class BeforeInsertContaTriggerGerenteDaMesmaAgencia implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_gerente_da_mesma_agencia_insert
                BEFORE INSERT ON contas
                FOR EACH ROW
            BEGIN
                DECLARE gerente_agencia_id INT;

                SELECT funcionarios.agencia_id
                INTO gerente_agencia_id
                FROM funcionarios
                WHERE funcionarios.id = NEW.gerente_id;

                -- Se o gerente que estamos inserindo é da mesma agência que estamos criando
                IF gerente_agencia_id != NEW.agencia_id THEN
                    SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'O gerente não pertence à agência correspondente da inserção';
                END IF;
            END;
        ";
    }
}
