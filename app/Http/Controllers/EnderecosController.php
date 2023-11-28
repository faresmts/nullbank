<?php

namespace App\Http\Controllers;

use App\DTOs\EnderecoDTO;
use App\NullBankModels\Endereco;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;

class EnderecosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $streetTypes = Endereco::getLogradourosTipos();
        $allAddresses = Endereco::all();

        $perPage = $request->input('perPage', 10);

        $currentPage = Paginator::resolveCurrentPage();
        $currentPageItems = $allAddresses->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $addresses = new LengthAwarePaginator(
            $currentPageItems,
            $allAddresses->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('nullbank.addresses.index')
            ->with('streetTypes', $streetTypes)
            ->with('addresses', $addresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $addressDto = EnderecoDTO::fromRequest($request);
        Endereco::create($addressDto->toArray());

        return redirect()->route('addresses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $streetTypes = Endereco::getLogradourosTipos();
        $address = Endereco::first($id);

        return view('nullbank.addresses.edit')
            ->with('streetTypes', $streetTypes)
            ->with('address', $address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $address = Endereco::first($id);
        $addressDto = EnderecoDTO::fromRequest($request);
        $address->update($addressDto->toArray());

        return redirect()->route('addresses.index');
    }
}
