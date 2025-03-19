<?php

namespace Modules\Retail\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Retail\Entities\TemporarySurvey;
use Modules\Retail\Entities\Checklist;

class SurveyComponent extends Component
{
    public $categoryId;
    public $responses = [];

    public function mount($categoryId)
    {
        $this->categoryId = $categoryId;
        
        // Load existing responses if available
        $savedResponses = TemporarySurvey::where('user_id', Auth::id())
            ->where('category_id', $categoryId)
            ->first();

        if ($savedResponses) {
            $this->responses = json_decode($savedResponses->responses, true);
        }
    }

    public function updatedResponses()
    {
        TemporarySurvey::updateOrCreate(
            ['user_id' => Auth::id(), 'category_id' => $this->categoryId],
            ['responses' => json_encode($this->responses)]
        );
    }

    public function render()
    {
        return view('livewire.survey-form', [
            'checklistItems' => Checklist::where('category_id', $this->categoryId)->get(),
        ]);
    }
    
}

