<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\LoanAmountRequest;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;

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
     * Show the form for editing the specified client.
     */
    public function edit(Client $client): Factory|View
    {
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientUpdateRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('clients.index')
            ->with('client-action', "Client $client->first_name $client->last_name updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('client-action', "Client $client->first_name $client->last_name deleted successfully.");
    }

    /**
     * Create or update a cash loan for the specified client.
     */
    public function loanCash(LoanAmountRequest $request, Client $client): RedirectResponse
    {
        try {
            $loanAmount = (float) $request->input('loan_amount');

            $client->cashLoanProduct()->updateOrCreate(
                [
                    'client_id' => $client->id
                ],
                [
                    'loan_amount' => $loanAmount,
                ]
            );

            return back()
                ->with('client-action', "Cash loan of the client $client->first_name $client->last_name's created successfully!");
        } catch (\Exception $e) {
            return back()
                ->with('client-error', "Client $client->first_name $client->last_name cash loan creation failed: {$e->getMessage()}.");
        }
    }
}
