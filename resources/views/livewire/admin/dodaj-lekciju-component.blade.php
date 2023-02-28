@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/student-registracija.css') }}">
    <style>
        .register-box {
            margin-bottom: 3rem
        }
    </style>
@endpush
<main>
    <div class="all">
        <a href="{{ route('lekcije',['sekcija_id' => $section_id]) }}" class="all-button">Sve Lekcije</a>
    </div>
    <div class="register-box">
        <h1 class="register-heading">Dodajte Novu Lekciju</h1>
        @if (Session::has('lekcija_poruka'))
            <div class="alert alert-success" role="alert">{{ Session::get('lekcija_poruka') }}</div>
        @endif
        <form class="register-form" method="POST" enctype="multipart/form-data" wire:submit.prevent="addLecture()">
            @csrf
            <div class="register-form_group">
                <label for="title">Naslov</label>
                <input type="text" placeholder="Naslov" id="title" name="title" wire:model='title'>
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="description">Opis Lekcije</label>
                <textarea class="register-description" name="description" placeholder="Opis" id="description" cols="30" rows="10" wire:model='description'></textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="video">Youtube Video Link</label>
                <input type="text" placeholder="Youtube Video Link" id="video" name="video" wire:model='video'>
                @error('video')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="explanation">Objašnjenje Lekcije</label>
                <textarea class="register-description" name="explanation" placeholder="Objašnjenje" id="explanation" cols="30" rows="10" wire:model='explanation'></textarea>
                @error('explanation')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="hint">Savjet</label>
                <textarea class="register-description" name="hint" placeholder="Savjet" id="hint" cols="30" rows="10" wire:model='hint'></textarea>
            </div>
            <div class="register-form_group">
                <label for="school_class_id">Dodatni Primjeri</label>
                <div class="register-flex">
                    <select name=""id="" wire:model="example_type">
                        <option value="">Izaberite Tip Primjera</option>
                            <option value="1">Slika + objašnjenje + unos</option>
                            <option value="2">Slika + objašnjenje</option>
                    </select>
                    <button wire:click.prevent="addExample()" class="gen-pass">Dodaj Primjer</button>
                </div>
            </div>
            @foreach ($inputs as $key=>$value)
                @if ($value == 2)
                    <div class="register-flex-example">
                        <h2 class="register-example-title">Primjer( Slika + Objašnjenje )</h2>
                        <button type="button" class="remove-example" wire:click.prevent="removeExample({{ $key  }})">Obriši</button>
                    </div>
                @elseif($value == 1)
                    <div class="register-flex-example">
                        <h2 class="register-example-title">Primjer( Slika + Objašnjenje + Unos )</h2>
                        <button type="button" class="remove-example" wire:click.prevent="removeExample({{ $key  }})">Obriši</button>
                    </div>
                @endif
                    <div class="register-form_group">
                        <label for="title">Naslov Primjera</label>
                        <input type="text" placeholder="Naslov Primjera" id="title" name="title" wire:model="example_values.{{ $key }}.{{ 'title' }}">
                    </div>
                    <div class="register-form_group">
                        <label for="photo">Slika Primjera</label>
                        <input type="file" name="photo" id="photo" wire:model="example_values.{{ $key }}.{{ 'photo' }}">
                    </div>
                    @isset($example_values[$key]['photo'])
                        @if ($example_values[$key]['photo']->extension() == 'jpg' || $example_values[$key]['photo']->extension() == 'png')
                            <img src="{{ $example_values[$key]['photo']->temporaryUrl() }}" alt="" width="120">
                        @endif
                    @endisset
                    <div class="register-form_group">
                        <label for="explanation">Objašnjenje Primjera</label>
                        <textarea class="register-description" name="explanation" placeholder="Objašnjenje Primjera" id="explanation" cols="30" rows="10"  wire:model="example_values.{{ $key }}.{{ 'explanation' }}"></textarea>
                    </div>
                    @if ($value == 1)  
                        <div class="register-form_group">
                            <label for="input">Tačan Unos</label>
                            <input type="text" placeholder="Tačan Unos Primjera" id="input" name="input" wire:model="example_values.{{ $key }}.{{ 'input' }}">
                        </div>
                    @endif
            @endforeach
            <div class="register-form_group">
                @error("example_values*.title")
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                @error("example_values*.photo")
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                @error("example_values*.explanation")
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                @error("example_values*.input")
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-submit">
                <button type="submit">Dodaj</button>
            </div>
        </form>
    </div>
</main>