<?php

namespace Database\NullBankMigrations;

class AlterFuncionariosTableAddConstraint implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            ALTER TABLE `nullbank`.`funcionarios`
            ADD CONSTRAINT salarioBase CHECK (salario >= 2286);
        ";
    }
}
