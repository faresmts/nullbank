<?php

namespace App\NullBankModels;

use App\Enums\UserGenderEnum;
use App\Enums\UserPronoumEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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

        $query = "
            SELECT
                `clientes`.`cpf` AS `cliente_cpf`,
                `usuarios`.`id` AS `usuario_id`,
                `rg`,
                `rg_emitido_por`,
                `uf`,
                `clientes`.`created_at` AS `cliente_created_at`,
                `clientes`.`updated_at` AS `cliente_updated_at`,
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
            FROM `nullbank`.`clientes`
            INNER JOIN `nullbank`.`usuarios` ON `clientes`.`usuario_id` = `usuarios`.`id`
            WHERE `clientes`.`cpf` = $cpf
            ";

        $data = DB::selectOne($query);

        $emailsQuery = "SELECT * FROM `nullbank`.`emails` WHERE `emails`.`clientes_cpf` = '$cpf'";

        $emails = DB::select($emailsQuery);

        $telefonesQuery = "SELECT * FROM `nullbank`.`telefones` WHERE `telefones`.`clientes_cpf` = '$cpf'";

        $telefones = DB::select($telefonesQuery);

        return new Cliente(
            $data->cliente_cpf,
            $data->usuario_id,
            $data->rg,
            $data->rg_emitido_por,
            $data->uf,
            $emails,
            $telefones,
            $data->cliente_created_at,
            $data->cliente_updated_at,
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

        $result = DB::delete($query);

        $user = Usuario::first($this->usuario_id);
        $user->delete();
        $address = Endereco::first($user->endereco_id);
        $address->delete();

        DB::commit();

        return $result;
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

    public static function all(string|null $search = ''): Collection
    {
        $query = "
        SELECT
            `clientes`.`cpf` AS `cliente_cpf`,
            `usuarios`.`id` AS `usuario_id`,
            `rg`,
            `rg_emitido_por`,
            `uf`,
            `clientes`.`created_at` AS `cliente_created_at`,
            `clientes`.`updated_at` AS `cliente_updated_at`,
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
        FROM `nullbank`.`clientes`
        INNER JOIN `nullbank`.`usuarios` ON `clientes`.`usuario_id` = `usuarios`.`id`";

        if ($search) {
            $query .= " WHERE `usuarios`.`nome` LIKE '%$search%' OR `usuarios`.`sobrenome` LIKE '%$search%'";
        }

        $clientesData = DB::select($query);

        $clientesCollection = new Collection();

        foreach ($clientesData as $data) {
            $emailsQuery = "SELECT * FROM `nullbank`.`emails` WHERE `emails`.`clientes_cpf` = '$data->cliente_cpf'";

            $emails = DB::select($emailsQuery);

            $telefonesQuery = "SELECT * FROM `nullbank`.`telefones` WHERE `telefones`.`clientes_cpf` = '$data->cliente_cpf'";

            $telefones = DB::select($telefonesQuery);

            $cliente = new Cliente(
                $data->cliente_cpf,
                $data->usuario_id,
                $data->rg,
                $data->rg_emitido_por,
                $data->uf,
                $emails,
                $telefones,
                $data->cliente_created_at,
                $data->cliente_updated_at,
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

            $clientesCollection->push($cliente);
        }

        return $clientesCollection;
    }

    public function totalDeContas(): int
    {
        $query = "
            SELECT COUNT(*) AS total_contas FROM cliente_conta WHERE cliente_cpf = $this->cpf
        ";

        $result = DB::selectOne($query);

        return $result->total_contas;
    }
}
