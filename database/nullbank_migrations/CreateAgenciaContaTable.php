<?php

namespace Database\NullBankMigrations;

class CreateAgenciaContaTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`agencia_conta` (
              `agencia_id` INT NOT NULL,
              `conta_id` INT NOT NULL,
              PRIMARY KEY (`agencia_id`, `conta_id`),
              INDEX `fk_agencias_has_contas_contas1_idx` (`conta_id` ASC) VISIBLE,
              INDEX `fk_agencias_has_contas_agencias1_idx` (`agencia_id` ASC) VISIBLE,
              CONSTRAINT `fk_agencias_has_contas_agencias1`
                FOREIGN KEY (`agencia_id`)
                REFERENCES `nullbank`.`agencias` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_agencias_has_contas_contas1`
                FOREIGN KEY (`conta_id`)
                REFERENCES `nullbank`.`contas` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
