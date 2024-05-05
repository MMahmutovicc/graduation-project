<?php

namespace App\Http\Livewire\Admin;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Throwable;

class UcenikComponent extends Component
{
    public $student_id;
    public $ucenik;
    public $events;

    public function mount($ucenik_id)
    {
        $this->student_id = $ucenik_id;
        $this->ucenik = User::find($this->student_id);
        if($this->ucenik === null || $this->ucenik->utype === 'PROF')
        abort(404);
    }

    public function getEvents()
    {
        $events = Event::select('id','title','start')->where('user_id', $this->ucenik_id)->get();
        return json_encode($events);
    }

    public function deleteStudent()
    {
        $this->ucenik->delete();
        session()->flash('ucenik_poruka', 'Učenik je uspješno obrisan');
    }

    public function render()
    {
        $this->events = json_encode($this->ucenik->events);
        return view('livewire.admin.ucenik-component')->layout('layouts.base');
    }
}
