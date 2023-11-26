<?php

namespace App\NullBankModels;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class Cliente implements NullBankModel
{
    public function __construct(
        public string $cpf,
        public int $usuario_id,
        public string $rg,
        public string $rg_emitido_por,
        public string $uf,
        public array|null|stdClass $emails,
        public array|null|stdClass $telefones,
        public Carbon|string|null $created_at,
        public Carbon|string|null $updated_at,
    ){}

    public static function create(array $data): Cliente
    {
        DB::beginTransaction();
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
            Cliente::insertEmails($data['cpf'], $data['emails']);
        }

        if (isset($data['telefones'])) {
            Cliente::insertTelefones($data['cpf'], $data['telefones']);
        }

        DB::commit();

        return Cliente::first($data['cpf']);
    }

    public static function first(int|string $cpf): Cliente
    {
        $query = "
            SELECT * FROM `nullbank`.`clientes` WHERE `clientes`.`cpf` = '$cpf';
        ";

        $data = DB::selectOne($query);

        $emailsQuery = "SELECT * FROM `nullbank`.`emails` WHERE `emails`.`clientes_cpf` = '$cpf'";

        $emails = DB::select($emailsQuery);

        $telefonesQuery = "SELECT * FROM `nullbank`.`telefones` WHERE `telefones`.`clientes_cpf` = '$cpf'";

        $telefones = DB::select($telefonesQuery);

        return new Cliente(
            $data->cpf,
            $data->usuario_id,
            $data->rg,
            $data->rg_emitido_por,
            $data->uf,
            $emails,
            $telefones,
            $data->created_at,
            $data->updated_at,
        );
    }

    public function update(array $data): NullBankModel
    {
        DB::beginTransaction();

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

        if (isset($data['emails'])) {
            Cliente::deleteEmails($this->cpf);
            Cliente::insertEmails($this->cpf, $data['emails']);
        }

        if (isset($data['telefones'])) {
            Cliente::deleteTelefones($this->cpf);
            Cliente::insertTelefones($this->cpf, $data['telefones']);
        }

        DB::commit();

        return Cliente::first($this->cpf);
    }

    public function delete(): int
    {
        DB::beginTransaction();
        $query = "
            DELETE FROM `nullbank`.`clientes`
            WHERE `cpf` = '{$this->cpf}';
        ";

        Cliente::deleteEmails($this->cpf);
        Cliente::deleteTelefones($this->cpf);
        Cliente::deleteContas($this->cpf);

        DB::commit();

        return DB::delete($query);
    }

    private static function insertEmails(string|int $cpf, array $emails): void
    {
        foreach ($emails as $email) {
            $query = "
                INSERT INTO `nullbank`.`emails` (endereco, clientes_cpf, descricao) VALUES
                    ('{$email['endereco']}', '$cpf', '{$email['descricao']}');
            ";

            DB::insert($query);
        }
    }

    private static function deleteEmails(string $cpf): void
    {
        $query = "DELETE FROM `nullbank`.`emails` WHERE clientes_cpf = '$cpf'";

        DB::delete($query);
    }

    private static function insertTelefones(string|int $cpf, array $telefones): void
    {
        foreach ($telefones as $telefone) {
            $query = "
                INSERT INTO `nullbank`.`telefones` (numero, clientes_cpf, descricao) VALUES
                    ('{$telefone['numero']}', '$cpf', '{$telefone['descricao']}');
            ";

            DB::insert($query);
        }
    }

    private static function deleteTelefones(string $cpf): void
    {
        $query = "DELETE FROM `nullbank`.`telefones` WHERE clientes_cpf = '$cpf'";

        DB::delete($query);
    }

    public static function attach(string|int $contaId, string|int $agenciaId, string|int $clienteCPF): bool
    {
        $query = "INSERT INTO `nullbank`.`cliente_conta` (conta_id, agencia_id, cliente_cpf)
                    VALUES ($contaId, $agenciaId, '$clienteCPF');
        ";

        return DB::insert($query);
    }

    private static function deleteContas(string $cpf): void
    {
        DB::beginTransaction();

        $contasIdsQuery = "SELECT conta_id FROM `nullbank`.`cliente_conta` WHERE cliente_cpf = '$cpf';";

        $contasIds = DB::select($contasIdsQuery);

        $deleteClienteContas = "DELETE FROM `nullbank`.`cliente_conta` WHERE cliente_cpf = '$cpf'";

        DB::delete($deleteClienteContas);

        foreach ($contasIds as $contaId) {
            $conta = Conta::first($contaId->conta_id);
            $conta->delete();
        }

        DB::commit();
    }
}
