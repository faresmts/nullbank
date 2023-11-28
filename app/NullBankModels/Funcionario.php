<?php

namespace App\NullBankModels;

use App\Enums\UserGenderEnum;
use App\Enums\UserPronoumEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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
            SELECT
                `funcionarios`.`id` AS `funcionario_id`,
                `usuarios`.`id` AS `usuario_id`,
                `agencia_id`,
                `matricula`,
                `senha`,
                `cargo`,
                `salario`,
                `funcionarios`.`created_at` AS `funcionario_created_at`,
                `funcionarios`.`updated_at` AS `funcionario_updated_at`,
                `nome`,
                `sobrenome`,
                `pronomes`,
                `email`,
                `email_verified_at`,
                `password`,
                `endereco_id`,
                `sexo`,
                `nascido_em`,
                `remember_token`
            FROM `nullbank`.`funcionarios`
            INNER JOIN `nullbank`.`usuarios` ON `funcionarios`.`usuario_id` = `usuarios`.`id`
            WHERE `funcionarios`.`id` = $id
            ";

        $data = DB::selectOne($query);

        return new Funcionario(
            $data->funcionario_id,
            $data->usuario_id,
            $data->agencia_id,
            $data->matricula,
            $data->senha,
            $data->cargo,
            $data->salario,
            $data->funcionario_created_at,
            $data->funcionario_updated_at,
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
        $user = Usuario::first($this->usuario_id);
        $address = Endereco::first($user->endereco_id);

        $query = "
            DELETE FROM `nullbank`.`funcionarios`
            WHERE `id` = $this->id;
        ";

        DB::beginTransaction();
        $return = DB::delete($query);
        $user->delete();
        $address->delete();
        DB::commit();

        return $return;
    }

    public static function all(string|null $search = ''): Collection
    {
        $query = "
        SELECT
            `funcionarios`.`id` AS `funcionario_id`,
            `usuarios`.`id` AS `usuario_id`,
            `agencia_id`,
            `matricula`,
            `senha`,
            `cargo`,
            `salario`,
            `funcionarios`.`created_at` AS `funcionario_created_at`,
            `funcionarios`.`updated_at` AS `funcionario_updated_at`,
            `nome`,
            `sobrenome`,
            `pronomes`,
            `email`,
            `email_verified_at`,
            `password`,
            `endereco_id`,
            `sexo`,
            `nascido_em`,
            `remember_token`
        FROM `nullbank`.`funcionarios`
        INNER JOIN `nullbank`.`usuarios` ON `funcionarios`.`usuario_id` = `usuarios`.`id`";

        if ($search) {
            $query .= " WHERE `usuarios`.`nome` LIKE '%$search%' OR `usuarios`.`sobrenome` LIKE '%$search%'";
        }

        $funcionariosData = DB::select($query);

        $funcionariosCollection = new Collection();

        foreach ($funcionariosData as $data) {
            $funcionario = new Funcionario(
                $data->funcionario_id,
                $data->usuario_id,
                $data->agencia_id,
                $data->matricula,
                $data->senha,
                $data->cargo,
                $data->salario,
                $data->funcionario_created_at,
                $data->funcionario_updated_at,
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
            );

            $funcionariosCollection->push($funcionario);
        }

        return $funcionariosCollection;
    }

    public static function allManagers(string|null $search = ''): Collection
    {
        $query = "
        SELECT
            `funcionarios`.`id` AS `funcionario_id`,
            `usuarios`.`id` AS `usuario_id`,
            `agencia_id`,
            `matricula`,
            `senha`,
            `cargo`,
            `salario`,
            `funcionarios`.`created_at` AS `funcionario_created_at`,
            `funcionarios`.`updated_at` AS `funcionario_updated_at`,
            `nome`,
            `sobrenome`,
            `pronomes`,
            `email`,
            `email_verified_at`,
            `password`,
            `endereco_id`,
            `sexo`,
            `nascido_em`,
            `remember_token`
        FROM `nullbank`.`funcionarios`
        INNER JOIN `nullbank`.`usuarios` ON `funcionarios`.`usuario_id` = `usuarios`.`id`
        WHERE funcionarios.cargo = 'G'
        ";

        if ($search) {
            $query .= " WHERE `usuarios`.`nome` LIKE '%$search%' OR `usuarios`.`sobrenome` LIKE '%$search%'";
        }

        $funcionariosData = DB::select($query);

        $funcionariosCollection = new Collection();

        foreach ($funcionariosData as $data) {
            $funcionario = new Funcionario(
                $data->funcionario_id,
                $data->usuario_id,
                $data->agencia_id,
                $data->matricula,
                $data->senha,
                $data->cargo,
                $data->salario,
                $data->funcionario_created_at,
                $data->funcionario_updated_at,
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
            );

            $funcionariosCollection->push($funcionario);
        }

        return $funcionariosCollection;
    }
}
