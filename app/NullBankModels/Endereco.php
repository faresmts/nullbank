<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Endereco implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $logradouro_tipo_id,
        public string $logradouro,
        public string $numero,
        public string $bairro,
        public string $cep,
        public string $cidade,
        public string $estado,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Endereco
    {
        $query = "
            INSERT INTO `nullbank`.`enderecos` (
                `logradouro_tipo_id`,
                `logradouro`,
                `numero`,
                `bairro`,
                `cep`,
                `cidade`,
                `estado`,
                `created_at`
            ) VALUES (
                {$data['logradouro_tipo_id']},
                '{$data['logradouro']}',
                '{$data['numero']}',
                '{$data['bairro']}',
                '{$data['cep']}',
                '{$data['cidade']}',
                '{$data['estado']}',
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Endereco::first($lastId);
    }

    public static function first(int|string $id): Endereco
    {
        $query = "
            SELECT * FROM `nullbank`.`enderecos` WHERE `enderecos`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Endereco(
            $data->id,
            $data->logradouro_tipo_id,
            $data->logradouro,
            $data->numero,
            $data->bairro,
            $data->cep,
            $data->cidade,
            $data->estado,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'logradouro_tipo_id' => $data['logradouro_tipo_id'] ?? $this->logradouro_tipo_id,
            'logradouro' => $data['logradouro'] ?? $this->logradouro,
            'numero' => $data['numero'] ?? $this->numero,
            'bairro' => $data['bairro'] ?? $this->bairro,
            'cep' => $data['cep'] ?? $this->cep,
            'cidade' => $data['cidade'] ?? $this->cidade,
            'estado' => $data['estado'] ?? $this->estado,
        ];

        $query = "
            UPDATE `nullbank`.`enderecos`
            SET
              `logradouro_tipo_id` = {$updateData['logradouro_tipo_id']},
              `logradouro` = '{$updateData['logradouro']}',
              `numero` = '{$updateData['numero']}',
              `bairro` = '{$updateData['bairro']}',
              `cep` = '{$updateData['cep']}',
              `cidade` = '{$updateData['cidade']}',
              `estado` = '{$updateData['estado']}',
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Endereco::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`enderecos`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }
}
