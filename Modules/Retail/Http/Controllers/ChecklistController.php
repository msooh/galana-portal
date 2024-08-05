<?php


namespace Modules\Retail\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Retail\Entities\Checklist;
use Modules\Retail\Entities\Category;
use Modules\Retail\Entities\Subcategory;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::with('subcategory.category')->get();
       
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('retail::checklists.index', compact('checklists', 'categories', 'subcategories'));
    }

    public function categories()
    {       
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('retail::checklists.categories', compact('categories', 'subcategories'));
    }



    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('retail::checklists.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:1000',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        Checklist::create([
            'name' => $request->name,
            'sub_category_id' => $request->subcategory_id,
        ]);

        return redirect()->route('checklists.index')->with('success', 'Checklist item created successfully.');
    }

    public function show()

    {

    }

    public function update(Request $request, Checklist $checklist)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:1000',            
        ]);

        $checklist->update([
            'name' => $validatedData['name'],            
            'updated_by' => Auth::id(), 
        ]);

        return redirect()->back()->with('success', 'Checklist item updated successfully.');
    }

    public function destroy(Checklist $checklist)
    {
        $checklist->delete();

        return redirect()->back()->with('success', 'Checklist item deleted successfully.');
    }
}
