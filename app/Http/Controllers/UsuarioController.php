<?php

namespace App\Http\Controllers;

use App\DTOs\ClienteDTO;
use App\DTOs\EnderecoDTO;
use App\DTOs\UsuarioDTO;
use App\NullBankModels\Cliente;
use App\NullBankModels\Endereco;
use App\NullBankModels\Usuario;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UsuarioController extends Controller
{

    public function login(Request $request)
    {
        dd($request->all());
    }

    public function register(Request $request): View
    {
        $logradouroTipos = Endereco::getLogradourosTipos();
        return view('nullbank.customers.register')->with('logradouroTipos', $logradouroTipos);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Application|Redirector|RedirectResponse
    {
        DB::beginTransaction();

            $addressDto = EnderecoDTO::fromRequest($request);
            $address = Endereco::create($addressDto->toArray());

            $userDto = UsuarioDTO::fromRequest($request);
            $userDto->endereco_id = $address->id;
            $user = Usuario::create($userDto->toArray());

            $customerDto = ClienteDTO::fromRequest($request);
            $customerDto->usuario_id = $user->id;
            $customer = Cliente::create($customerDto->toArray());
        DB::commit();

        return redirect(route('customers.register'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
