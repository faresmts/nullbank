<?php

namespace Database\NullBankMigrations;

class CreateEnderecosTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`enderecos` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `logradouro_tipo_id` INT NOT NULL,
              `logradouro` VARCHAR(45) NULL,
              `numero` VARCHAR(5) NULL,
              `bairro` VARCHAR(45) NULL,
              `cep` CHAR(8) NULL,
              `cidade` VARCHAR(45) NULL,
              `estado` CHAR(2) NULL,
              `created_at` DATETIME NULL,
              `updated_at` DATETIME NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_enderecos_logradouro_tipos1_idx` (`logradouro_tipo_id` ASC) VISIBLE,
              CONSTRAINT `fk_enderecos_logradouro_tipos1`
                FOREIGN KEY (`logradouro_tipo_id`)
                REFERENCES `nullbank`.`logradouro_tipos` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
