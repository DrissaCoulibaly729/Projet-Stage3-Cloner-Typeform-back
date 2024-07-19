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
            $workspace = Workspace::create($request->all());
            return response()->json($workspace, 201);
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
