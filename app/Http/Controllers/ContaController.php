<?php

namespace App\Http\Controllers;

use App\DTOs\ContaDTO;
use App\NullBankModels\Agencia;
use App\NullBankModels\Cliente;
use App\NullBankModels\Conta;
use App\NullBankModels\Funcionario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->has('search') ? $request->input('search') : null;

        $allAccounts = Conta::all($search);

        $agencies = Agencia::all();
        $managers = Funcionario::allManagers();
        $customers = Cliente::all();

        $perPage = $request->input('perPage', 10);

        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = $allAccounts->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $accounts = new LengthAwarePaginator(
            $currentPageItems,
            $allAccounts->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('nullbank.accounts.index')
            ->with('agencies', $agencies)
            ->with('managers', $managers)
            ->with('accounts', $accounts)
            ->with('customers', $customers);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
            $accountDto = ContaDTO::fromRequest($request);
            $account = Conta::create($accountDto->toArray());
            $account->attach($account->id, $accountDto->agencia_id, $request->input('cpf'));
        DB::commit();

        return redirect()->route('accounts.index');
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
