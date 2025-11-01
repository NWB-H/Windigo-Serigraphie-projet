<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        return response()->json(Option::all());
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
        ]);

        $option = Option::create($formFields);

        return response()->json($option);
    }

    public function show($id)
    {
        $option = Option::findOrFail($id);
        return response()->json($option);
    }

    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'name' => 'string',
        ]);

        $option = Option::findOrFail($id);
        $option->fill($formFields);
        $option->save();

        return response()->json($option);
    }

    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();

        return response()->json(['success' => true]);
    }
}
