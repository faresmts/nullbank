<?php

namespace Database\NullBankMigrations;

class AlterClienteContaTableAddConstraint implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            ALTER TABLE `nullbank`.`dependentes`
            ADD CONSTRAINT `max5Dependentes` CHECK
                ((SELECT COUNT(*) FROM dependentes WHERE funcionario_id = funcionarios.id) <= 5);
        ";
    }
}
