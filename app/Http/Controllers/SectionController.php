<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        return Section::with('departement', 'sectionModules', 'inscriptions', 'notes')->get();
    }

    public function show($id)
    {
        return Section::with('departement', 'sectionModules', 'inscriptions', 'notes')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'departement_id' => 'required|exists:departements,id',
        ]);

        return Section::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $section->update($request->all());
        return $section;
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->noContent();
    }
}
