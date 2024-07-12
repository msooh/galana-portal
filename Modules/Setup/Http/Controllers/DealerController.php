<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Setup\Entities\Dealer;
use Modules\Setup\Entities\Station;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealers = User::whereHas('roles', function($query) {
            $query->where('name', 'Dealer');
        })->get();
    
        // Debugging: Output the roles of each user
        foreach ($dealers as $dealer) {
            $roles = $dealer->roles->pluck('name');
            logger()->info("User {$dealer->id} roles: " . $roles->implode(', '));
        }    

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8',           
        ]);

        // Create the new user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->password = Hash::make($validatedData['password']);
        // Save the dealer
        $user->save();      
        
        // Assign 'Dealer' role to the user
        $dealerRole = Role::where('name', 'Dealer')->first();
        if ($dealerRole) {
            $user->roles()->attach($dealerRole->id);
        }
    
        
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
      $dealer = User::findOrFail($id);
    
      $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
   
        // Update the dealer information based on the request data
        $dealer->update([       
            'name' => $request->name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'updated_by' => auth()->id(),       
        ]);   
     
    
      // Redirect back to the dealer list or desired location
      return redirect()->route('dealers.index')->with('success', 'Dealer updated successfully');
    }

    public function deactivate($id)
    {
        $dealer = User::findOrFail($id);
        $dealer->is_active = false;
        $dealer->save();

        return redirect()->route('dealers.index')->with('success', 'Dealer deactivated successfully');
    }


    public function activate($id)
    {
        $dealer = User::findOrFail($id);
        $dealer->is_active = true;
        $dealer->save();
        
        return redirect()->route('dealers.index')->with('success', 'Dealer activated successfully');
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
         // Delete the dealer
         $user->delete();

         // Redirect to the index page with success message
         return redirect()->route('setup::dealers.index')->with('success', 'Dealer deleted successfully');
    
    }
}
