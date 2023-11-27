<?php

namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EnderecoDTO implements DTO
{
    public function __construct(
        public int $logradouro_tipo_id,
        public string $logradouro,
        public string $numero,
        public string $bairro,
        public string $cep,
        public string $cidade,
        public string $estado,
    ){}

    public static function fromRequest(Request $request): EnderecoDTO
    {
        return new self(
            logradouro_tipo_id: $request->input('logradouro_tipo_id'),
            logradouro: $request->input('logradouro'),
            numero: $request->input('numero'),
            bairro: $request->input('bairro'),
            cep: $request->input('cep'),
            cidade: $request->input('cidade'),
            estado: $request->input('estado')
        );
    }

    public function toArray(): array
    {
        return [
            'logradouro_tipo_id' => $this->logradouro_tipo_id,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero,
            'bairro' => $this->bairro,
            'cep' => $this->cep,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
        ];
    }
}
