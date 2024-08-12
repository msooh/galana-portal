<?php

namespace Modules\Foundation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Foundation\Entities\Student;
use Modules\Foundation\Entities\School;
use Modules\Foundation\Entities\BankDetail;

class BankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bankDetails = BankDetail::with('student')->get();
        $students = Student::all(); 
        return view('foundation::accounts.bank-details', compact('bankDetails', 'students'));
       
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //$students = Student::all(); 
       // return view('foundation::bank-details.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'bank' => 'required|string|max:255',
            'account_no' => 'required|string|max:255',
            'account_name' => 'required|string',
            'branch' => 'required|string|max:255',
        ]);

        BankDetail::create([
            'student_id' => $request->input('student_id'),
            'bank' => $request->input('bank'),
            'account_no' => $request->input('account_no'),
            'account_name' => $request->input('account_name'),
            'branch' => $request->input('branch'),
        ]);

        return redirect()->route('bank-details.index')->with('success', 'Bank detail added successfully.');
  
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
    public function update(Request $request, BankDetail $bankDetail)
    {
        $request->validate([            
            'bank' => 'required|string|max:255',
            'account_no' => 'required|string|max:255',
            'account_name' => 'required|string',
            'branch' => 'required|string|max:255',
        ]);

        $bankDetail->update([           
            'bank' => $request->input('bank'),
            'account_no' => $request->input('account_no'),
            'account_name' => $request->input('account_name'),
            'branch' => $request->input('branch'),
        ]);

        return redirect()->route('bank-details.index')->with('success', 'Bank detail updated successfully.');
    
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(BankDetail $bankDetail)
    {
        $bankDetail->delete();
        return redirect()->route('bank-details.index')->with('success', 'Bank detail deleted successfully.');
  
    }
}
