<?php

namespace App\Http\Livewire\Admin;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class DodajNovogUcenikaComponent extends Component
{
    public $name;
    public $email;
    public $school_class_id;
    public $password;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:20',
            'school_class_id' => 'required'
        ]);
    }

    public function registerStudent()
    {
        $this->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:20',
            'school_class_id' => 'required'
        ]);
        $ucenik = new User();
        $ucenik->name = $this->name;
        $ucenik->email = $this->email;
        $ucenik->utype = 'UCE';
        $ucenik->password = Hash::make($this->password);
        $ucenik->school_class_id = $this->school_class_id;
        $ucenik->save();
        session()->flash('registracija_poruka', 'Uspješno je registrovan novi učenik');
    }

    public function generatePassword()
    {
        $this->password = Str::random(8);
    }

    public function render()
    {
        $razredi = SchoolClass::orderBy('name', 'ASC')->get();
        return view('livewire.admin.dodaj-novog-ucenika-component',['razredi' => $razredi])->layout('layouts.base');
    }
}
