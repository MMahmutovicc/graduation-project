<?php

namespace App\Http\Livewire\Admin;

use App\Models\Section;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UrediSekcijuComponent extends Component
{
    public $section_id;
    public $name;
    public $description;

    public function mount($sekcija_id)
    {
        $this->section_id = $sekcija_id;
        $sekcija = Section::find($sekcija_id);
        if($sekcija === null)
        abort(404);
        $this->name = $sekcija->name;
        $this->description = $sekcija->description;
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name' => [
                'required',
                Rule::unique('sections')->ignore($this->section_id),
                'max:100'
            ],
            'description' => 'required|max:300',
        ]);
    }

    public function updateSection()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('sections')->ignore($this->section_id),
                'max:100'
            ],
            'description' => 'required|max:300',
        ]);

        $sekcija = Section::find($this->section_id);
        $sekcija->name = $this->name;
        $sekcija->description = $this->description;
        $sekcija->save();
        session()->flash('oblast_poruka', 'Oblast je uspješno uređena');
    }

    public function render()
    {
        return view('livewire.admin.uredi-sekciju-component')->layout('layouts.base');
    }
}
