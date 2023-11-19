<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Funcionario implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $usuario_id,
        public int $agencia_id,
        public string $matricula,
        public string|null $senha,
        public string|null $cargo,
        public float|null $salario,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Funcionario
    {
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
                " . ($data['senha'] ? "'{$data['senha']}'" : 'NULL') . ",
                " . ($data['cargo'] ? "'{$data['cargo']}'" : 'NULL') . ",
                " . ($data['salario'] ? "'{$data['salario']}'" : 'NULL') . ",
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Funcionario::first($lastId);
    }

    public static function first(int $id): Funcionario
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
        $updateData = [
            'usuario_id' => $data['usuario_id'] ?? $this->usuario_id,
            'agencia_id' => $data['agencia_id'] ?? $this->agencia_id,
            'matricula' => $data['matricula'] ?? $this->matricula,
            'senha' => $data['senha'] ?? $this->senha,
            'cargo' => $data['cargo'] ?? $this->cargo,
            'salario' => $data['salario'] ?? $this->salario,
        ];

        $query = "
            UPDATE `nullbank`.`funcionarios`
            SET
              `usuario_id` = '{$updateData['usuario_id']}',
              `agencia_id` = '{$updateData['agencia_id']}',
              `matricula` = '{$updateData['matricula']}',
              `senha` = " . ($updateData['senha'] ? "'{$updateData['senha']}'" : 'NULL') . ",
              `cargo` = " . ($updateData['cargo'] ? "'{$updateData['cargo']}'" : 'NULL') . ",
              `salario` = " . ($updateData['salario'] ? "'{$updateData['salario']}'" : 'NULL') . ",
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
