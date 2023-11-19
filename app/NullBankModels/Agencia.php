<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Agencia implements NullBankModel
{
    public function __construct(
        public int $id,
        public string $nome,
        public int $endereco_id,
        public float $montante_salarios,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Agencia
    {
        $query = "
            INSERT INTO `nullbank`.`agencias` (
                `nome`,
                `endereco_id`,
                `montante_salarios`,
                `created_at`
            ) VALUES (
                '{$data['nome']}',
                {$data['endereco_id']},
                '{$data['montante_salarios']}',
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Agencia::first($lastId);
    }

    public static function first(int $id): Agencia
    {
        $query = "
            SELECT * FROM `nullbank`.`agencias` WHERE `agencias`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Agencia(
            $data->id,
            $data->nome,
            $data->endereco_id,
            $data->montante_salarios,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'nome' => $data['nome'] ?? $this->nome,
            'endereco_id' => $data['$this->endereco_id'] ?? $this->endereco_id,
            'montante_salarios' => $data['montante_salarios'] ?? $this->montante_salarios,
        ];

        $query = "
            UPDATE `nullbank`.`agencias`
            SET
              `nome` = '{$updateData['nome']}',
              `endereco_id` = '{$updateData['endereco_id']}',
              `montante_salarios` = '{$updateData['montante_salarios']}',
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Agencia::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`agencias`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }
}
