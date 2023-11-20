<?php

namespace Database\NullBankMigrations;

class CreateClientesTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`clientes` (
              `cpf` CHAR(11) NOT NULL,
              `usuario_id` INT NOT NULL,
              `rg` VARCHAR(15) NULL,
              `rg_emitido_por` VARCHAR(45) NULL,
              `uf` CHAR(2) NULL,
              `created_at` DATETIME NULL,
              `updated_at` DATETIME NULL,
              PRIMARY KEY (`cpf`),
              INDEX `fk_clientes_usuarios1_idx` (`usuario_id` ASC) VISIBLE,
              UNIQUE INDEX `rg_UNIQUE` (`rg` ASC) VISIBLE,
              CONSTRAINT `fk_clientes_usuarios1`
                FOREIGN KEY (`usuario_id`)
                REFERENCES `nullbank`.`usuarios` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
