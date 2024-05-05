@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/student-registracija.css') }}">
@endpush
<main>
    <div class="all">
        <a href="{{ route('razredi') }}" class="all-button">Svi Razredi</a>
    </div>
    <div class="register-box">
        <h1 class="register-heading">Dodajte Novi Razred</h1>
        @if (Session::has('razred_poruka'))
            <div class="alert alert-success" role="alert">{{ Session::get('razred_poruka') }}</div>
        @endif
        <form class="register-form" method="POST" wire:submit.prevent="addClass()">
            @csrf
            <div class="register-form_group">
                <label for="name">Razred i Odjeljenje</label>
                <input type="text" placeholder="1A" id="name" name="name" value="{{ old('name') }}" wire:model='name'>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-submit">
                <button type="submit">Dodaj</button>
            </div>
        </form>
    </div>
</main>