<?php

namespace App\Http\Livewire\Admin;

use App\Models\Example;
use App\Models\Lecture;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mockery\CountValidator\Exact;

class UrediLekcijuComponent extends Component
{
    use WithFileUploads;

    public $lekcija;
    public $lecture_id;
    public $title;
    public $video;
    public $explanation;
    public $hint;
    public $description;

    public $example_type;
    public $inputs = [];
    public $examples = [];
    public $example_values = [];

    public function mount($lekcija_id)
    {
        $this->lecture_id = $lekcija_id;
        $this->lekcija = Lecture::find($lekcija_id);
        if($this->lekcija === null)
        abort(404);
        $this->title = $this->lekcija->title;
        $this->video = $this->lekcija->video;
        $this->explanation = $this->lekcija->explanation;
        $this->hint = $this->lekcija->hint;
        $this->description = $this->lekcija->description;
        foreach($this->lekcija->primjeri as $key=>$primjer)
        {
            array_push($this->inputs, $primjer->type);
            array_push($this->examples, $primjer->type);
            $this->example_values[$key]['id'] = $primjer->id;
            $this->example_values[$key]['title'] = $primjer->title; 
            $this->example_values[$key]['photo'] = $primjer->photo;
            $this->example_values[$key]['explanation'] = $primjer->explanation;
            $this->example_values[$key]['newphoto'] = '';
            if($primjer->type == 1)
            $this->example_values[$key]['input'] = $primjer->input;
        } 
    }

    public function addExample()
    {
        if($this->example_type == 2 || $this->example_type == 1)
        {
            array_push($this->inputs, $this->example_type);
            array_push($this->examples, $this->example_type);
            end($this->inputs);
            $key = key($this->inputs);
            $this->example_values[$key]['newphoto'] = '';
            $this->example_values[$key]['photo'] = '';
            reset($this->inputs);
        }
    }

    public function removeExample($key)
    {
        if(isset($this->example_values[$key]['id']))
        {
            foreach($this->lekcija->primjeri as $primjer)
            {
                if($primjer->id == $this->example_values[$key]['id'])
                $pr = $primjer;
            }
            if(file_exists(public_path('storage/examples'.'/'.$pr->photo)))
            {
                unlink(public_path('storage/examples'.'/'.$pr->photo));
            }
            $pr->delete();
        }
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
                'example_values.'.$ikey.'.explanation' => 'required|max:500', 
            ]);
            if($input == 1)
            {
                $this->validateOnly($fields,[
                    'example_values.'.$ikey.'.input' => 'required|max:30'
                ]);
            }
            if(!'example_values.'.$ikey.'.photo')
            {
                $this->validateOnly($fields,[
                    'example_values.'.$ikey.'.newphoto' => 'required|mimes:jpeg,png'
                ]);
            }
        }
    }

    public function updateLecture()
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
                'example_values.'.$ikey.'.explanation' => 'required|max:500', 
            ]);
            if($input == 1)
            {
                $this->validate([
                    'example_values.'.$ikey.'.input' => 'required|max:30'
                ]);
            }
            if(!$this->example_values[$ikey]['photo'])
            {
                $this->validate([
                    'example_values.'.$ikey.'.newphoto' => 'required|mimes:jpeg,png'
                ]);
            }
        }
        $this->lekcija->title = $this->title;
        $this->lekcija->explanation = $this->explanation;
        $this->lekcija->video = preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "//www.youtube.com/embed/$2",
            $this->video
        );
        $this->lekcija->description = $this->description;
        if($this->hint)
        $this->lekcija->hint = $this->hint;
        $this->lekcija->save();
        // foreach($lekcija->primjeri as $key=>$primjer)
        // {
        //     $primjer->delete();
        // }
        foreach($this->example_values as $key=>$example_values)
        {
            foreach($this->inputs as $ikey=>$input)
            {
                if($key == $ikey)
                {
                    if(isset($example_values['id']))
                    {
                        foreach($this->lekcija->primjeri as $primjer)
                        {
                            if($primjer->id == $example_values['id'])
                            $example = $primjer;
                        }
                        $example->title = $example_values['title'];
                        $example->explanation = $example_values['explanation'];
                        $example->lecture_id = $this->lekcija->id;
                        if($example_values['newphoto'])
                        {
                            if($example_values['photo'])
                            {
                                if(file_exists(public_path('storage'.'/'.$example_values['photo'])))
                                {
                                    unlink(public_path('storage'.'/'.$example_values['photo']));
                                }
                            }
                            $photoName = Carbon::now()->timestamp.$key.'.'.$example_values['newphoto']->extension();
                            $example_values['newphoto']->storeAs('public/examples', $photoName); 
                            $example->photo = $photoName;
                        }
                    }

                    else
                    {
                        $example = new Example();
                        $example->title = $example_values['title'];
                        $example->explanation = $example_values['explanation'];
                        $example->lecture_id = $this->lekcija->id;
                        $photoName = Carbon::now()->timestamp.$key.'.'.$example_values['newphoto']->extension();
                        $example_values['newphoto']->storeAs('public/examples', $photoName); 
                        $example->photo = $photoName;
                    }
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
        session()->flash('lekcija_poruka', 'Lekcija je uspješno uređena');
    }

    public function messages()
    {
        return [
            'example_values.*.title.required' => 'An example title is required',
            'example_values.*.title.max' => 'An example title must not be greater than 100 characters',
            'example_values.*.explanation.required' => 'An example explanation is required',
            'example_values.*.explanation.max' => 'An example explanation must not be greater than 500 characters',
            'example_values.*.newphoto.required' => 'An example photo is required',
            'example_values.*.newphoto.mimes' => 'An example photo must be a file of type: jpeg, png',
            'example_values.*.input.required' => 'An example input is required',
            'example_values.*.input.max' => 'An example input must not be greater than 30 characters'
        ];
    }

    public function render()
    {
        return view('livewire.admin.uredi-lekciju-component')->layout('layouts.base');
    }
}