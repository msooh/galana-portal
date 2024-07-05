<?php

namespace Modules\Feedback\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Mail;
use Modules\Feedback\Entities\StaffFeedback;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('feedback::dashboard');
    }

    public function staffList()
    {
        $staffFeedback = StaffFeedback::select('id', 'feedbackType', 'feedback', 'created_at')->orderBy('created_at', 'desc')->get();
        
        return view('feedback::feedback.staffhistory', compact('staffFeedback'));
    }

    public function staff()
    {
        return view('feedback::feedback.staff');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('feedback::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    public function submit(Request $request)
    {
        // Validate and handle the feedback submission
        $request->validate([
            'feedbackType' => 'required|string',
            'feedback' => 'required|string',
        ]);

        // Save the feedback to the database
        $feedback = StaffFeedback::create([
            'feedbackType' => $request->feedbackType,
            'feedback' => $request->feedback,
        ]);

        /*Mail::send('feedback::emails.feedback', ['feedback' => $feedback], function ($message) {
            $message->to('faith.muthoni@galanaenergies.com')
               ->subject('New Anonymous Feedback Submitted');
        });*/

       
        
        return redirect()->back()->with('success', 'Anonymous Feedback submitted successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('feedback::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('feedback::edit');
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
