<?php

namespace App\NullBankModels;

use Illuminate\Support\Facades\DB;

class Permissao implements NullBankModel
{
    public function __construct(
        public int $id,
        public string $nome,
    ){}

    public static function create(array $data): Permissao
    {
        $query = "
            INSERT INTO `nullbank`.`permissoes` (
                `nome`
            ) VALUES (
                '{$data['nome']}'
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Permissao::first($lastId);
    }

    public static function first(int $id): Permissao
    {
        $query = "
            SELECT * FROM `nullbank`.`permissoes` WHERE `permissoes`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Permissao(
            $data->id,
            $data->nome,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'nome' => $data['nome'] ?? $this->nome,
        ];

        $query = "
            UPDATE `nullbank`.`permissoes`
            SET
              `nome` = '{$updateData['nome']}'
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Permissao::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`permissoes`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }
}
