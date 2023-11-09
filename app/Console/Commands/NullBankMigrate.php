<?php

namespace App\Console\Commands;

use Database\NullBankMigrations\Migrator;
use Database\NullBankMigrations\NullBankMigration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PHPUnit\Event\Runtime\PHP;

class NullBankMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nullbank-migrate';

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
