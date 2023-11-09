<?php

namespace Database\NullBankMigrations;

class CreateDependentesTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`dependentes` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `funcionario_id` INT NOT NULL,
              `nome` VARCHAR(100) NULL,
              `nascido_em` DATE NULL,
              `parentesco` ENUM('F', 'C', 'G') NULL,
              `idade` INT NULL,
              `created_at` DATETIME NULL,
              `updated_at` DATETIME NULL,
              PRIMARY KEY (`id`, `funcionario_id`),
              INDEX `fk_dependentes_funcionarios1_idx` (`funcionario_id` ASC) VISIBLE,
              UNIQUE INDEX `nome_UNIQUE` (`nome` ASC) VISIBLE,
              CONSTRAINT `fk_dependentes_funcionarios1`
                FOREIGN KEY (`funcionario_id`)
                REFERENCES `nullbank`.`funcionarios` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
