<?php

namespace App\Http\Livewire\Admin;

use App\Models\SchoolClass;
use Livewire\Component;

class DodajRazredComponent extends Component
{
    public $name;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name' => 'required|unique:school_classes,name|max:5',
        ]);
    }

    public function addClass()
    {
        $this->validate([
            'name' => 'required|unique:school_classes,name|max:5',
        ]);

        $razred = new SchoolClass();
        $razred->name = $this->name;
        $razred->save();
        session()->flash('razred_poruka', 'Uspješno ste dodali novi razred');
    }
    public function render()
    {
        return view('livewire.admin.dodaj-razred-component')->layout('layouts.base');
    }
}
