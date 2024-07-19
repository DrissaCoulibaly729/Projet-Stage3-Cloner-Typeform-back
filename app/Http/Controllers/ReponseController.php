<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use Illuminate\Http\Request;

class ReponseController extends Controller
{
    public function getAllReponses()
    {
        $reponses = Reponse::all();
        return response()->json($reponses);
    }

    public function getReponseById($id)
    {
        $reponse = Reponse::findOrFail($id);
        return response()->json($reponse);
    }

    public function createReponse(Request $request)
    {
        $reponse = Reponse::create($request->all());
        return response()->json($reponse, 201);
    }

    public function updateReponse(Request $request, $id)
    {
        $reponse = Reponse::findOrFail($id);
        $reponse->update($request->all());
        return response()->json($reponse, 200);
    }

    public function deleteReponse($id)
    {
        Reponse::destroy($id);
        return response()->json(null, 204);
    }
}
