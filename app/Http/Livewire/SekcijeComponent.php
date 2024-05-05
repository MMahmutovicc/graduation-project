<?php

namespace App\Http\Livewire;

use App\Models\Section;
use Livewire\Component;

class SekcijeComponent extends Component
{
    public function render()
    {
        $sekcije = Section::all();
        return view('livewire.sekcije-component', ['sekcije' => $sekcije])->layout('layouts.base');
    }

    public function deleteSection($id)
    {
        $sek = Section::find($id);
        $sek->delete();
    }
}
