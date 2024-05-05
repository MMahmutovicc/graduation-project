@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/lekcije.css') }}">  
@endpush
<main>
    <div class="lekcije-heading">
        <h1 class="lekcije-title">{{ $sekcija->name }}</h1>
        @if (Route::has('login'))
            @auth
                @if (Auth::user()->utype === 'PROF')
                <div class="lekcije-heading-div">
                    <a href="{{ route('sekcija.uredi', ['sekcija_id' => $sekcija->id]) }}" class="edit-button">Uredite Oblast</a>
                    <a href="{{ route('lekcija.dodaj', ['sekcija_id' => $sekcija->id]) }}" class="add-new-button">Dodajte Novu Lekciju</a>
                </div>
                @endif
            @endauth
        @endif
    </div>
    <div id="lekcije">
        @foreach ($sekcija->lekcije as $lekcija)
            <div class="lekcija">
                    <h1 class="lekcija-title">{{ $lekcija->title }}</h1>
                <p class="lekcija-info">{{ $lekcija->description }}</p>
                <div class="lekcija-zapocni"><a href="{{ route('lekcija', ['lekcija_id' => $lekcija->id]) }}">Otvori lekciju</a></div>
                @if (Route::has('login'))
                    @auth
                        @if (Auth::user()->utype === 'PROF')
                            <a href="#" onclick="confirm('Da li ste sigurni da želite obrisati ovu lekciju?') || event.stopImmediatePropagation()" wire:click.prevent="deleteLecture({{ $lekcija->id }})" class="lekcija-remove-button">Obrišite Lekciju</a>
                            <a href="{{ route('lekcija.uredi', ['lekcija_id' => $lekcija->id]) }}" class="lekcija-edit-button">Uredite Lekciju</a>
                        @endif
                    @endauth
                @endif
            </div>
        @endforeach
    </div>
    {{-- <div id="paginacija">
        {{ $lekcije->links() }}
    </div> --}}
</main>