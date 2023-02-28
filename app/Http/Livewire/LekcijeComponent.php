<?php

namespace App\Http\Livewire;

use App\Models\Lecture;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;
use File;

class LekcijeComponent extends Component
{
    use WithPagination;

    public $sekcija;

    public function mount($sekcija_id)
    {
        $this->sekcija = Section::find($sekcija_id);
        if($this->sekcija === null)
        abort(404);
    }

    public function render()
    {
        return view('livewire.lekcije-component')->layout('layouts.base');
    }

    public function deleteLecture($id)
    {
        $lekcija = Lecture::find($id);
        foreach($lekcija->primjeri as $primjer)
        {
            if(file_exists(public_path('storage/examples'.'/'.$primjer->photo)))
            {
                unlink(public_path('storage/examples'.'/'.$primjer->photo));
            }
        }
        $lekcija->delete();
    }
}