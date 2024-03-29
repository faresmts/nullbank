<?php

namespace Database\NullBankMigrations;

class CreateTransacoesTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`transacoes` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `conta_id` INT NOT NULL,
              `origem` ENUM('Saldo', 'Credito') NOT NULL,
              `tipo` ENUM('Saque', 'Deposito', 'Pagamento', 'Estorno', 'Transferencia') NOT NULL,
              `valor` DECIMAL(12,2) NOT NULL,
              `created_at` DATETIME NULL,
              `updated_at` DATETIME NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_transacoes_contas1_idx` (`conta_id` ASC) VISIBLE,
              CONSTRAINT `fk_transacoes_contas1`
                FOREIGN KEY (`conta_id`)
                REFERENCES `nullbank`.`contas` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
