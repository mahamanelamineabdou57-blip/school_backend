<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //
    public function index()
    {
        return response()->json(Log::all(), 200);
    }
    public function show($id)
    {
        $log = Log::find($id);
        if ($log) {
            return response()->json($log, 200);
        } else {
            return response()->json(['message' => 'Log not found'], 404);
        }
    }
    public function store(Request $request)
    {
        
        $log = Log::create($request->all());
        return response()->json($log, 201);
    }
    public function update(Request $request, $id)
    {
        $log = Log::find($id);
        if ($log) {
            $log->update($request->all());
            return response()->json($log, 200);
        } else {
            return response()->json(['message' => 'Log not found'], 404);
        }
    }
    public function destroy($id)
    {
        $log = Log::find($id);
        if ($log) {
            $log->softDelete();
            return response()->json(['message' => 'Log deleted'], 200);
        } else {
            return response()->json(['message' => 'Log not found'], 404);
        }
    }
}
