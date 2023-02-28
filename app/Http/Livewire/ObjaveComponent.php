<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use ZipArchive;
use File;

class ObjaveComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $body;
    public $files;
    public $fileCounter=0;

    public function mount()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        $objave = Post::orderBy('created_at', 'DESC')->paginate(10);
        return view('livewire.objave-component', ['objave' => $objave])->layout('layouts.base');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'body' => 'required'
        ]);
    }

    public function post()
    {
        $this->validate([
            'body' => 'required'
        ]);
        $objava = new Post();
        $objava->body = $this->body;
        $objava->user_id = Auth::user()->id;
        if($this->files)
        {
            $filesname = '';  
            foreach($this->files as $key=>$file)
            {
                $fname = Carbon::now()->timestamp.$key.'/'.$file->getClientOriginalName();
                $file->storeAs('files', $fname);
                if($key == 0)
                $filesname = $fname;
                else
                $filesname = $filesname .','.$fname;
            }       
            $objava->file = $filesname;   
        }
        $objava->save();
        $this->reset(['body', 'files']);
        $this->fileCounter++;
        session()->flash('objava_poruka', 'Uspješno ste dodali novu objavu!');
    }

    public function deletePost($id)
    {
        $objava = Post::find($id);
        if($objava->file)
        {
            $files = explode(',', $objava->file);
            foreach($files as $file)
            {
                if($file)
                {
                    if(file_exists(storage_path('app/files'.'/'.$file)))
                    {
                        $fname = explode('/', $file);
                        File::deleteDirectory(storage_path('app/files'.'/'.$fname[0]));
                        // unlink(storage_path('app/files'.'/'.$file));
                    }
                }
            }
        }
        $objava->delete();
        session()->flash('objava_poruka', 'Objava je uspješno obrisana');
    }

    public function downloadFiles($id)
    {
        $zipFile = 'objava.zip';
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $objava = Post::find($id);
        $files = explode(',', $objava->file);
        foreach($files as $file)
        {
            if(file_exists(storage_path('app/files/'.$file)))
            {
                $zipName = explode('/', $file);
                $zip->addFile(storage_path('app/files/'.$file), $zipName[1]);
            }
        }
        $zip->close();
        return response()->download($zipFile);
    }
}
