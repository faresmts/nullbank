<?php

namespace App\Http\Controllers;

use App\DTOs\DependenteDTO;
use App\DTOs\EnderecoDTO;
use App\DTOs\FuncionarioDTO;
use App\DTOs\UsuarioDTO;
use App\NullBankModels\Agencia;
use App\NullBankModels\Dependente;
use App\NullBankModels\Endereco;
use App\NullBankModels\Funcionario;
use App\NullBankModels\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DependenteController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $search = $request->has('search') ? $request->input('search') : null;

        $allDependants = Dependente::all($search);

        $employees = Funcionario::all();

        $perPage = $request->input('perPage', 10);

        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = $allDependants->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $dependants = new LengthAwarePaginator(
            $currentPageItems,
            $allDependants->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('nullbank.dependants.index')
            ->with('dependants', $dependants)
            ->with('employees', $employees);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $dependantDto = DependenteDTO::fromRequest($request);
        Dependente::create($dependantDto->toArray());

        return redirect()->route('dependants.index');
    }

    public function edit(string $id): View|RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $employees = Funcionario::all();
        $dependant = Dependente::first($id);

        return view('nullbank.dependants.edit')
            ->with('dependant', $dependant)
            ->with('employees', $employees);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $dependant = Dependente::first($id);
        $dependantDto = DependenteDTO::fromRequest($request);
        $dependant->update($dependantDto->toArray());

        return redirect()->route('dependants.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $dependant = Dependente::first($id);
        $dependant->delete();

        return redirect()->route('dependants.index');
    }
}
