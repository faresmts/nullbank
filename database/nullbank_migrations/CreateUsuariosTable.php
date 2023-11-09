<?php

namespace Database\NullBankMigrations;

class CreateUsuariosTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`usuarios` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `nome` VARCHAR(45) NULL,
              `sobrenome` VARCHAR(45) NULL,
              `pronomes` ENUM('ele/dele', 'ela/dela', 'neutros') NULL,
              `email` VARCHAR(100) NULL,
              `email_verified_at` TIMESTAMP NULL,
              `password` VARCHAR(100) NULL,
              `endereco_id` INT NOT NULL,
              `sexo` ENUM('M', 'F', 'O') NULL,
              `nascido_em` DATE NULL,
              `remember_token` VARCHAR(100) NULL,
              `created_at` DATETIME NULL,
              `updated_at` DATETIME NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_usuarios_enderecos1_idx` (`endereco_id` ASC) VISIBLE,
              CONSTRAINT `fk_usuarios_enderecos1`
                FOREIGN KEY (`endereco_id`)
                REFERENCES `nullbank`.`enderecos` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
