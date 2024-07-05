<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Setup\Entities\Dealer;
use Modules\Setup\Entities\Station;
use App\Models\User;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealers = Dealer::all();

        // Return view with dealers data
        return view('setup::dealers.index', compact('dealers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setup::dealers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validate the incoming request data
         $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:dealers,email',
        ]);

        // Create a new dealer with validated data
        $dealer = new Dealer([
            'name' => $validatedData['name'],
            'company_name' => $validatedData['company_name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'created_by' => Auth::id(), 
        ]);
    
        // Save the dealer
        $dealer->save();
        // Redirect to the index page with success message
        return redirect()->route('dealers.index')->with('success', 'Dealer created successfully');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('setup::dealers.edit', compact('dealer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // Find the dealer with the given ID
      $dealer = Dealer::findOrFail($id);
    
      $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
    ]);
   
      // Update the dealer information based on the request data
      $dealer->update([
        'company_name' => $request->company_name,
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'updated_by' => auth()->id(),       
      ]);   
     
    
      // Redirect back to the dealer list or desired location
      return redirect()->route('dealers.index')->with('success', 'Dealer updated successfully');
    }

    public function deactivate($id)
    {
        $dealer = Dealer::findOrFail($id);
        $dealer->active = false;
        $dealer->save();

        return redirect()->route('dealers.index')->with('success', 'Dealer deactivated successfully');
    }


    public function activate($id)
    {
        $dealer = Dealer::findOrFail($id);
        $dealer->active = true;
        $dealer->save();
        
        return redirect()->route('dealers.index')->with('success', 'Dealer activated successfully');
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealer $dealer)
    {
         // Delete the dealer
         $dealer->delete();

         // Redirect to the index page with success message
         return redirect()->route('setup::dealers.index')->with('success', 'Dealer deleted successfully');
    
    }
}
