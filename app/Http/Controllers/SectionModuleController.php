<?php

namespace App\Http\Controllers;

use App\Models\SectionModule;
use Illuminate\Http\Request;

class SectionModuleController extends Controller
{
    public function index()
    {
        return SectionModule::with('section', 'module')->get();
    }

    public function show($id)
    {
        return SectionModule::with('section', 'module')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'module_id' => 'required|exists:modules,id',
        ]);

        return SectionModule::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $sm = SectionModule::findOrFail($id);
        $sm->update($request->all());
        return $sm;
    }

    public function destroy($id)
    {
        $sm = SectionModule::findOrFail($id);
        $sm->delete();
        return response()->noContent();
    }
}
