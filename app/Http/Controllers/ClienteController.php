<?php

namespace App\Http\Controllers;

use App\DTOs\ClienteDTO;
use App\DTOs\EnderecoDTO;
use App\DTOs\TransacaoDTO;
use App\DTOs\UsuarioDTO;
use App\NullBankModels\Agencia;
use App\NullBankModels\Cliente;
use App\NullBankModels\Conta;
use App\NullBankModels\Endereco;
use App\NullBankModels\Funcionario;
use App\NullBankModels\Transacao;
use App\NullBankModels\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->has('search') ? $request->input('search') : null;

        $allCustomers = Cliente::all($search);

        $streetTypes = Endereco::getLogradourosTipos();

        $perPage = $request->input('perPage', 10);

        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = $allCustomers->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $customers = new LengthAwarePaginator(
            $currentPageItems,
            $allCustomers->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('nullbank.customers.index')
            ->with('streetTypes', $streetTypes)
            ->with('customers', $customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        return redirect()->route('customers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $streetTypes = Endereco::getLogradourosTipos();
        $customer = Cliente::first($id);

        return view('nullbank.customers.edit')
            ->with('streetTypes', $streetTypes)
            ->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $customer = Cliente::first($id);
        $user = Usuario::first($customer->usuario_id);
        $address = Endereco::first($user->endereco_id);

        DB::beginTransaction();
        $addressDto = EnderecoDTO::fromRequest($request);
        $address->update($addressDto->toArray());

        $userDto = UsuarioDTO::fromRequest($request);
        $userDto->endereco_id = $address->id;
        $user->update($userDto->toArray());

        $customerDto = ClienteDTO::fromRequest($request);
        $customerDto->usuario_id = $user->id;
        $customer->update($customerDto->toArray());
        DB::commit();

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $customer = Cliente::first($id);
        $customer->delete();

        return redirect()->route('customers.index');
    }

    public function customerTransactions(Request $request): View|RedirectResponse
    {
        $search = $request->has('search') ? $request->input('search') : null;

        $allTransactions = Transacao::allFromCustomer($search, $_SESSION['user_id']);

        $accounts = Conta::all();

        $perPage = $request->input('perPage', 20);

        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = $allTransactions->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $transactions = new LengthAwarePaginator(
            $currentPageItems,
            $allTransactions->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('nullbank.transactions.index')
            ->with('transactions', $transactions)
            ->with('accounts', $accounts);
    }

    public function createCustomerTransaction(Request $request): RedirectResponse
    {
        $transactionDto = TransacaoDTO::fromRequest($request);
        Transacao::create($transactionDto->toArray());

        $customer = Cliente::first($_SESSION['user_id']);

        return redirect()->route('customers.transactions.index', $customer->cpf);
    }

}
