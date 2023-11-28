<?php

namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DependenteDTO implements DTO
{
    public function __construct(
        public ?int $funcionario_id,
        public string $nome,
        public Carbon|string $nascido_em,
        public ?string $parentesco,
    ) {}

    public static function fromRequest(Request $request): DependenteDTO
    {
        return new self(
            funcionario_id: $request->input('funcionario_id'),
            nome: $request->input('nome'),
            nascido_em: Carbon::make($request->input('nascido_em'))->format('Y-m-d'),
            parentesco: $request->input('parentesco'),
        );
    }

    public function toArray(): array
    {
        return [
            'funcionario_id' => $this->funcionario_id,
            'nome' => $this->nome,
            'nascido_em' => $this->nascido_em,
            'parentesco' => $this->parentesco,
        ];
    }
}
