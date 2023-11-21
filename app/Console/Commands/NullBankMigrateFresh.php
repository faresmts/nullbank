<?php

namespace App\Console\Commands;

use Database\NullBankMigrations\Migrator;
use Database\NullBankMigrations\NullBankMigration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NullBankMigrateFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nullbank-migrate-fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $dropQueries = [
            "DROP TABLE IF EXISTS cliente_conta",
            "DROP TABLE IF EXISTS dependentes",
            "DROP TABLE IF EXISTS emails",
            "DROP TABLE IF EXISTS telefones",
            "DROP TABLE IF EXISTS clientes",
            "DROP TABLE IF EXISTS transacoes",
            "DROP TABLE IF EXISTS contas",
            "DROP TABLE IF EXISTS funcionarios",
            "DROP TABLE IF EXISTS agencias",
            "DROP TABLE IF EXISTS usuario_permissao",
            "DROP TABLE IF EXISTS permissoes",
            "DROP TABLE IF EXISTS usuarios",
            "DROP TABLE IF EXISTS enderecos",
            "DROP TABLE IF EXISTS logradouro_tipos",
        ];

        foreach ($dropQueries as $drop) {
            DB::statement($drop);
        }

        $migrationClasses = Migrator::classes();

        foreach ($migrationClasses as $migrationClass) {
            /**
             * @var NullBankMigration $migration
             */
            $migration = app($migrationClass);

            $query = $migration->migrate();

            echo $query . PHP_EOL;

            DB::statement($query);
        }
    }
}
