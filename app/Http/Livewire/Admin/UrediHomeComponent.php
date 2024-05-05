<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeDescription;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class UrediHomeComponent extends Component
{
    use WithFileUploads;
    public $home_id;
    public $title;
    public $photo;
    public $newphoto;
    public $description;

    public function mount($home_id)
    {
        $this->home_id = $home_id;
        $home = HomeDescription::find($home_id);
        if($home === null)
        abort(404);
        $this->title = $home->title;
        $this->photo = $home->photo;
        $this->description = $home->description;
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'title' => 'required|max:50',
            'newphoto' => 'required|mimes:jpeg,png',
            'description' => 'required|max:300'
        ]);
    }

    public function updateHome()
    {
        $this->validate([
            'title' => 'required|max:50',
            'newphoto' => 'required|mimes:jpeg,png',
            'description' => 'required|max:300'
        ]);

        $home = HomeDescription::find($this->home_id);
        $home->title = $this->title;
        if($this->photo)
        {
            if(file_exists(public_path('storage/home'.'/'.$this->photo)))
            {
                unlink(public_path('storage/home'.'/'.$this->photo));
            }
        }
        $photoName = Carbon::now()->timestamp.'.'.$this->newphoto->extension();
        $this->newphoto->storeAs('public/home', $photoName);
        $home->photo = $photoName;
        $home->description = $this->description;
        $home->save();
        session()->flash('pocetna_poruka', 'Početna stranica je uspješno uređena');
    }

    public function render()
    {
        return view('livewire.admin.uredi-home-component')->layout('layouts.base');
    }
}
