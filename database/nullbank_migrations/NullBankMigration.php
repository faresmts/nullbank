<?php

namespace Database\NullBankMigrations;

interface NullBankMigration
{
    public function migrate(): string;
}
