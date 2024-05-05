<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\HomeDescription;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeComponent extends Component
{
    public function addEvent()
    {
        if(Auth::check())
        {
            if(Auth::user()->utype === 'UCE')
            {
                $today = Carbon::now();
                $today = $today->toDateString();
                $event = Event::where('start', $today)->where('user_id', Auth::user()->id)->get()->first();
                if(!$event)
                {
                    $nEvent = new Event();
                    $nEvent->title = Auth::user()->name;
                    $nEvent->start = $today;
                    $nEvent->user_id = Auth::user()->id;
                    $nEvent->save();
                }
            }
        }
    }

    public function render()
    {
        $this->addEvent();
        $homeSliders = Section::inRandomOrder()->limit(2)->get();
        $hSDescription = [];
        foreach($homeSliders as $key=>$homeSlider)
        {
            $hSDescription[$key] = substr($homeSlider->description, 0, 150).'...'; 
        }
        $homes = HomeDescription::all();
        return view('livewire.home-component', ['homes' => $homes, 'homeSliders' => $homeSliders, 'hSDescription' => $hSDescription])->layout('layouts.base');
    }
}
