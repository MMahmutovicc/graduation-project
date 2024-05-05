{{-- <main>
    <table>
        <thead>
            <th colspan="2">Razred I Odjeljenje</th>
            <th><a href="{{ route('razred.dodaj') }}">Dodaj Novi Razred</a></th>
        </thead>
        <tbody>
            @foreach ($razredi as $razred)
                <tr>
                    <td>{{ $razred->name }}</td>
                    <td>Obriši</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main> --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/razredi.css') }}">
<style>
    nav svg{
        height: 10px;
    }
</style>
@endpush
<main>
    <div class="sign-in-class">
        <a href="{{ route('razred.dodaj') }}" class="sign-in-class-button">Dodajte Novi Razred</a>
    </div>
    <div class="classes">
        <h1 class="classes-heading">Trenutni Razredi</h1>
        <form class="classes-form">
            <label>Pretrazi Razrede</label>
            <div class="input-icons">
                <i class="fa fa-search fa-2x icon"></i>               
                <input type="text" name="search" class="input-field" wire:model="search">
            </div>
        </form>
        @if ($razredi->count()>0)
        <div class="classes-list">
            @if (Session::has('razred_poruka'))
                <div  class="alert alert-success" role="alert">{{ Session::get('razred_poruka') }}</div>
            @endif
                @foreach ($razredi as $razred)
                    <div class="class">
                        <div class="info">
                            <div class="info_details">
                                <p class="name">{{ $razred->name }}</p>
                            </div>
                        </div>
                        <div><button class="class-button"  onclick="confirm('Da li ste sigurni da želite obrisati ovaj razred?') || event.stopImmediatePropagation()" wire:click.prevent="deleteClass({{ $razred->id }})">Izbriši</button></div>
                    </div>
                @endforeach
            <div style="margin-top: 1rem">
                {{ $razredi->links() }}
            </div>
        </div>
        @else   
            <p>Nema razreda.</p>
        @endif
    </div>
</main>