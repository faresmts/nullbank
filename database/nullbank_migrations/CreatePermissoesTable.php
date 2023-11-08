<?php

namespace Database\NullBankMigrations;

class CreatePermissoesTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`permissoes` (
              `id` INT NOT NULL,
              `nome` VARCHAR(100) NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
        ";
    }
}
