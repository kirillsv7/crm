<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateClientRequest;
use App\Http\Resources\V1\Client\ListResource as ClientListResource;
use App\Http\Resources\V1\Client\Resource as ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ClientResource::collection(
            Client::query()
                  ->paginate()
        );
    }

    public function store(CreateUpdateClientRequest $request): ClientResource
    {
        $this->authorize('create', Client::class);

        $client = Client::create($request->validated());

        return new ClientResource($client);
    }

    public function show(Client $client): ClientResource
    {
        return new ClientResource($client);
    }

    public function update(CreateUpdateClientRequest $request, Client $client): ClientResource
    {
        $this->authorize('update', $client);

        $client->update($request->validated());

        return new ClientResource($client);
    }

    public function destroy(Client $client): JsonResponse
    {
        $this->authorize('delete', $client);

        $client->delete();

        return response()->json(['message' => 'Client deleted']);
    }

    public function deleted(): AnonymousResourceCollection
    {
        return ClientResource::collection(
            Client::query()
                  ->onlyTrashed()
                  ->paginate()
        );
    }

    public function restore($id): JsonResponse
    {
        $client = Client::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $client);

        $client->restore();

        return response()->json(['message' => 'Client restored']);
    }

    public function list(): AnonymousResourceCollection
    {
        return ClientListResource::collection(
            Client::query()
                  ->select(['id', 'company'])
                  ->get()
        );
    }
}