<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddResponseToTaskRequest;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{

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

        Response::destroy([$id]);

        return redirect()->back()->with('responseDeleted', true);
    }
}
