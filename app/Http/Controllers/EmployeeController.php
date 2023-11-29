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

class EmployeeController extends Controller
{

    public function index(Request $request): View|RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $employee = Funcionario::first($_SESSION['user_id']);

        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $search = $request->has('search') ? $request->input('search') : null;

        $allAccounts = Conta::allFromAgency($employee->agencia_id, $search);

        $agency = Agencia::first($employee->agencia_id);
        $customers = Cliente::all();
        $managers = Funcionario::all();

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

        return view('nullbank.employees.accounts.index')
            ->with('agency', $agency)
            ->with('managers', $managers)
            ->with('accounts', $accounts)
            ->with('employee', $employee)
            ->with('customers', $customers);
   }
}
