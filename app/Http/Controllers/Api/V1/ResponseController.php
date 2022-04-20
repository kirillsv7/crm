<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ResponseResource;
use App\Models\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResponseController extends Controller
{

    public function destroy(Response $response): JsonResponse
    {
        $this->authorize('delete', $response);

        $response->delete();

        return response()->json(['message' => 'Response deleted']);
    }

    public function latest(): AnonymousResourceCollection
    {
        return ResponseResource::collection(
            Response::with(['task:id,title', 'user:id,name'])
                    ->without('media')
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get()
        );
    }
}
