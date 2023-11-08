<?php

namespace Database\NullBankMigrations;

class CreateAgenciaContaClienteTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`agencia_conta_cliente` (
              `agencia_id` INT NOT NULL,
              `conta_id` INT NOT NULL,
              `cliente_cpf` CHAR(11) NOT NULL,
              PRIMARY KEY (`agencia_id`, `conta_id`, `cliente_cpf`),
              INDEX `fk_agencia_conta_has_clientes_clientes1_idx` (`cliente_cpf` ASC) VISIBLE,
              INDEX `fk_agencia_conta_has_clientes_agencia_conta1_idx` (`agencia_id` ASC, `conta_id` ASC) VISIBLE,
              CONSTRAINT `fk_agencia_conta_has_clientes_agencia_conta1`
                FOREIGN KEY (`agencia_id` , `conta_id`)
                REFERENCES `nullbank`.`agencia_conta` (`agencia_id` , `conta_id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_agencia_conta_has_clientes_clientes1`
                FOREIGN KEY (`cliente_cpf`)
                REFERENCES `nullbank`.`clientes` (`cpf`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
