@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student-registracija.css') }}">
@endpush
<main>
<div class="register-box">
    <h1 class="register-heading">Uredi Početnu Stranicu</h1>
    @if (Session::has('pocetna_poruka'))
        <div class="alert alert-success" role="alert">{{ Session::get('pocetna_poruka') }}</div>
    @endif
    <form class="register-form" method="POST" enctype="multipart/form-data" wire:submit.prevent="updateHome()">
        @csrf
        <div class="register-form_group">
            <label for="title">Naslov</label>
            <input type="text" placeholder="Naslov" id="title" name="title" wire:model='title'>
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="register-form_group">
            <label for="">Slika</label>
            <input type="file" name="" id="" wire:model="newphoto">
            @error('newphoto')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        @if ($newphoto)
            @if ($newphoto->extension() == 'jpg' || $newphoto->extension() == 'png')
                <img src="{{ $newphoto->temporaryUrl() }}" alt="" width="160">
            @endif
        @elseif($photo)
            <img src="{{ asset("storage/home"."/".$photo) }}" alt="" width="160">
        @endif
        <div class="register-form_group">
            <label for="description">Opis</label>
            <textarea class="register-description" name="description" placeholder="Opis" id="description" cols="30" rows="10" wire:model='description'></textarea>
            @error('description')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="register-submit">
            <button type="submit">Uredi</button>
        </div>
    </form>
</div>
</main>