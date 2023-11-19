<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Conta implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $gerente_id,
        public int $agencia_id,
        public float $saldo,
        public string $senha,
        public string $tipo,
        public float|null $juros,
        public float|null $limite_credito,
        public Carbon|string|null $aniversario,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Conta
    {
        $query = "
            INSERT INTO `nullbank`.`contas` (
                `gerente_id`,
                `agencia_id`,
                `saldo`,
                `senha`,
                `tipo`,
                `juros`,
                `limite_credito`,
                `aniversario`,
                `created_at`
            ) VALUES (
                {$data['gerente_id']},
                {$data['agencia_id']},
                '{$data['saldo']}',
                '{$data['senha']}',
                '{$data['tipo']}',
                " . ($data['juros'] ? "'{$data['juros']}'" : 'NULL') . ",
                " . ($data['limite_credito'] ? "'{$data['limite_credito']}'" : 'NULL') . ",
                " . ($data['aniversario'] ? "'{$data['aniversario']}'" : 'NULL') . ",
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Conta::first($lastId);
    }

    public static function first(int $id): Conta
    {
        $query = "
            SELECT * FROM `nullbank`.`contas` WHERE `contas`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Conta(
            $data->id,
            $data->gerente_id,
            $data->agencia_id,
            $data->saldo,
            $data->senha,
            $data->tipo,
            $data->juros,
            $data->limite_credito,
            $data->aniversario,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'gerente_id' => $data['gerente_id'] ?? $this->gerente_id,
            'agencia_id' => $data['agencia_id'] ?? $this->agencia_id,
            'saldo' => $data['saldo'] ?? $this->saldo,
            'senha' => $data['senha'] ?? $this->senha,
            'tipo' => $data['tipo'] ?? $this->tipo,
            'juros' => $data['juros'] ?? $this->juros,
            'limite_credito' => $data['limite_credito'] ?? $this->limite_credito,
            'aniversario' => $data['aniversario'] ?? $this->aniversario,
        ];

        $query = "
            UPDATE `nullbank`.`contas`
            SET
              `gerente_id` = '{$updateData['gerente_id']}',
              `agencia_id` = '{$updateData['agencia_id']}',
              `saldo` = '{$updateData['saldo']}',
              `senha` = '{$updateData['senha']}',
              `tipo` = '{$updateData['tipo']}',
              `juros` = " . ($updateData['juros'] ? "'{$updateData['juros']}'" : 'NULL') . ",
              `limite_credito` = " . ($updateData['limite_credito'] ? "'{$updateData['limite_credito']}'" : 'NULL') . ",
              `aniversario` = " . ($updateData['aniversario'] ? "'{$updateData['aniversario']}'" : 'NULL') . ",
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Conta::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`contas`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }
}
