<?php

namespace Modules\Suggestion\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Suggestion\Entities\Suggestion;
use Illuminate\Support\Facades\Storage;


class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('suggestion::index');
    }

    public function dashboard()
    {
        $suggestions = Suggestion::orderBy('created_at', 'desc')->take(15)->get();
       
        return view('suggestion::dashboard', compact('suggestions'));
    }

    public function history()
    {
        $suggestions = Suggestion::orderBy('created_at', 'desc')->get();
        return view('suggestion::history', compact('suggestions'));
    }

    public function getAttachment($filename)
    {
        $path = storage_path('app/attachments/' . $filename);
        
        if (file_exists($path)) {
            return response()->file($path);
        } else {
            abort(404);
        }
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('suggestion::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'suggestionType' => 'required|string',
            'department' => 'nullable|string',
            'suggestion' => 'required|string',
            'attachment' => 'nullable|file|max:8192', 
            'anonymous' => 'required|string|in:Remain Anonymous,Not Anonymous',
            'name' => 'nullable|required_if:anonymous,Not Anonymous|string',
            'email' => 'nullable|required_if:anonymous,Not Anonymous|email',
        ]);

        // Create a new Suggestion instance
        $suggestion = new Suggestion();
        $suggestion->suggestionType = $validatedData['suggestionType'];
        $suggestion->department = $validatedData['department'];
        $suggestion->suggestion = $validatedData['suggestion'];
        $suggestion->anonymous = $validatedData['anonymous'];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('attachments'), $filename);
            $suggestion->attachment = 'attachments/' . $filename;
        }

        // If anonymous is Not Anonymous, then store name and email
        if ($validatedData['anonymous'] === 'Not Anonymous') {
            $suggestion->name = $validatedData['name'];
            $suggestion->email = $validatedData['email'];
        }

        // Save the suggestion
        $suggestion->save();

        // Redirect to thank you page
        return redirect()->route('suggestion.thankyou');
   
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('suggestion::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('suggestion::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
