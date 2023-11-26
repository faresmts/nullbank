<?php

namespace App\NullBankModels;

use App\Enums\UserPronoumEnum;
use App\Enums\UserGenderEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usuario implements NullBankModel
{

    public function __construct(
        public int $id,
        public string $nome,
        public string $sobrenome,
        public UserPronoumEnum|string $pronomes,
        public string $email,
        public Carbon|string|null $email_verified_at,
        public string $password,
        public int $endereco_id,
        public UserGenderEnum|string $sexo,
        public Carbon|string $nascido_em,
        public string|null $remember_token,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Usuario
    {
        $password = Hash::make($data['password']);

        $query = "
            INSERT INTO `nullbank`.`usuarios` (
                `nome`,
                `sobrenome`,
                `pronomes`,
                `email`,
                `password`,
                `endereco_id`,
                `sexo`,
                `nascido_em`,
                `created_at`
            ) VALUES (
                '{$data['nome']}',
                '{$data['sobrenome']}',
                '{$data['pronomes']}',
                '{$data['email']}',
                '$password',
                {$data['endereco_id']},
                '{$data['sexo']}',
                '{$data['nascido_em']}',
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Usuario::first($lastId);
    }

    public static function first(int|string $id): Usuario
    {
        $query = "
            SELECT * FROM `nullbank`.`usuarios` WHERE `usuarios`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Usuario(
            $data->id,
            $data->nome,
            $data->sobrenome,
            $data->pronomes,
            $data->email,
            $data->email_verified_at,
            $data->password,
            $data->endereco_id,
            $data->sexo,
            $data->nascido_em,
            $data->remember_token,
            $data->created_at,
            $data->updated_at,
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
        ];

        $query = "
            UPDATE `nullbank`.`usuarios`
            SET
              `nome` = '{$updateData['nome']}',
              `sobrenome` = '{$updateData['sobrenome']}',
              `pronomes` = '{$updateData['pronomes']}',
              `email` = '{$updateData['email']}',
              `password` = '{$updateData['password']}',
              `endereco_id` = '{$updateData['endereco_id']}',
              `sexo` = '{$updateData['sexo']}',
              `nascido_em` = '{$updateData['nascido_em']}',
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Usuario::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`usuarios`
            WHERE `id` = $this->id;
        ";

        $permissionsDeleteQuery = "
            DELETE FROM `nullbank`.`usuario_permissao`
            WHERE `usuarios_id` = $this->id;
        ";

        DB::delete($permissionsDeleteQuery);

        return DB::delete($query);
    }

    public static function attach(string|int $usuarioId, string|int $permissaoId): bool
    {
        $query = "INSERT INTO `nullbank`.`usuario_permissao` (usuarios_id, permissoes_id)
                    VALUES ($usuarioId, $permissaoId)
        ";

        return DB::insert($query);
    }
}
