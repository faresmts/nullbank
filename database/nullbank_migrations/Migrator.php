<?php

namespace Database\NullBankMigrations;

class Migrator
{
    public static function classes(): array
    {
        return [
            // Tables
            CreateLogradouroTiposTable::class,
            CreateEnderecosTable::class,
            CreateAgenciasTable::class,
            CreateUsuariosTable::class,
            CreateFuncionariosTable::class,
            CreateDependentesTable::class,
            CreateClientesTable::class,
            CreateContasTable::class,
            CreateTransacoesTable::class,
            CreatePermissoesTable::class,
            CreateUsuarioPermissaoTable::class,
            CreateTelefonesTable::class,
            CreateEmailsTable::class,
            CreateClienteContaTable::class,

            // Triggers
            BeforeInsertDependenteTriggerIdade::class,
            BeforeInsertDependenteTriggerMaximoCincoDependentes::class,

            BeforeInsertContaTriggerGerenteDaMesmaAgencia::class,
            BeforeInsertContaTriggerTiposDeConta::class,
            BeforeUpdateContaTriggerTiposDeConta::class,

            BeforeInsertFuncionariosTriggerSalario::class,
            AfterInsertFuncionarioTriggerMontanteSalarios::class,
            AfterUpdateFuncionarioTriggerMontanteSalarios::class,
            AfterDeleteFuncionarioTriggerMontanteSalarios::class,

            AfterInsertTransacaoTriggerAtualizarSaldoECredito::class,
            BeforeInsertTransacaoTriggerSaldoECreditoNaoPodemFicarNegativados::class,
            BeforeDeleteTransacaoTriggerBloquearDelecoes::class,
            BeforeUpdateTransacaoTriggerBloquearAlteracoes::class,

            BeforeInsertClienteContaTriggerNoMaximoDoisClientesPorConta::class,
            BeforeInsertClienteContaTriggerNoMaximoUmaContaPorAgencia::class,
        ];
    }
}
