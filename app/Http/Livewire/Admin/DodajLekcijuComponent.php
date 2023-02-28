<?php

namespace App\Http\Livewire\Admin;

use App\Models\Example;
use App\Models\Lecture;
use App\Models\Section;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class DodajLekcijuComponent extends Component
{
    use WithFileUploads;

    public $section_id;

    public $title;
    public $video;
    public $explanation;
    public $hint;
    public $description;

    public $example_type;
    public $inputs = [];
    public $examples = [];
    public $example_values = [];

    public function mount($sekcija_id)
    {
        $this->section_id = $sekcija_id;
        $sekcija = Section::find($sekcija_id);
        if($sekcija === null)
        abort(404);
    }

    public function addExample()
    {
        if($this->example_type == 2 || $this->example_type == 1)
        {
            array_push($this->inputs, $this->example_type);
            array_push($this->examples, $this->example_type);
        }
    }

    public function removeExample($key)
    {
        unset($this->inputs[$key]);
        unset($this->examples[$key]);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'title' => 'required|max:100',
            'video' => 'required|max:50',
            'explanation' => 'required|max:500',
            'description' => 'required|max:300|min:150'
        ]);
        foreach($this->inputs as $ikey=>$input)
        {
            $this->validateOnly($fields,[
                'example_values.'.$ikey.'.title' => 'required|max:100',
                'example_values.'.$ikey.'.photo' => 'required|mimes:jpeg,png',
                'example_values.'.$ikey.'.explanation' => 'required|max:500', 
            ]);
            if($input == 1)
            {
                $this->validateOnly($fields,[
                    'example_values.'.$ikey.'.input' => 'required|max:30'
                ]);
            }
        }
    }

    public function addLecture()
    {
        $this->validate([
            'title' => 'required|max:100',
            'video' => 'required|max:50',
            'explanation' => 'required|max:500',
            'description' => 'required|max:300|min:150'
        ]);
        foreach($this->inputs as $ikey=>$input)
        {
            $this->validate([
                'example_values.'.$ikey.'.title' => 'required|max:100',
                'example_values.'.$ikey.'.photo' => 'required|mimes:jpeg,png',
                'example_values.'.$ikey.'.explanation' => 'required|max:500', 
            ]);
            if($input == 1)
            {
                $this->validate([
                    'example_values.'.$ikey.'.input' => 'required|max:30'
                ]);
            }
        }
        $lekcija = new Lecture();
        $lekcija->title = $this->title;
        $lekcija->explanation = $this->explanation;
        $lekcija->video = preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "//www.youtube.com/embed/$2",
            $this->video
        );
        $lekcija->section_id = $this->section_id;
        $lekcija->description = $this->description;
        if($this->hint)
        $lekcija->hint = $this->hint;
        $lekcija->save();
        foreach($this->example_values as $key=>$example_values)
        {
            foreach($this->inputs as $ikey=>$input)
            {
                if($key == $ikey)
                {
                    $example = new Example();
                    $example->title = $example_values['title'];
                    $example->explanation = $example_values['explanation'];
                    $example->lecture_id = $lekcija->id;
                    $photoName = Carbon::now()->timestamp.$key.'.'.$example_values['photo']->extension();
                    $example_values['photo']->storeAs('public/examples', $photoName);
                    $example->photo = $photoName;
                    if($input == 1)
                    {
                        $example->input = $example_values['input'];
                        $example->type = 1;
                    }
                    else if($input == 2)
                    {
                        $example->type = 2;
                    }
                    $example->save();
                }
            }
        }
        session()->flash('lekcija_poruka', 'Lekcija je uspješno dodana');
    }

    public function messages()
    {
        return [
            'example_values.*.title.required' => 'The example title field is required',
            'example_values.*.title.max' => 'An example title must not be greater than 100 characters',
            'example_values.*.explanation.required' => 'The example explanation field is required',
            'example_values.*.explanation.max' => 'An example explanation must not be greater than 500 characters',
            'example_values.*.photo.required' => 'The example photo field is required',
            'example_values.*.photo.mimes' => 'The example photo must be a file of type: jpeg, png',
            'example_values.*.input.required' => 'The example input field is required',
            'example_values.*.input.max' => 'An example input must not be greater than 30 characters'
        ];
    }

    public function render()
    {
        return view('livewire.admin.dodaj-lekciju-component')->layout('layouts.base');
    }
}