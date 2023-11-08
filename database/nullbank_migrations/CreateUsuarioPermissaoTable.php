<?php

namespace Database\NullBankMigrations;

class CreateUsuarioPermissaoTable implements NullBankMigration
{

    public function migrate(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS `nullbank`.`usuario_permissao` (
              `usuarios_id` INT NOT NULL,
              `permissoes_id` INT NOT NULL,
              PRIMARY KEY (`usuarios_id`, `permissoes_id`),
              INDEX `fk_usuarios_has_permissoes_permissoes1_idx` (`permissoes_id` ASC) VISIBLE,
              INDEX `fk_usuarios_has_permissoes_usuarios1_idx` (`usuarios_id` ASC) VISIBLE,
              CONSTRAINT `fk_usuarios_has_permissoes_usuarios1`
                FOREIGN KEY (`usuarios_id`)
                REFERENCES `nullbank`.`usuarios` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_usuarios_has_permissoes_permissoes1`
                FOREIGN KEY (`permissoes_id`)
                REFERENCES `nullbank`.`permissoes` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
        ";
    }
}
