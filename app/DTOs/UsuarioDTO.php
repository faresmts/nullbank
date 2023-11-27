<?php

namespace App\DTOs;

use App\Enums\UserGenderEnum;
use App\Enums\UserPronoumEnum;
use Carbon\Carbon;
use GuzzleHttp\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use function PHPUnit\Framework\throwException;

class UsuarioDTO implements DTO
{
    public function __construct(
        public string $nome,
        public string $sobrenome,
        public UserPronoumEnum|string $pronomes,
        public string $email,
        public string $password,
        public int|null $endereco_id,
        public UserGenderEnum|string $sexo,
        public Carbon|string $nascido_em,
    ){}

    public static function fromRequest(Request $request): UsuarioDTO
    {
        return new self(
            nome: $request->input('nome'),
            sobrenome: $request->input('sobrenome'),
            pronomes: $request->input('pronomes'),
            email: $request->input('email'),
            password: $request->input('password'),
            endereco_id: $request->input('endereco_id'),
            sexo: self::setSexoFromRequest($request),
            nascido_em: Carbon::create($request->input('nascido_em'))->format('Y-m-d'),
        );
    }

    private static function setSexoFromRequest(Request $request): string
    {
        return match ($request->input('pronomes')) {
            UserPronoumEnum::HE->value => UserGenderEnum::MALE->value,
            UserPronoumEnum::SHE->value => UserGenderEnum::FEMALE->value,
            UserPronoumEnum::OTHERS->value => UserGenderEnum::OTHERS->value,
            default => throw new InvalidArgumentException('Gender not valid')
        };
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'pronomes' => $this->pronomes,
            'email' => $this->email,
            'password' => $this->password,
            'endereco_id' => $this->endereco_id,
            'sexo' => $this->sexo,
            'nascido_em' => $this->nascido_em,
        ];
    }
}
