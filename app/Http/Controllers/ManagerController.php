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
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ManagerController extends Controller
{

    public function accounts(Request $request): View|RedirectResponse
    {
        $manager = Funcionario::first($_SESSION['user_id']);

        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $search = $request->has('search') ? $request->input('search') : null;

        $allAccounts = Conta::allFromManager($manager->id, $search);

        $agencies = Agencia::all();
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

        return view('nullbank.managers.accounts.index')
            ->with('agencies', $agencies)
            ->with('manager', $manager)
            ->with('accounts', $accounts)
            ->with('customers', $customers);
   }

    public function createAccount(Request $request): RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $manager = Funcionario::first($_SESSION['user_id']);

        DB::beginTransaction();
        $accountDto = ContaDTO::fromRequest($request);
        $account = Conta::create($accountDto->toArray());
        $account->attach($account->id, $accountDto->agencia_id, $request->input('cpf'));

        if ($request->input('cpf-2')) {
            $account->attach($account->id, $accountDto->agencia_id, $request->input('cpf-2'));
        }
        DB::commit();

        return redirect()->route('managers.accounts.index', $manager->id);
    }

    public function editAccount(string $managerid, string $id): View|RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $account = Conta::first($id);
        $agencies = Agencia::all();
        $manager = Funcionario::first($_SESSION['user_id']);
        $customers = Cliente::all();

        return view('nullbank.managers.accounts.edit')
            ->with('agencies', $agencies)
            ->with('manager', $manager)
            ->with('account', $account)
            ->with('customers', $customers);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAccount(Request $request, string $managerid, string $id): RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $manager = Funcionario::first($_SESSION['user_id']);

        $account = Conta::first($id);

        DB::beginTransaction();
        $accountDto = ContaDTO::fromRequest($request);
        $accountDto->gerente_id = $manager->id;
        $account->update($accountDto->toArray());
        $account->dettach();
        $account->attach($account->id, $accountDto->agencia_id, $request->input('cpf'));

        if ($request->input('cpf-2')) {
            $account->attach($account->id, $accountDto->agencia_id, $request->input('cpf-2'));
        }
        DB::commit();

        return redirect()->route('managers.accounts.index', $manager->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteAccount(string $managerid, string $id): RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $manager = Funcionario::first($_SESSION['user_id']);

        $account = Conta::first($id);

        DB::beginTransaction();
        $account->dettach();
        $account->delete();
        DB::commit();

        return redirect()->route('managers.accounts.index', $manager->id);
    }
}
