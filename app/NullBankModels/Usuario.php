<?php

namespace App\NullBankModels;

use App\Enums\UserPronoumEnum;
use App\Enums\UserSexEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Usuario implements NullBankModel
{
    protected $table = 'usuarios';

    public function __construct(
        public int $id,
        public string $nome,
        public string $sobrenome,
        public UserPronoumEnum|string $pronomes,
        public string $email,
        public Carbon|string $email_verified_at,
        public string $password,
        public int $endereco_id,
        public UserSexEnum|string $sexo,
        public Carbon|string $nascido_em,
        public string $remember_token,
        public Carbon|string $created_at,
        public Carbon|string $updated_at,
    ){}

    public static function create(array $data): Usuario
    {
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
                `created_at`,
            ) VALUES (
                {$data['nome']},
                {$data['sobrenome']},
                {$data['pronomes']},
                {$data['email']},
                {$data['password']},
                {$data['endereco_id']},
                {$data['sexo']},
                {$data['nascido_em']},
                NOW(),
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Usuario::first($lastId);
    }

    public static function first(int $id): Usuario
    {
        $query = "
            SELECT * FROM `nullbank`.`usuarios` WHERE `usuarios`.`id` = $id;
        ";

        $data = DB::selectOne($query);
    }

    public function update(array $values): NullBankModel
    {
        // TODO: Implement update() method.
    }

    public function delete(): NullBankModel
    {
        // TODO: Implement delete() method.
    }
}
