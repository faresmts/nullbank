<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Agencia implements NullBankModel
{
    public function __construct(
        public int $id,
        public string $nome,
        public int $endereco_id,
        public float|null $montante_salarios,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Agencia
    {
        $query = "
            INSERT INTO `nullbank`.`agencias` (
                `nome`,
                `endereco_id`,
                `created_at`
            ) VALUES (
                '{$data['nome']}',
                {$data['endereco_id']},
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Agencia::first($lastId);
    }

    public static function first(int|string $id): Agencia
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
        ];

        $query = "
            UPDATE `nullbank`.`agencias`
            SET
              `nome` = '{$updateData['nome']}',
              `endereco_id` = '{$updateData['endereco_id']}',
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Agencia::first($this->id);
    }

    public function delete(): int
    {
        $address = Endereco::first($this->endereco_id);

        $query = "
            DELETE FROM `nullbank`.`agencias`
            WHERE `id` = $this->id;
        ";

        DB::beginTransaction();
            $return  = DB::delete($query);
            $address->delete();
        DB::commit();

        return $return;
    }

    public static function all(string|null $search = ''): Collection
    {
        $query = "SELECT * FROM `nullbank`.`agencias`";

        if ($search) {
            $query = "SELECT * FROM `nullbank`.`agencias` WHERE nome LIKE '%$search%'";
        }

        $agenciasData = DB::select($query);

        $agenciasCollection = new Collection();

        foreach ($agenciasData as $data) {
            $agencia = new Agencia(
                $data->id,
                $data->nome,
                $data->endereco_id,
                $data->montante_salarios,
                $data->created_at,
                $data->updated_at,
            );

            $agenciasCollection->push($agencia);
        }

        return $agenciasCollection;
    }
}
