<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the academic years.
     */
    public function index()
    {
        return response()->json(AcademicYear::all());
    }

    /**
     * Display the specified academic year.
     */
    public function show($id)
    {
        try {
            $academicYear = AcademicYear::with(['inscriptions', 'notes'])->findOrFail($id);
            return response()->json($academicYear);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Academic year not found'], 404);
        }
    }

    /**
     * Store a newly created academic year in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:10',
            'actif' => 'required|bool',
            'description' => 'required|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $academicYear = AcademicYear::create($request->all());

        return response()->json($academicYear, 201);
    }

    /**
     * Update the specified academic year in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $academicYear = AcademicYear::findOrFail($id);

            $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:10|unique:academic_years,nom,' . $id,
            'actif' => 'required|bool',
            'description' => 'required|nullable',
        ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $academicYear->update($request->all());

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Academic year not found'], 404);
        }
    }

    /**
     * Remove the specified academic year from storage.
     */
    public function destroy($id)
    {
        try {
            $academicYear = AcademicYear::findOrFail($id);

            // Check if the academic year is referenced by inscriptions or notes
            if ($academicYear->inscriptions()->exists() || $academicYear->notes()->exists()) {
                return response()->json(['error' => 'Cannot delete academic year because it is referenced by inscriptions or notes'], 400);
            }

            $academicYear->delete();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Academic year not found'], 404);
        }
    }
}
