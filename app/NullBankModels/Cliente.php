<?php

namespace App\NullBankModels;

use App\Enums\UserPronoumEnum;
use App\Enums\UserGenderEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Cliente implements NullBankModel
{

    public function __construct(
        public string $cpf,
        public int $usuario_id,
        public string $rg,
        public string $rg_emitido_por,
        public string $uf,
        public array $telefones,
        public array $emails
    ){}

    public static function create(array $data): Cliente
    {
        $phones = isset($data['telefones']) ? json_encode($data['telefones']) : null;
        $emails = isset($data['emails']) ? json_encode($data['emails']) : null;

        $query = "
            INSERT INTO `nullbank`.`clientes` (
                `cpf`,
                `usuario_id`,
                `rg`,
                `rg_emitido_por`,
                `uf`,
                `telefones`,
                `emails`,
            ) VALUES (
                '{$data['cpf']}',
                 {$data['usuario_id']},
                '{$data['rg']}',
                '{$data['rg_emitido_por']}',
                '{$data['uf']}',
                $phones,
                $emails,
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Cliente::first($lastId);
    }

    public static function first(int $id): Cliente
    {
        $query = "
            SELECT * FROM `nullbank`.`clientes` WHERE `clientes`.`cpf` = $id;
        ";

        $data = DB::selectOne($query);

        return new Cliente(
            $data->cpf,
            $data->usuario_id,
            $data->rg,
            $data->rg_emitido_por,
            $data->uf,
            $data->telefones,
            $data->emails
        );
    }

    public function update(array $data): NullBankModel
    {
        $password = isset($data['password']) ? Hash::make($data['password']) : $this->password;

        $updateData = [
            'nome' => $data['nome'] ?? $this->nome,
            'sobrenome' => $data['sobrenome'] ?? $this->sobrenome,
            'pronomes' => $data['pronomes'] ?? $this->pronomes,
            'email' => $data['email'] ?? $this->email,
            'password' => Hash::make($password),
            'endereco_id' => $data['$this->endereco_id'] ?? $this->endereco_id,
            'sexo' => $data['sexo'] ?? $this->sexo,
            'nascido_em' => $data['nascido_em'] ?? $this->nascido_em,
            'updated_at' => NOW()
        ];

        $query = "
            UPDATE `nullbank`.`clientes`
            SET
              `nome` = '{$updateData['nome']}',
              `sobrenome` = '{$updateData['sobrenome']}',
              `pronomes` = '{$updateData['pronomes']}',
              `email` = '{$updateData['email']}',
              `password` = '{$updateData['password']}',
              `endereco_id` = '{$updateData['endereco_id']}',
              `sexo` = '{$updateData['sexo']}',
              `nascido_em` = '{$updateData['nascido_em']}',
              `updated_at` = '{$updateData['updated_at']}'
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Cliente::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`clientes`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }
}
