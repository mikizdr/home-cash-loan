<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientCreateRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;

class AdvisorController extends Controller
{
    /**
     * Display a paginated listing of all clients.
     */
    public function index(): Factory|View
    {
        $clients = Client::orderByDesc('id')->paginate(10);

        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): Factory|View
    {
        return view('client.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(ClientCreateRequest $request): RedirectResponse
    {
        $advisorId =  $request->user()->id;
        $client = Client::create(array_merge($request->except('_token'), [
            'advisor_id' => $advisorId
        ]));

        return redirect()->route('clients.index')
        ->with('client-action', "Client $client->first_name $client->last_name created successfully!");
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        //;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
