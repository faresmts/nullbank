<?php

namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Http\Request;
use InvalidArgumentException;
use stdClass;

class ClienteDTO implements DTO
{
    public function __construct(
        public string $cpf,
        public int|null $usuario_id,
        public string $rg,
        public string $rg_emitido_por,
        public string $uf,
        public array|null|stdClass $emails,
        public array|null|stdClass $telefones,
    ){}

    public static function fromRequest(Request $request): ClienteDTO
    {
        return new self(
            cpf: str_replace(['.', '-'], '', $request->input('cpf')),
            usuario_id: $request->input('usuario_id'),
            rg: $request->input('rg'),
            rg_emitido_por: $request->input('rg_emitido_por'),
            uf: $request->input('uf'),
            emails: self::processArrayOrObject($request->input('emails')),
            telefones: self::processArrayOrObject($request->input('telefones')),
        );
    }

    public function toArray(): array
    {
        return [
            'cpf' => $this->cpf,
            'usuario_id' => $this->usuario_id,
            'rg' => $this->rg,
            'rg_emitido_por' => $this->rg_emitido_por,
            'uf' => $this->uf,
            'emails' => $this->emails,
            'telefones' => $this->telefones,
        ];
    }

    private static function processArrayOrObject($input): array|null
    {
        if (is_array($input) || is_object($input) || is_null($input)) {
            return $input;
        }

        throw new InvalidArgumentException('Input must be an array or object.');
    }
}
