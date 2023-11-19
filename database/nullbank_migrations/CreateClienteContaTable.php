<?php

namespace Database\NullBankMigrations;

class CreateClienteContaTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`cliente_conta` (
              `conta_id` INT NOT NULL,
              `cliente_cpf` CHAR(11) NOT NULL,
              PRIMARY KEY (`conta_id`, `cliente_cpf`),
              INDEX `fk_contas_has_clientes_clientes1_idx` (`cliente_cpf` ASC) VISIBLE,
              INDEX `fk_contas_has_clientes_contas1_idx` (`conta_id` ASC) VISIBLE,
              CONSTRAINT `fk_contas_has_clientes_contas1`
                FOREIGN KEY (`conta_id`)
                REFERENCES `nullbank`.`contas` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_contas_has_clientes_clientes1`
                FOREIGN KEY (`cliente_cpf`)
                REFERENCES `nullbank`.`clientes` (`cpf`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
