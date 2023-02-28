<?php

namespace App\Http\Livewire;

use App\Models\Example;
use App\Models\Lecture;
use App\Models\Section;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LekcijaComponent extends Component
{
    public $lekcija;
    public $lek_id;
    public $ytId;
    public $vidExists;
    public $input = [];
    public $correct = [];
    public $check = [];

    public $next;

    use WithPagination;

    public function mount($lekcija_id)
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        $this->lek_id = $lekcija_id;
        $this->lekcija = Lecture::find($this->lek_id);
        if($this->lekcija === null)
        abort(404);
        $yt = explode('/', $this->lekcija->video);
        $this->ytId = end($yt);
        $this->vidExists = $this->yt_exists($this->ytId);
        foreach($this->lekcija->primjeri as $key=>$primjer)
        {
            if($primjer->type == '1')
            {  
                $this->correct[$key] = $primjer->input;
                $this->check[$key] = 3;
            }
        }
        $this->next = Lecture::where('id', '>', $lekcija_id)->where('section_id', '=', $this->lekcija->section_id)->min('id');
    }

    public function yt_exists($videoID) {
        $theURL = "http://www.youtube.com/oembed?url=$videoID&format=json";
        $headers = get_headers($theURL);
        if(substr($headers[0], 9, 3) !== "400" && substr($headers[0], 9, 3) !== "401" && substr($headers[0], 9, 3) !== "404")
        return 1;
        else
        return 0;
    }

    public function checkInput($key)
    {
        if(strtolower($this->input[$key]) == strtolower($this->correct[$key]))
        $this->check[$key] = 1 ;
        else 
        $this->check[$key] = 0;
    }

    public function render()
    {
        return view('livewire.lekcija-component')->layout('layouts.base');
    }

}
