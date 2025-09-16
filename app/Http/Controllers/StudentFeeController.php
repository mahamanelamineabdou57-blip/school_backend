<?php

namespace App\Http\Controllers;

use App\Models\StudentFee;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    public function index()
    {
        return StudentFee::with('etudiant', 'fee')->get();
    }

    public function show($id)
    {
        return StudentFee::with('etudiant', 'fee')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'fee_id' => 'required|exists:fees,id',
            'paid_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,partial',
            'payment_date' => 'nullable|date',
        ]);

        return StudentFee::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $sf = StudentFee::findOrFail($id);
        $sf->update($request->all());
        return $sf;
    }

    public function destroy($id)
    {
        $sf = StudentFee::findOrFail($id);
        $sf->delete();
        return response()->noContent();
    }
}
