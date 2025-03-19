<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Role;
use Modules\Training\Entities\Training;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function dashboard()
    {
        // Fetch all trainings
        $totalTrainings = Training::count();
        $totalTrainees = Training::distinct('user_id')->count('user_id');

        // Get training data grouped by month
        $trainingsPerDay = Training::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy(DB::raw('DATE(created_at)')) 
            ->pluck('count', 'date')
            ->toArray();
        $trainingsPerMonth = Training::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
        $trainingsPerYear = Training::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        // Calculate completed and pending trainings
        $completedTrainings = Training::where('end_date', '<', Carbon::today())->count();
        $pendingTrainings = Training::where('end_date', '>=', Carbon::today())->count();

        // Calculate percentage changes
        $previousTotalTrainings = Training::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()->startOfMonth()])->count();
        $trainingPercentageChange = $previousTotalTrainings > 0 ? (($totalTrainings - $previousTotalTrainings) / $previousTotalTrainings) * 100 : 0;

        $previousTotalTrainees = Training::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()->startOfMonth()])->distinct('user_id')->count('user_id');
        $traineesPercentageChange = $previousTotalTrainees > 0 ? (($totalTrainees - $previousTotalTrainees) / $previousTotalTrainees) * 100 : 0;

        $previousCompletedTrainings = Training::where('end_date', '<', Carbon::today()->subMonth())->count();
        $completedPercentage = $previousCompletedTrainings > 0 ? (($completedTrainings - $previousCompletedTrainings) / $previousCompletedTrainings) * 100 : 0;

        $previousPendingTrainings = Training::where('end_date', '>=', Carbon::today()->subMonth())->count();
        $pendingPercentage = $previousPendingTrainings > 0 ? (($pendingTrainings - $previousPendingTrainings) / $previousPendingTrainings) * 100 : 0;

        // Prepare data for the view
        $dashboardData = [
            'trainingsPerDay' => $trainingsPerDay,
            'trainingsPerMonth' => $trainingsPerMonth,
            'trainingsPerYear' => $trainingsPerYear,
            'totalTrainings' => $totalTrainings,
            'trainingPercentageChange' => $trainingPercentageChange,
            'totalTrainees' => $totalTrainees,
            'traineesPercentageChange' => $traineesPercentageChange,
            'completedTrainings' => $completedTrainings,
            'completedPercentage' => $completedPercentage,
            'pendingTrainings' => $pendingTrainings,
            'pendingPercentage' => $pendingPercentage,
        ];

        return view('training::dashboard', compact('dashboardData'));
    }
     public function index()
    {
        $user = Auth::user();

        if (Gate::allows('view_all_trainings')) {
            $trainings = Training::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            $trainings = Training::with('user')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }
        return view('training::index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $employees = User::all();
        return view('training::create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'training_facility' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cost' => 'required|numeric|min:0',
            'certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $certificatePath = $request->file('certificate') 
            ? $request->file('certificate')->store('certificates', 'public') 
            : null;

        Training::create([
            'user_id' => $request->user_id,
            'training_facility' => $request->training_facility,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'cost' => $request->cost,
            'certificate' => $certificatePath,
        ]);
        return redirect()->route('training.index')->with('success', 'Training record added successfully.');
   

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('training::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('training::edit');
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
        if ($training->certificate) {
            Storage::disk('public')->delete($training->certificate);
        }
        $training->delete();
    }
}
