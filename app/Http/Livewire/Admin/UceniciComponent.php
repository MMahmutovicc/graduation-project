<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UceniciComponent extends Component
{
    use WithPagination;

    public $search;
    public function render()
    {
        $ucenici = User::orderBy('name', 'ASC')->where('utype', 'UCE')->where('name', 'LIKE', '%'.$this->search.'%')->paginate(10);
        return view('livewire.admin.ucenici-component',['ucenici' => $ucenici])->layout('layouts.base');
    }

    public function deleteStudent($id)
    {

        $ucenik = User::find($id);
        $ucenik->delete();
        session()->flash('ucenici_poruka', 'Učenik je uspješno izbrisan iz baze podataka');
    }
}
