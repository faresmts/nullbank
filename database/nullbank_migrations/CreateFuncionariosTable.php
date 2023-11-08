<?php

namespace Database\NullBankMigrations;

class CreateFuncionariosTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`funcionarios` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `usuario_id` INT NOT NULL,
              `agencia_id` INT NOT NULL,
              `matricula` VARCHAR(45) NOT NULL,
              `cargo` ENUM('G', 'A', 'C') NULL,
              `salario` DECIMAL(8,2) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_funcionarios_usuarios_idx` (`usuario_id` ASC) VISIBLE,
              INDEX `fk_funcionarios_agencias1_idx` (`agencia_id` ASC) VISIBLE,
              UNIQUE INDEX `matricula_UNIQUE` (`matricula` ASC) VISIBLE,
              CONSTRAINT `fk_funcionarios_usuarios`
                FOREIGN KEY (`usuario_id`)
                REFERENCES `nullbank`.`usuarios` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_funcionarios_agencias1`
                FOREIGN KEY (`agencia_id`)
                REFERENCES `nullbank`.`agencias` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
