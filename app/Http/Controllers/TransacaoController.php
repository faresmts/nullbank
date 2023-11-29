<?php

namespace App\Http\Controllers;

use App\DTOs\TransacaoDTO;
use App\NullBankModels\Conta;
use App\NullBankModels\Transacao;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TransacaoController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $search = $request->has('search') ? $request->input('search') : null;

        $allTransactions = Transacao::all($search);

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($_SESSION['user_type'] == 'customer') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $transactionDto = TransacaoDTO::fromRequest($request);
        Transacao::create($transactionDto->toArray());

        return redirect()->route('transactions.index');
    }
}
