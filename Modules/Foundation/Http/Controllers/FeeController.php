<?php

namespace Modules\Foundation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Foundation\Entities\Fee;
use Modules\Foundation\Entities\School;
use Modules\Foundation\Entities\Student;
use Modules\Foundation\Entities\OtherPayment;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $fees = Fee::with('student')->get(); 
        $students = Student::all(); 

        return view('foundation::accounts.fees', compact('fees', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //return view('foundation::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'year' => 'required|in:1,2,3,4',
            'total_fees' => 'required|numeric',
            'term_one_fees' => 'required|numeric',
            'term_two_fees' => 'required|numeric',
            'term_three_fees' => 'required|numeric',
            'status' => 'required|in:paid,unpaid',
            'uniform_others_amount' => 'nullable|numeric',
            'mode_of_payment' => 'nullable|string|max:255',
            'purpose' => 'nullable|array',
            'amount' => 'nullable|array',
        ]);

        $fee = Fee::create($validatedData);

        // Save additional payments
        if ($request->filled('purpose')) {
            foreach ($request->purpose as $index => $purpose) {
                if (!empty($purpose) && !empty($request->amount[$index])) {
                    OtherPayment::create([
                        'fee_id' => $fee->id,
                        'purpose' => $purpose,
                        'amount' => $request->amount[$index],
                    ]);
                }
            }
        }

        return redirect()->route('fees.index')->with('success', 'Fee payment created successfully.');
   
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        //return view('foundation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        //return view('foundation::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'year' => 'required|in:1,2,3,4',
            'total_fees' => 'required|numeric',
            'term_one_fees' => 'required|numeric',
            'term_two_fees' => 'required|numeric',
            'term_three_fees' => 'required|numeric',
            'status' => 'required|in:paid,unpaid',
            'uniform_others_amount' => 'nullable|numeric',
            'mode_of_payment' => 'nullable|string|max:255',
            'purpose' => 'nullable|array',
            'amount' => 'nullable|array',
        ]);

        $fee->purposes()->delete();

        if ($request->has('purpose')) {
            foreach ($request->purpose as $index => $purpose) {
                $fee->purposes()->create([
                    'purpose' => $purpose,
                    'amount' => $request->amount[$index],
                ]);
            }
        }

        return redirect()->route('fees.index')->with('success', 'Fee payment updated successfully.');
    
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $fee->delete();

        return redirect()->route('fees.index')->with('success', 'Fee payment deleted successfully.');
   
    }
}
