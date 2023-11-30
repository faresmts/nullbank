<?php

namespace App\Http\Controllers;

use App\DTOs\AgenciaDTO;
use App\DTOs\EnderecoDTO;
use App\DTOs\FuncionarioDTO;
use App\DTOs\UsuarioDTO;
use App\NullBankModels\Agencia;
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

class FuncionarioController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $search = $request->has('search') ? $request->input('search') : null;

        $allEmployees = Funcionario::all($search);

        $agencies = Agencia::all();

        $streetTypes = Endereco::getLogradourosTipos();

        $perPage = $request->input('perPage', 10);

        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = $allEmployees->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $employees = new LengthAwarePaginator(
            $currentPageItems,
            $allEmployees->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('nullbank.employees.index')
            ->with('streetTypes', $streetTypes)
            ->with('agencies', $agencies)
            ->with('employees', $employees);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        DB::beginTransaction();
            $addressDto = EnderecoDTO::fromRequest($request);
            $address = Endereco::create($addressDto->toArray());

            $userDto = UsuarioDTO::fromRequest($request);
            $userDto->endereco_id = $address->id;
            $user = Usuario::create($userDto->toArray());

            $employeeDto = FuncionarioDTO::fromRequest($request);
            $employeeDto->usuario_id = $user->id;
            Funcionario::create($employeeDto->toArray());
        DB::commit();

        return redirect()->route('employees.index');
    }

    public function edit(string $id): View|RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $employee = Funcionario::first($id);
        $streetTypes = Endereco::getLogradourosTipos();
        $agencies = Agencia::all();

        return view('nullbank.employees.edit')
            ->with('streetTypes', $streetTypes)
            ->with('agencies', $agencies)
            ->with('employee', $employee);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $employee = Funcionario::first($id);
        $user = Usuario::first($employee->usuario_id);
        $address = Endereco::first($user->endereco_id);

        DB::beginTransaction();
            $addressDto = EnderecoDTO::fromRequest($request);
            $address->update($addressDto->toArray());

            $userDto = UsuarioDTO::fromRequest($request);
            $userDto->endereco_id = $address->id;
            $user->update($userDto->toArray());

            $employeeDto = FuncionarioDTO::fromRequest($request);
            $employeeDto->usuario_id = $user->id;
            $employee->update($employeeDto->toArray());
        DB::commit();

        return redirect()->route('employees.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $employee = Funcionario::first($id);
        $employee->delete();

        return redirect()->route('employees.index');
    }
}
