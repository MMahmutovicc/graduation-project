<?php

namespace App\Http\Livewire\Admin;

use App\Models\ClassEvent;
use App\Models\Event;
use App\Models\SchoolClass;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;

class KalendarComponent extends Component
{
    public $events = '';
    public $title;
    public $class;
    public $date;

    public function render()
    {
        $events = ClassEvent::all();
        $razredi = SchoolClass::orderBy('name', 'ASC')->get();
        $this->events = json_encode($events);
        return view('livewire.admin.kalendar-component', ['razredi' => $razredi])->layout('layouts.base');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'title' => 'required|max:100',
            'class' => 'required',
            'date' => 'required'
        ]);
    }

    public function addEvent()
    {
        $this->validate([
            'title' => 'required|max:100',
            'class' => 'required',
            'date' => 'required'
        ]);
        $createDate = new DateTime($this->date);
        $strip = $createDate->format('Y-m-d');
        $class = SchoolClass::find($this->class);
        $event = new ClassEvent();
        $event->title = $this->title;
        $event->start = $strip;
        $event->description = $class->name . " - " . $this->title;
        $event->school_class_id = $this->class;
        $event->save();
        return redirect()->route('kalendar');
    }

    public function deleteEvent($id)
    {
        $event = ClassEvent::find($id);
        $event->delete();
        return redirect()->route('kalendar');
    }

    public function updateEvent($id, $date)
    {
       $event = ClassEvent::find($id);
       $event->start = $date;
       $event->save();
    }
}
