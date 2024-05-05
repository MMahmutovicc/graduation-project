@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/lekcije.css') }}">
@endpush
<main>
    @if (Route::has('login'))
        @auth
            @if (Auth::user()->utype === 'PROF')
            <div class="add-new">
                <a href="{{ route('oblast.dodaj') }}" class="add-new-button">Dodaj Novu Oblast</a>
            </div>
            @endif
        @endauth
    @endif
    <div id="lekcije">
        @foreach ($sekcije as $sekcija)
            <div class="lekcija lekcija-l">
                <div class="lekcija-heading">
                    <h1 class="lekcija-title">{{ $sekcija->name }}</h1>
                    @if (Route::has('login'))
                        @auth
                            @if (Auth::user()->utype === 'PROF')
                                <a href="#" onclick="confirm('Da li ste sigurni da želite obrisati ovu oblast?') || event.stopImmediatePropagation()" wire:click.prevent="deleteSection({{ $sekcija->id }})" class="lekcija-remove-button">Obriši Oblast</a>
                                <a href="{{ route('sekcija.uredi', ['sekcija_id' => $sekcija->id]) }}" class="lekcija-edit-button">Uredi Oblast</a>
                            @endif
                        @endauth
                    @endif
                </div>
                <p class="lekcija-info">{{ $sekcija->description }}</p>
                <div class="lekcija-zapocni"><a href="{{ route('lekcije', ['sekcija_id' => $sekcija->id]) }}">Pogledaj Oblast</a></div>
            </div>
        @endforeach
    </div>
    {{-- <div id="paginacija">
        {{ $sekcije->links() }}
    </div> --}}
</main>