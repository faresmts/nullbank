<?php

namespace Database\NullBankMigrations;

class BeforeInsertClienteContaTriggerNoMaximoDoisClientesPorConta implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_no_maximo_2_clientes_por_conta
                BEFORE INSERT ON cliente_conta
                FOR EACH ROW
            BEGIN
                DECLARE total_clientes INT;

                -- Contar o número de clientes para a conta que estamos tentando inserir
                SELECT COUNT(*) INTO total_clientes
                FROM cliente_conta
                WHERE conta_id = NEW.conta_id;

                -- Se a contagem for maior que 2, impedir a inserção
                IF total_clientes >= 2 THEN
                    SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'A conta já possui o número máximo de clientes permitido (2)';
                END IF;
            END;
        ";
    }
}
