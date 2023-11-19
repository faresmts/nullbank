<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dependente implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $funcionario_id,
        public string $nome,
        public Carbon|string|null $nascido_em,
        public string $parentesco,
        public int|null $idade,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Dependente
    {
        $query = "
            INSERT INTO `nullbank`.`dependentes` (
                `funcionario_id`,
                `nome`,
                `nascido_em`,
                `parentesco`,
                `idade`,
                `created_at`
            ) VALUES (
                {$data['funcionario_id']},
                '{$data['nome']}',
                " . ($data['nascido_em'] ? "'{$data['nascido_em']}'" : 'NULL') . ",
                '{$data['parentesco']}',
                " . ($data['idade'] ? $data['idade'] : 'NULL') . ",
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Dependente::first($lastId, $data['funcionario_id']);
    }

    public static function first(int $id, int $funcionario_id): Dependente
    {
        $query = "
            SELECT * FROM `nullbank`.`dependentes` WHERE `dependentes`.`id` = $id AND `dependentes`.`funcionario_id` = $funcionario_id;
        ";

        $data = DB::selectOne($query);

        return new Dependente(
            $data->id,
            $data->funcionario_id,
            $data->nome,
            $data->nascido_em,
            $data->parentesco,
            $data->idade,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'funcionario_id' => $data['funcionario_id'] ?? $this->funcionario_id,
            'nome' => $data['nome'] ?? $this->nome,
            'nascido_em' => $data['nascido_em'] ?? $this->nascido_em,
            'parentesco' => $data['parentesco'] ?? $this->parentesco,
            'idade' => $data['idade'] ?? $this->idade,
        ];

        $query = "
            UPDATE `nullbank`.`dependentes`
            SET
              `funcionario_id` = '{$updateData['funcionario_id']}',
              `nome` = '{$updateData['nome']}',
              `nascido_em` = " . ($updateData['nascido_em'] ? "'{$updateData['nascido_em']}'" : 'NULL') . ",
              `parentesco` = '{$updateData['parentesco']}',
              `idade` = " . ($updateData['idade'] ? $updateData['idade'] : 'NULL') . ",
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Dependente::first($this->id, $updateData['funcionario_id']);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`dependentes`
            WHERE `id` = $this->id AND `funcionario_id` = $this->funcionario_id;
        ";

        return DB::delete($query);
    }
}
