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
            "DROP TABLE cliente_conta",
            "DROP TABLE dependentes",
            "DROP TABLE emails",
            "DROP TABLE telefones",
            "DROP TABLE clientes",
            "DROP TABLE transacoes",
            "DROP TABLE contas",
            "DROP TABLE funcionarios",
            "DROP TABLE agencias",
            "DROP TABLE usuario_permissao",
            "DROP TABLE permissoes",
            "DROP TABLE usuarios",
            "DROP TABLE enderecos",
            "DROP TABLE logradouro_tipos",
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
