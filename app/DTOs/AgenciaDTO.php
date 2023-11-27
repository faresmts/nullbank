<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class AgenciaDTO implements DTO
{
    public function __construct(
        public string $nome,
        public ?int $endereco_id,
    ) {}

    public static function fromRequest(Request $request): AgenciaDTO
    {
        return new self(
            nome: $request->input('nome'),
            endereco_id: $request->input('endereco_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'endereco_id' => $this->endereco_id,
        ];
    }
}
