<?php

namespace App\Http\Controllers;

use App\DTOs\AgenciaDTO;
use App\DTOs\EnderecoDTO;
use App\NullBankModels\Agencia;
use App\NullBankModels\Endereco;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AgenciaController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $streetTypes = Endereco::getLogradourosTipos();

        $search = $request->has('search') ? $request->input('search') : null;

        $allAgencies = Agencia::all($search);

        $perPage = $request->input('perPage', 10);

        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = $allAgencies->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $agencies = new LengthAwarePaginator(
            $currentPageItems,
            $allAgencies->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('nullbank.agencies.index')
            ->with('streetTypes', $streetTypes)
            ->with('agencies', $agencies);
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

            $agencyDto = AgenciaDTO::fromRequest($request);
            $agencyDto->endereco_id = $address->id;
            Agencia::create($agencyDto->toArray());
        DB::commit();

        return redirect()->route('agencies.index');
    }

    public function edit(string $id): View|RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $agency = Agencia::first($id);
        $streetTypes = Endereco::getLogradourosTipos();

        return view('nullbank.agencies.edit')
            ->with('streetTypes', $streetTypes)
            ->with('agency', $agency);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $agency = Agencia::first($id);

        DB::beginTransaction();

            $addressDto = EnderecoDTO::fromRequest($request);
            $address = Endereco::first($agency->endereco_id);
            $address->update($addressDto->toArray());


            $agencyDto = AgenciaDTO::fromRequest($request);
            $agencyDto->endereco_id = $address->id;
            $agency->update($agencyDto->toArray());
        DB::commit();

        return redirect()->route('agencies.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        if ($_SESSION['user_type'] != 'admin') {
            Session::flash('error', 'Acesso não permitido!');
            return redirect()->route('home');
        }

        $agency = Agencia::first($id);
        $agency->delete();

        return redirect()->route('agencies.index');
    }
}
