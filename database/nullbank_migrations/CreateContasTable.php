<?php

namespace Database\NullBankMigrations;

class CreateContasTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`contas` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `gerente_id` INT NOT NULL,
              `saldo` DECIMAL(12,2) NULL DEFAULT 0,
              `senha` VARCHAR(45) NULL,
              `tipo` ENUM('CC', 'CP', 'CE') NULL,
              `juros` DECIMAL(5,2) NULL,
              `limite_credito` DECIMAL(10,2) NULL,
              `aniversario` DATE NULL,
              `created_at` DATETIME NULL,
              `updated_at` DATETIME NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_contas_funcionarios1_idx` (`gerente_id` ASC) VISIBLE,
              CONSTRAINT `fk_contas_funcionarios1`
                FOREIGN KEY (`gerente_id`)
                REFERENCES `nullbank`.`funcionarios` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
