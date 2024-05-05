@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/student-registracija.css') }}">
@endpush
<main>
    <div class="all">
        <a href="{{ route('sekcije') }}" class="all-button">Sve Oblasti</a>
    </div>
    <div class="register-box">
        <h1 class="register-heading">Dodajte Novu Oblast</h1>
        @if (Session::has('oblast_poruka'))
            <div class="alert alert-success" role="alert">{{ Session::get('oblast_poruka') }}</div>
        @endif
        <form class="register-form" method="POST" wire:submit.prevent="addSection()">
            @csrf
            <div class="register-form_group">
                <label for="name">Naziv Oblasti</label>
                <input type="text" placeholder="Naziv Oblasti" id="name" name="name" value="{{ old('name') }}" wire:model='name'>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="description">Opis Oblasti</label>
                <textarea class="register-description" name="description" placeholder="Opis Oblasti" id="description" cols="30" rows="10" wire:model='description'></textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-submit">
                <button type="submit">Dodaj</button>
            </div>
        </form>
    </div>
</main>