<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModuleController extends Controller
{
    public function index()
    {
        return response()->json(Module::with('unite_enseignements')->get());
    }

    public function show($id)
    {
        return response()->json(Module::with('unite_enseignements')->findOrFail($id));
        //
        // return Module::with('unite_enseignements')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'credits' => 'required|integer',
            'ue_id' => 'required|exists:unite_enseignements,id',
        ]);
        // dd($request->all());
        return Module::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'credits' => 'required|integer',
            'ue_id' => 'required|exists:unite_enseignements,id',
        ]);
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
    public function getByUE($ueId) {
        $ecues = Module::where('ue_id', $ueId)->get();
        return response()->json($ecues);
    }
}
