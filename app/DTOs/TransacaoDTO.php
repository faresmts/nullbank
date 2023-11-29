<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class TransacaoDTO implements DTO
{
    public function __construct(
        public int $conta_id,
        public string $origem,
        public string $tipo,
        public float $valor,
    ) {}

    public static function fromRequest(Request $request): TransacaoDTO
    {
        return new self(
            conta_id: $request->input('conta_id'),
            origem: $request->input('origem'),
            tipo: $request->input('tipo'),
            valor: $request->input('valor'),
        );
    }

    public function toArray(): array
    {
        return [
            'conta_id' => $this->conta_id,
            'origem' => $this->origem,
            'tipo' => $this->tipo,
            'valor' => $this->valor,
        ];
    }
}
