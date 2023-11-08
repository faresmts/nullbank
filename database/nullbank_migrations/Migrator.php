<?php

namespace Database\NullBankMigrations;

class Migrator
{
    public static function classes(): array
    {
        return [
            CreateLogradouroTiposTable::class,
            CreateEnderecosTable::class,
            CreateAgenciasTable::class,
            CreateUsuariosTable::class,
            CreateFuncionariosTable::class,
            CreateDependentesTable::class,
            CreateClientesTable::class,
            CreateContasTable::class,
            CreateAgenciaContaTable::class,
            CreateAgenciaContaClienteTable::class,
            CreateTransacoesTable::class,
            CreatePermissoesTable::class,
            CreateUsuarioPermissaoTable::class
        ];
    }
}
