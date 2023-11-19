<?php

namespace Database\NullBankMigrations;

class CreateAgenciasTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`agencias` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `nome` VARCHAR(45) NOT NULL,
              `endereco_id` INT NOT NULL,
              `montante_salarios` DECIMAL(10,2) NOT NULL DEFAULT 0,
              `created_at` DATETIME NULL,
              `updated_at` DATETIME NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_agencias_enderecos1_idx` (`endereco_id` ASC) VISIBLE,
              CONSTRAINT `fk_agencias_enderecos1`
                FOREIGN KEY (`endereco_id`)
                REFERENCES `nullbank`.`enderecos` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
