<?php

namespace App\NullBankModels;

interface NullBankModel
{
    public static function create(array $data): NullBankModel;
    public static function first(int $id): NullBankModel;
    public function update(array $data): NullBankModel;
    public function delete(): int;
}
