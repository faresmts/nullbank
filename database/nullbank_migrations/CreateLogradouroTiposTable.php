<?php

namespace Database\NullBankMigrations;

class CreateLogradouroTiposTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`logradouro_tipos` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `nome` VARCHAR(45) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
        ";
    }
}
