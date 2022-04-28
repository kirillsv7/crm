<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Response\LatestResource as ResponseLatestResource;
use App\Http\Resources\V1\Response\Resource as ResponseResource;
use App\Models\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResponseController extends Controller
{

    public function getByTask($taskId): AnonymousResourceCollection
    {
        return ResponseResource::collection(
            Response::query()
                    ->where('task_id', $taskId)
                    ->with(['user:id,name', 'media'])
                    ->orderByDesc('id')
                    ->paginate()
                    ->withQueryString()
        );
    }

    public function destroy(Response $response): JsonResponse
    {
        $this->authorize('delete', $response);

        $response->delete();

        return response()->json(['message' => 'Response deleted']);
    }

    public function latest(): AnonymousResourceCollection
    {
        return ResponseLatestResource::collection(
            Response::with(['task:id,title', 'user:id,name,deleted_at'])
                    ->without('media')
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get()
        );
    }
}
