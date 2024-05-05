<?php

namespace App\Http\Livewire\User;

use App\Models\ClassEvent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KalendarRazredComponent extends Component
{
    public $events = '';

    public function mount($razred_name)
    {
        if(Auth::check())
        {
            if(Auth::user()->utype == 'UCE')
            {
                if(Auth::user()->razred->name != $razred_name)
                {
                    return redirect()->route('kalendar.razred', ['razred_name' => Auth::user()->razred->name]);
                }
            }
            else
            {
                return redirect()->route('kalendar');
            }
        }
    }

    public function render()
    {
        $this->events = json_encode(Auth::user()->razred->events);
        // $this->events = json_encode(ClassEvent::all());
        return view('livewire.user.kalendar-razred-component')->layout('layouts.base');
    }
}
