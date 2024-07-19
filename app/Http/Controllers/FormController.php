<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function getAllForms()
    {
        $forms = Form::all();
        return response()->json($forms);
    }

    public function getFormById($id)
    {
        $form = Form::findOrFail($id);
        return response()->json($form);
    }

    public function createForm(Request $request)
    {
        $form = Form::create($request->all());
        return response()->json($form, 201);
    }

    public function updateForm(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $form->update($request->all());
        return response()->json($form, 200);
    }

    public function deleteForm($id)
    {
        Form::destroy($id);
        return response()->json(null, 204);
    }
}
