<?php

namespace Database\NullBankMigrations;

class AfterUpdateFuncionarioTriggerMontanteSalarios implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TRIGGER trigger_update_montante_salarios_update AFTER UPDATE ON funcionarios
                FOR EACH ROW
            BEGIN
                DECLARE total_salarios DECIMAL(10,2);

                SELECT SUM(salario) INTO total_salarios
                FROM funcionarios
                WHERE agencia_id = NEW.agencia_id;

                UPDATE agencias
                SET montante_salarios = total_salarios
                WHERE id = NEW.agencia_id;
            END;
        ";
    }
}
