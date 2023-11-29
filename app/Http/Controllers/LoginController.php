<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\EmployeeLoginRequest;
use App\Http\Requests\LoginRequest;
use App\NullBankModels\Agencia;
use App\NullBankModels\Conta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function admin(AdminLoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $data['user'];
        $password = $data['password'];

        if ($user === 'Admin' && $password === 'Root') {
            if (!isset($_SESSION)){
                session_start();
            }

            $_SESSION['user_id'] = 'admin';
            $_SESSION['user_type'] = 'admin';

            return redirect()->route('home');
        }

        Session::flash('error', 'Credenciais de Administrador inválidas.');

        return redirect()->route('admin');
    }

    public function employee(EmployeeLoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $matricula = $data['matricula'];
        $password = $data['password'];

        $query = "
            SELECT * FROM funcionarios WHERE matricula = '$matricula'
        ";

        $result = DB::select($query);

        if (count($result) == 1) {
            $user = $result[0];

            if (Hash::check($password, $user->senha)) {
                if (!isset($_SESSION)){
                    session_start();
                }

                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_type'] = 'employee';

                return redirect()->route('home');
            }
        }

        Session::flash('error', 'Credenciais de Funcionário inválidas.');

        return redirect()->route('employee');
    }

    public function login(LoginRequest $request): RedirectResponse|View
    {
        $data = $request->validated();
        $cpf = str_replace(['.', '-'], '', $data['cpf']);
        $password = $data['password'];

        $query = "
            SELECT * FROM clientes
            INNER JOIN usuarios ON clientes.usuario_id = usuarios.id
            WHERE cpf = '$cpf'
        ";

        $result = DB::select($query);

        if (count($result) == 1) {
            $user = $result[0];

            if (Hash::check($password, $user->password)) {
                if (!isset($_SESSION)){
                    session_start();
                }

                $_SESSION['user_id'] = $user->cpf;
                $_SESSION['user_type'] = 'customer';

                $query = "
                    SELECT cliente_cpf, conta_id, agencia_id
                    FROM cliente_conta
                    WHERE cliente_cpf = '$cpf'
                ";

                $accounts = DB::select($query);

                if (count($accounts) == 1) {
                    $account = Conta::first($accounts[0]->conta_id);
                    $_SESSION['account'] = $account;
                    return view('nullbank.home')
                        ->with('account', $account);
                }

                if (count($accounts) == 2) {
                    $acccount1Id = $accounts[0]->conta_id;
                    $acccount2Id = $accounts[1]->conta_id;

                    $query = "
                        SELECT * FROM contas WHERE id IN ($acccount1Id, $acccount2Id)
                    ";

                    $accountsReal = DB::select($query);

                    return view('nullbank.select-contas')
                        ->with('accounts', $accountsReal);
                }

                Session::flash('error', 'Usuário sem contas. Fale agora com seu gerente na agência mais próxima!');

                return redirect()->route('customer');
            }
        }

        return redirect()->route('customer');
    }

    public function accountSelected(string $accountId): View
    {
        $account = Conta::first($accountId);
        $_SESSION['account'] = $account;

        return view('nullbank.home')
            ->with('account', $account);
    }

    public function logout(): RedirectResponse
    {
        if (!isset($_SESSION)){
            session_start();
        }

        $type = $_SESSION['user_type'];

        session_destroy();

        return match ($type) {
            'customer' => redirect()->route('customer'),
            'employee' => redirect()->route('employee'),
            'admin' => redirect()->route('admin'),
        };
    }

}
