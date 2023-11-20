<?php

namespace Database\NullBankMigrations;

class CreateEmailsTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`emails` (
              `endereco` VARCHAR(60) NOT NULL,
              `clientes_cpf` CHAR(11) NOT NULL,
              `descricao` VARCHAR(100) NULL,
              PRIMARY KEY (`endereco`, `clientes_cpf`),
              INDEX `fk_emails_clientes1_idx` (`clientes_cpf` ASC) VISIBLE,
              CONSTRAINT `fk_emails_clientes1`
                FOREIGN KEY (`clientes_cpf`)
                REFERENCES `nullbank`.`clientes` (`cpf`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
