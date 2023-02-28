<?php

namespace App\Http\Livewire\Admin;

use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;

class RazrediComponent extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $razredi = SchoolClass::orderBy('name', 'ASC')->where('name', 'LIKE', '%'.$this->search.'%')->paginate(10);
        return view('livewire.admin.razredi-component',['razredi' => $razredi])->layout('layouts.base');
    }

    public function deleteClass($id)
    {
        $razred = SchoolClass::find($id);
        $razred->delete();
        session()->flash('razred_poruka', 'Uspjesno ste izbrisali razred.');
    }
}
