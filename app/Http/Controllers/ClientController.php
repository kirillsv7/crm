<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        $title = 'Client list';

        return view('client.index', compact('title', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Client::class);

        $title = 'Client create';

        return view('client.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateClientRequest  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateUpdateClientRequest $request)
    {
        $this->authorize('create', Client::class);

        Client::create($request->validated());

        return redirect(route('client.index'))->with('created', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Client $client)
    {
        $this->authorize('update', $client);

        $title = 'Client edit: '.$client->company;

        return view('client.edit', compact('title', 'client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateClientRequest  $request
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateUpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);

        $client->update($request->validated());

        return redirect(route('client.edit', $client->id))->with('updated', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('delete', $id);

        Client::destroy([$id]);

        return redirect(route('client.index'))->with('deleted', true);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $clients = Client::onlyTrashed()->get();

        $title = 'Deleted clients list';

        return view('client.deleted', compact('title', 'clients'));
    }

    /**
     * Restore the specified resource to storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore($id)
    {
        $this->authorize('restore', $id);

        Client::withTrashed()->where('id', $id)->restore();

        return redirect(route('client.deleted'))->with('restored', true);
    }
}
