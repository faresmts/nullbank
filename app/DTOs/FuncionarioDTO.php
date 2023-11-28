<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class FuncionarioDTO implements DTO
{
    public function __construct(
        public ?int $usuario_id,
        public int $agencia_id,
        public string $matricula,
        public ?string $senha,
        public string $cargo,
        public float $salario,
    ) {}

    public static function fromRequest(Request $request): FuncionarioDTO
    {
        return new self(
            usuario_id: $request->input('usuario_id'),
            agencia_id: $request->input('agencia_id'),
            matricula: $request->input('matricula'),
            senha: $request->input('senha_corporativa'),
            cargo: $request->input('cargo'),
            salario: $request->input('salario'),
        );
    }

    public function toArray(): array
    {
        return [
            'usuario_id' => $this->usuario_id,
            'agencia_id' => $this->agencia_id,
            'matricula' => $this->matricula,
            'senha' => $this->senha,
            'cargo' => $this->cargo,
            'salario' => $this->salario,
        ];
    }
}
