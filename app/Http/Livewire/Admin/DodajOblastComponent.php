<?php

namespace App\Http\Livewire\Admin;

use App\Models\Section;
use Livewire\Component;

class DodajOblastComponent extends Component
{
    public $name;
    public $description;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name' => 'required|unique:sections,name|max:100',
            'description' => 'required|max:300|min:150'
        ]);
    }

    public function addSection()
    {
        $this->validate([
            'name' => 'required|unique:sections,name|max:100',
            'description' => 'required|max:300|min:150'
        ]);
        $section = new Section();
        $section->name = $this->name;
        $section->description = $this->description;
        $section->save();
        session()->flash('oblast_poruka', 'Uspješno ste dodali novu oblast');
    }

    public function render()
    {
        return view('livewire.admin.dodaj-oblast-component')->layout('layouts.base');
    }
}
