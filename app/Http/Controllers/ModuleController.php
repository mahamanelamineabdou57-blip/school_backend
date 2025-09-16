<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        return Module::with('enseignant', 'section', 'notes', 'inscription')->get();
    }

    public function show($id)
    {
        return Module::with('enseignant', 'section', 'notes', 'inscription')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'section_module_id' => 'required|exists:section_modules,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'credits' => 'required|integer',
            'volume_horaire' => 'required|integer',
        ]);

        return Module::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $module->update($request->all());
        return $module;
    }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();
        return response()->noContent();
    }
}
