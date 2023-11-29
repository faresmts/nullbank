<?php

namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ContaDTO implements DTO
{
    public function __construct(
        public int $agencia_id,
        public int $gerente_id,
        public ?string $senha,
        public string $tipo,
        public float|null $juros,
        public float|null $limite_credito,
        public Carbon|string|null $aniversario,
    ) {}

    public static function fromRequest(Request $request): ContaDTO
    {
        return new self(
            agencia_id: $request->input('agencia_id'),
            gerente_id: $request->input('gerente_id'),
            senha: $request->input('password'),
            tipo: $request->input('tipo'),
            juros: $request->input('juros'),
            limite_credito: $request->input('limite_credito'),
            aniversario: $request->input('tipo') == 'CC' ? now()->format('Y-m-d') : null,
        );
    }

    public function toArray(): array
    {
        return [
            'agencia_id' => $this->agencia_id,
            'gerente_id' => $this->gerente_id,
            'senha' => $this->senha,
            'tipo' => $this->tipo,
            'juros' => $this->juros,
            'limite_credito' => $this->limite_credito,
            'aniversario' => $this->aniversario,
        ];
    }
}
