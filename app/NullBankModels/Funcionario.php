<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Funcionario implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $usuario_id,
        public int $agencia_id,
        public string $matricula,
        public string $senha,
        public string $cargo,
        public float $salario,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Funcionario
    {
        $password = Hash::make($data['senha']);

        $query = "
            INSERT INTO `nullbank`.`funcionarios` (
                `usuario_id`,
                `agencia_id`,
                `matricula`,
                `senha`,
                `cargo`,
                `salario`,
                `created_at`
            ) VALUES (
                {$data['usuario_id']},
                {$data['agencia_id']},
                '{$data['matricula']}',
                '$password',
                '{$data['cargo']}',
                {$data['salario']},
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Funcionario::first($lastId);
    }

    public static function first(int|string $id): Funcionario
    {
        $query = "
            SELECT * FROM `nullbank`.`funcionarios` WHERE `funcionarios`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Funcionario(
            $data->id,
            $data->usuario_id,
            $data->agencia_id,
            $data->matricula,
            $data->senha,
            $data->cargo,
            $data->salario,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $password = isset($data['senha']) ? Hash::make($data['senha']) : $this->senha;

        $updateData = [
            'usuario_id' => $data['usuario_id'] ?? $this->usuario_id,
            'agencia_id' => $data['agencia_id'] ?? $this->agencia_id,
            'matricula' => $data['matricula'] ?? $this->matricula,
            'senha' => $password,
            'cargo' => $data['cargo'] ?? $this->cargo,
            'salario' => $data['salario'] ?? $this->salario,
        ];

        $query = "
            UPDATE `nullbank`.`funcionarios`
            SET
              `usuario_id` = {$updateData['usuario_id']},
              `agencia_id` = {$updateData['agencia_id']},
              `matricula` = '{$updateData['matricula']}',
              `senha` = '{$updateData['senha']}',
              `cargo` = '{$updateData['cargo']}',
              `salario` = {$updateData['salario']},
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Funcionario::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`funcionarios`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }
}
