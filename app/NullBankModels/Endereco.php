<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

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

    public static function getLogradourosTipos(): array
    {
        $query = "
            SELECT * FROM `nullbank`.`logradouro_tipos`;
        ";

        $results = DB::select($query);

        return $results;
    }

    public static function getLogradourosTipo(string|int $id)
    {
        $query = "
            SELECT * FROM `nullbank`.`logradouro_tipos` WHERE `logradouro_tipos`.`id` = $id;
        ";

        return DB::selectOne($query);
    }

    public static function all(string|null $search = ''): Collection
    {
        $query = "SELECT * FROM `nullbank`.`enderecos`";

        if ($search) {
            $query = "SELECT * FROM `nullbank`.`enderecos`
                        WHERE `enderecos`.`logradouro` LIKE '%$search%'
            ";
        }

        $enderecosData = DB::select($query);

        $enderecosCollection = new Collection();

        foreach ($enderecosData as $data) {
            $endereco = new Endereco(
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

            $enderecosCollection->push($endereco);
        }

        return $enderecosCollection;
    }

    public function belongsTo(): NullBankModel|null
    {
        $query = "
            SELECT
                enderecos.id AS endereco_id,
                agencias.id AS agencia_id,
                agencias.nome AS agencia_nome,
                usuarios.id AS usuario_id,
                usuarios.nome AS usuario_nome
            FROM enderecos
            LEFT JOIN agencias ON enderecos.id = agencias.endereco_id
            LEFT JOIN usuarios ON enderecos.id = usuarios.endereco_id
            WHERE enderecos.id = $this->id;
        ";

        $result = DB::selectOne($query);

        if ($result) {
            if ($result->usuario_id !== null) {
                return Usuario::first($result->usuario_id);
            } elseif ($result->agencia_id !== null) {
                return Agencia::first($result->agencia_id);
            }
        }

        return null;
    }
}
