<?php

namespace Database\NullBankMigrations;

class BeforeInsertClienteContaTriggerNoMaximoUmaContaPorAgencia implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_verifica_agencia_conta_cliente
                BEFORE INSERT ON cliente_conta
                FOR EACH ROW
            BEGIN
                DECLARE total_contas INT;

                SELECT COUNT(*)
                INTO total_contas
                FROM cliente_conta
                WHERE cliente_cpf = NEW.cliente_cpf AND agencia_id = NEW.agencia_id;

                -- Se a contagem for maior que 0, impedir a inserção
                IF total_contas > 0 THEN
                    SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'A agência já possui uma conta associada ao cliente';
                END IF;
            END;
        ";
    }
}
