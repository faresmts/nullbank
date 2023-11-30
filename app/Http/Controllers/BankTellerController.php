<?php

namespace App\Http\Controllers;

use App\DTOs\TransacaoDTO;
use App\Enums\EmployeeTypeEnum;
use App\NullBankModels\Agencia;
use App\NullBankModels\Conta;
use App\NullBankModels\Funcionario;
use App\NullBankModels\Transacao;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BankTellerController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $bankteller = Funcionario::first($_SESSION['user_id']);

        if ($bankteller->cargo != EmployeeTypeEnum::CAIXA->value) {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $search = $request->has('search') ? $request->input('search') : null;

        $allTransactions = Transacao::allFromAgency($bankteller->agencia_id, $search);

        $agency = Agencia::first($bankteller->agencia_id);

        $accounts = Conta::allFromAgency($bankteller->agencia_id);

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

        return view('nullbank.banktellers.transactions.index')
            ->with('bankteller', $bankteller)
            ->with('transactions', $transactions)
            ->with('agency', $agency)
            ->with('accounts', $accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $bankteller = Funcionario::first($_SESSION['user_id']);

        if ($bankteller->cargo != EmployeeTypeEnum::CAIXA->value) {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $transactionDto = TransacaoDTO::fromRequest($request);
        Transacao::create($transactionDto->toArray());

        return redirect()->route('banktellers.transactions.index', $bankteller->id);
    }
}
