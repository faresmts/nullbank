<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\EmployeeLoginRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

                return redirect()->route('home');
            }
        }

        Session::flash('error', 'Credenciais de Funcionário inválidas.');

        return redirect()->route('admin');
    }

    public function login(LoginRequest $request): RedirectResponse
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

                return redirect()->route('home');
            }
        }

        return redirect()->route('login');
    }

}
