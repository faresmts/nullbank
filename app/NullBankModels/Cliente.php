<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Cliente implements NullBankModel
{
    public function __construct(
        public string $cpf,
        public int $usuario_id,
        public string $rg,
        public string $rg_emitido_por,
        public string $uf,
        public array|null $emails,
        public array|null $telefones,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Cliente
    {
        $query = "
            INSERT INTO `nullbank`.`clientes` (
                `cpf`,
                `usuario_id`,
                `rg`,
                `rg_emitido_por`,
                `uf`,
                `created_at`
            ) VALUES (
                '{$data['cpf']}',
                {$data['usuario_id']},
                '{$data['rg']}',
                '{$data['rg_emitido_por']}',
                '{$data['uf']}',
                NOW()
            );
        ";

        DB::insert($query);

        if (isset($data['emails'])) {
            $this->insertEmails($data['emails']);
        }

//        if (isset($data['emails'])) {
//            $queryEmails = "
//                INSERT INTO `nullbank`.`emails` (endereco, clientes_cpf, descricao) VALUES
//            ";
//
//            foreach ($data['emails'] as $key => $email) {
//
//                $address = $email['endereco'];
//                $cpf = $email['clientes_cpf']
//
//                if ($key == count($data['emails']) - 1) {
//                    $query .= "($userId, $permissionId);";
//                    break;
//                }
//
//                $queryEmails .=
//            }
//        }

        return Cliente::first($data['cpf']);
    }

    public static function first(int $cpf): Cliente
    {
        $query = "
            SELECT * FROM `nullbank`.`clientes` WHERE `clientes`.`cpf` = '$cpf';
        ";

        $data = DB::selectOne($query);

        return new Cliente(
            $data->cpf,
            $data->usuario_id,
            $data->rg,
            $data->rg_emitido_por,
            $data->uf,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'usuario_id' => $data['usuario_id'] ?? $this->usuario_id,
            'rg' => $data['rg'] ?? $this->rg,
            'rg_emitido_por' => $data['rg_emitido_por'] ?? $this->rg_emitido_por,
            'uf' => $data['uf'] ?? $this->uf,
        ];

        $query = "
            UPDATE `nullbank`.`clientes`
            SET
              `usuario_id` = {$updateData['usuario_id']},
              `rg` = '{$updateData['rg']}',
              `rg_emitido_por` = '{$updateData['rg_emitido_por']}',
              `uf` = '{$updateData['uf']}',
              `updated_at` = NOW()
            WHERE
              `cpf` = '{$this->cpf}';
        ";

        DB::update($query);

        return Cliente::first($this->cpf);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`clientes`
            WHERE `cpf` = '{$this->cpf}';
        ";

        return DB::delete($query);
    }
}
