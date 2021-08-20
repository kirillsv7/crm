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
     */
    public function create()
    {
        $title = 'Client create';

        return view('client.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateClientRequest $request)
    {
        Client::create($request->validated());

        return redirect(route('client.index'))->with('created', true);;
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
     */
    public function edit(Client $client)
    {
        $title = 'Client edit: '.$client->company;

        return view('client.edit', compact('title', 'client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateClientRequest  $request
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect(route('client.edit', $client->id))->with('updated', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
     */
    public function restore($id)
    {
        Client::withTrashed()->where('id', $id)->restore();

        return redirect(route('client.deleted'))->with('restored', true);
    }
}
