<?php

namespace Database\NullBankMigrations;

class BeforeUpdateContaTriggerTiposDeConta implements NullBankMigration
{

    public function migrate(): string
    {
        return "
        CREATE TRIGGER trigger_validar_tipos_de_contas_update
            BEFORE UPDATE ON contas
            FOR EACH ROW
        BEGIN
            IF NEW.tipo = 'CC' AND NEW.aniversario IS NULL THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Inserção em contas não permitida: quebra de regra ao inserir Conta Corrente com aniversario nulo';
            END IF;

            IF NEW.tipo = 'CC' AND NEW.aniversario IS NOT NULL AND
               (NEW.limite_credito > 0 OR NEW.credito_usado > 0 OR NEW.juros > 0) THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Inserção em contas não permitida: quebra de regra ao inserir Conta Corrente com campos não permitidos';
            END IF;

            IF NEW.tipo = 'CP' AND (NEW.juros <= 0 OR NEW.juros IS NULL) THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Inserção em contas não permitida: quebra de regra ao inserir Conta Poupança com juros menor ou igual a zero';
            END IF;

            IF NEW.tipo = 'CP' AND NEW.juros > 0 AND
               (NEW.limite_credito > 0 OR NEW.credito_usado > 0 OR NEW.aniversario IS NOT NULL) THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Inserção em contas não permitida: quebra de regra ao inserir Conta Poupança com campos não permitidos';
            END IF;

            IF NEW.tipo = 'CE' AND NEW.limite_credito > 0 AND
               (NEW.aniversario IS NOT NULL OR NEW.juros > 0) THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Inserção em contas não permitida: quebra de regra ao inserir Conta Especial com campos não permitidos';
            END IF;

            IF NEW.tipo = 'CE' AND NEW.limite_credito <= 0 THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Inserção em contas não permitida: quebra de regra ao inserir Conta Especial com limites de credito menor ou igual a zero';
            END IF;
        END;
        ";
    }
}
