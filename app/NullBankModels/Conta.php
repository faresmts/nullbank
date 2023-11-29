<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Conta implements NullBankModel
{
    public function __construct(
        public int $id,
        public int $agencia_id,
        public int $gerente_id,
        public float $saldo,
        public string $senha,
        public string $tipo,
        public float|null $juros,
        public float|null $limite_credito,
        public float|null $credito_usado,
        public Carbon|string|null $aniversario,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Conta
    {
        $password = Hash::make($data['senha']);

        $juros = $data['juros'] ?? 'NULL';
        $limite_credito = $data['limite_credito'] ?? 'NULL';
        $aniversario = isset($data['aniversario']) ? "'" . $data['aniversario'] . "'" : 'NULL';

        $query = "
            INSERT INTO `nullbank`.`contas` (
                `agencia_id`,
                `gerente_id`,
                `senha`,
                `tipo`,
                `juros`,
                `limite_credito`,
                `aniversario`,
                `created_at`
            ) VALUES (
                {$data['agencia_id']},
                {$data['gerente_id']},
                '$password',
                '{$data['tipo']}',
                $juros,
                $limite_credito,
                $aniversario,
                NOW()
            );
        ";

        DB::insert($query);

        $lastId = DB::getPdo()->lastInsertId();

        return Conta::first($lastId);
    }

    public static function first(int|string $id): Conta
    {
        $query = "
            SELECT * FROM `nullbank`.`contas` WHERE `contas`.`id` = $id;
        ";

        $data = DB::selectOne($query);

        return new Conta(
            $data->id,
            $data->agencia_id,
            $data->gerente_id,
            $data->saldo,
            $data->senha,
            $data->tipo,
            $data->juros,
            $data->limite_credito,
            $data->credito_usado,
            $data->aniversario,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        $password = isset($data['senha']) ? Hash::make($data['senha']) : $this->senha;

        $juros = $data['juros'] ?? $this->juros;
        if (is_null($juros)) {
            $juros = 'NULL';
        }

        $limite_credito = $data['limite_credito'] ?? $this->limite_credito;
        if (is_null($limite_credito)) {
            $limite_credito = 'NULL';
        }

        $aniversario = isset($data['aniversario']) ? "'" . $data['aniversario'] . "'" : "'" . $this->aniversario . "'";
        if ($aniversario == "''") {
            $aniversario = 'NULL';
        }

        $updateData = [
            'agencia_id' => $data['agencia_id'] ?? $this->agencia_id,
            'gerente_id' => $data['gerente_id'] ?? $this->gerente_id,
            'saldo' => $data['saldo'] ?? $this->saldo,
            'senha' => $password,
            'tipo' => $data['tipo'] ?? $this->tipo,
            'juros' => $juros,
            'limite_credito' => $limite_credito,
            'aniversario' => $aniversario,
        ];

        switch ($updateData['tipo']) {
            case ('CC'):
                $updateData['juros'] = 'NULL';
                $updateData['limite_credito'] = 'NULL';
                break;
            case ('CP'):
                $updateData['aniversario'] = 'NULL';
                $updateData['limite_credito'] = 'NULL';
                break;
            case ('CE'):
                $updateData['aniversario'] = 'NULL';
                $updateData['juros'] = 'NULL';
                break;
        }

        $query = "
            UPDATE `nullbank`.`contas`
            SET
              `agencia_id` = {$updateData['agencia_id']},
              `gerente_id` = {$updateData['gerente_id']},
              `saldo` = '{$updateData['saldo']}',
              `senha` = '{$updateData['senha']}',
              `tipo` = '{$updateData['tipo']}',
              `juros` = {$updateData['juros']},
              `limite_credito` = {$updateData['limite_credito']},
              `aniversario` = {$updateData['aniversario']},
              `updated_at` = NOW()
            WHERE
              `id` = $this->id;
        ";

        DB::update($query);

        return Conta::first($this->id);
    }

    public function delete(): int
    {
        DB::beginTransaction();

        $transacoesQuery = "DELETE FROM `nullbank`.`transacoes` WHERE conta_id = $this->id";

        DB::delete($transacoesQuery);

        $query = "
            DELETE FROM `nullbank`.`contas`
            WHERE `id` = $this->id;
        ";

        $return = DB::delete($query);

        DB::commit();

        return $return;
    }

    public static function all(string|null $search = ''): Collection
    {
        $query = "SELECT * FROM `nullbank`.`contas`";

        if ($search) {
            $query = "SELECT * FROM `nullbank`.`contas` WHERE id = $search";
        }

        $contasData = DB::select($query);

        $contasCollection = new Collection();

        foreach ($contasData as $data) {
            $conta = new Conta(
                $data->id,
                $data->agencia_id,
                $data->gerente_id,
                $data->saldo,
                $data->senha,
                $data->tipo,
                $data->juros,
                $data->limite_credito,
                $data->credito_usado,
                $data->aniversario,
                $data->created_at,
                $data->updated_at,
            );

            $contasCollection->push($conta);
        }

        return $contasCollection;
    }

    public function getClientes(): Collection
    {
        $query = "
            SELECT * FROM cliente_conta WHERE conta_id = $this->id;
        ";

        $result = DB::select($query);

        $clientesCollection = new Collection();

        if (count($result) == 1) {
            $cliente1 = Cliente::first($result[0]->cliente_cpf);
            $clientesCollection->push($cliente1);
        }

        if (count($result) == 2) {
            $cliente1 = Cliente::first($result[0]->cliente_cpf);
            $cliente2 = Cliente::first($result[1]->cliente_cpf);

            $clientesCollection->push($cliente1, $cliente2);
        }

        return $clientesCollection;
    }

    public static function attach(string|int $contaId, string|int $agenciaId, string|int $clienteCPF): bool
    {
        $query = "INSERT INTO `nullbank`.`cliente_conta` (conta_id, agencia_id, cliente_cpf)
                    VALUES ($contaId, $agenciaId, '$clienteCPF');
        ";

        return DB::insert($query);
    }

    public function dettach(): int
    {
        $query = "DELETE FROM cliente_conta WHERE conta_id = $this->id";

        return DB::delete($query);
    }
}
