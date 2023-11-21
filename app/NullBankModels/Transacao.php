<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Transacao implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $conta_id,
        public string $origem,
        public string $tipo,
        public float $valor,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Transacao
    {
        $query = "
            INSERT INTO `nullbank`.`transacoes` (
                `conta_id`,
                `origem`,
                `tipo`,
                `valor`,
                `created_at`
            ) VALUES (
                {$data['conta_id']},
                '{$data['origem']}',
                '{$data['tipo']}',
                {$data['valor']},
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Transacao::first($lastId);
    }

    public static function first(int $id): Transacao
    {
        $query = "
            SELECT * FROM `nullbank`.`transacoes` WHERE `transacoes`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Transacao(
            $data->id,
            $data->conta_id,
            $data->origem,
            $data->tipo,
            $data->valor,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'conta_id' => $data['conta_id'] ?? $this->conta_id,
            'origem' => $data['origem'] ?? $this->origem,
            'tipo' => $data['tipo'] ?? $this->tipo,
            'valor' => $data['valor'] ?? $this->valor,
        ];

        $query = "
            UPDATE `nullbank`.`transacoes`
            SET
              `conta_id` = {$updateData['conta_id']},
              `origem` = '{$updateData['origem']}',
              `tipo` = '{$updateData['tipo']}',
              `valor` = {$updateData['valor']},
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Transacao::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`transacoes`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }
}
