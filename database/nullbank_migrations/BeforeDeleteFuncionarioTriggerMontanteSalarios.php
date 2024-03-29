<?php

namespace Database\NullBankMigrations;

class BeforeDeleteFuncionarioTriggerMontanteSalarios implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_update_montante_salarios_delete
                BEFORE DELETE ON funcionarios
                FOR EACH ROW
            BEGIN
                DECLARE total_salarios DECIMAL(10,2);

                SELECT SUM(salario) INTO total_salarios
                FROM funcionarios
                WHERE agencia_id = OLD.agencia_id;

                UPDATE agencias
                SET montante_salarios = total_salarios - OLD.salario
                WHERE id = OLD.agencia_id;
            END;
        ";
    }
}
