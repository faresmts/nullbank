<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Transacao implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $conta_id,
        public string $origem,
        public string $tipo,
        public float $valor,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Transacao
    {
        $query = "
            INSERT INTO `nullbank`.`transacoes` (
                `conta_id`,
                `origem`,
                `tipo`,
                `valor`,
                `created_at`
            ) VALUES (
                {$data['conta_id']},
                '{$data['origem']}',
                '{$data['tipo']}',
                {$data['valor']},
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Transacao::first($lastId);
    }

    public static function first(int|string $id): Transacao
    {
        $query = "
            SELECT * FROM `nullbank`.`transacoes` WHERE `transacoes`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Transacao(
            $data->id,
            $data->conta_id,
            $data->origem,
            $data->tipo,
            $data->valor,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $updateData = [
            'conta_id' => $data['conta_id'] ?? $this->conta_id,
            'origem' => $data['origem'] ?? $this->origem,
            'tipo' => $data['tipo'] ?? $this->tipo,
            'valor' => $data['valor'] ?? $this->valor,
        ];

        $query = "
            UPDATE `nullbank`.`transacoes`
            SET
              `conta_id` = {$updateData['conta_id']},
              `origem` = '{$updateData['origem']}',
              `tipo` = '{$updateData['tipo']}',
              `valor` = {$updateData['valor']},
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Transacao::first($this->id);
    }

    public function delete(): int
    {
        $query = "
            DELETE FROM `nullbank`.`transacoes`
            WHERE `id` = $this->id;
        ";

        return DB::delete($query);
    }

    public static function all(string|null $search = ''): Collection
    {
        $query = "SELECT * FROM transacoes";

        if ($search) {
            $query = "SELECT * FROM transacoes WHERE id = $search";
        }

        $transacoesData = DB::select($query);

        $transacoesCollection = new Collection();

        foreach ($transacoesData as $data) {
            $transacao = new Transacao(
                $data->id,
                $data->conta_id,
                $data->origem,
                $data->tipo,
                $data->valor,
                $data->created_at,
                $data->updated_at,
            );

            $transacoesCollection->push($transacao);
        }

        return $transacoesCollection;
    }

    public static function allFromCustomer(string|null $search = '', string $customerCpf): Collection
    {
        $query = "
            SELECT transacoes.*
                FROM clientes
                JOIN cliente_conta ON clientes.cpf = cliente_conta.cliente_cpf
                JOIN contas ON cliente_conta.conta_id = contas.id AND cliente_conta.agencia_id = contas.agencia_id
                JOIN transacoes ON contas.id = transacoes.conta_id
                WHERE clientes.cpf = '$customerCpf';
        ";

        if ($search) {
            $query = "
                SELECT transacoes.*
                FROM clientes
                JOIN cliente_conta ON clientes.cpf = cliente_conta.cliente_cpf
                JOIN contas ON cliente_conta.conta_id = contas.id AND cliente_conta.agencia_id = contas.agencia_id
                JOIN transacoes ON contas.id = transacoes.conta_id
                WHERE clientes.cpf = '$customerCpf' AND transacoes.id = $search;
            ";
        }

        $transacoesData = DB::select($query);

        $transacoesCollection = new Collection();

        foreach ($transacoesData as $data) {
            $transacao = new Transacao(
                $data->id,
                $data->conta_id,
                $data->origem,
                $data->tipo,
                $data->valor,
                $data->created_at,
                $data->updated_at,
            );

            $transacoesCollection->push($transacao);
        }

        return $transacoesCollection;
    }

    public static function allFromAgency(int $agencyId, string|null $search = ''): Collection
    {
        $query = "SELECT transacoes.*
                    FROM contas
                    JOIN transacoes ON contas.id = transacoes.conta_id
                    WHERE contas.agencia_id = $agencyId;
        ";

        if ($search) {
            $query = "SELECT transacoes.*
                    FROM contas
                    JOIN transacoes ON contas.id = transacoes.conta_id
                    WHERE contas.agencia_id = $agencyId AND transacoes.id = $search
            ";
        }

        $transacoesData = DB::select($query);

        $transacoesCollection = new Collection();

        foreach ($transacoesData as $data) {
            $transacao = new Transacao(
                $data->id,
                $data->conta_id,
                $data->origem,
                $data->tipo,
                $data->valor,
                $data->created_at,
                $data->updated_at,
            );

            $transacoesCollection->push($transacao);
        }

        return $transacoesCollection;
    }
}
