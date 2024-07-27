<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function getAllWorkspaces()
    {
        $workspaces = Workspace::all();
        return response()->json($workspaces);
    }


    public function createWorkspace(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id', // Validation pour user_id
        ]);
    
        $workspace = Workspace::create([
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id'),
        ]);
    
        return response()->json($workspace, 201);
    }
    
    public function getWorkspacesByUserId($userId)
    {
        // Rechercher les workspaces par user_id
        $workspaces = Workspace::where('user_id', $userId)->get();

        // Retourner les workspaces en réponse JSON
        return response()->json($workspaces);
    }
        public function getWorkspaceById($id)
        {
            $workspace = Workspace::findOrFail($id);
            return response()->json($workspace);
        }

        public function updateWorkspace(Request $request, $id)
        {
            $workspace = Workspace::findOrFail($id);
            $workspace->update($request->all());
            return response()->json($workspace, 200);
        }

        public function deleteWorkspace($id)
        {
            Workspace::destroy($id);
            return response()->json(null, 204);
        }
}
