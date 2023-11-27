<?php

namespace App\DTOs;

use Illuminate\Http\Request;

interface DTO
{
    public static function fromRequest(Request $request): DTO;

    public function toArray(): array;
}
