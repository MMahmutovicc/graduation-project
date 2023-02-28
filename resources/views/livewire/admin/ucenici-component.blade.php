@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/studenti.css') }}">
    <style>
        nav svg{
            height: 10px;
        }
    </style>
@endpush
<main>
    <div class="sign-in-student">
        <a href="{{ route('registracija') }}" class="sign-in-student-button">Registrujte Novog Učenika</a>
    </div>
    <div class="students">
        <form class="students-form">
            <label>Pretraži Učenike Po Imenu</label>
            <div class="input-icons">
                <i class="fa fa-search fa-2x icon"></i>               
                <input type="text" name="search" class="input-field" wire:model="search">
            </div>
        </form>
        @if ($ucenici->count() > 0)
        <div class="students-list">
            @if (Session::has('ucenici_poruka'))
                <div class="alert alert-success" role="alert">{{ Session::get('ucenici_poruka') }}</div>
            @endif
                @foreach ($ucenici as $ucenik)
                    <div class="student">
                        <div class="info">
                            {{-- <div class="info_img-container"><a href="student-profil.html"><img class="info_img" src="../slike/profilna-student.png" alt=""></a></div> --}}
                            <a href="{{ route('ucenik',['ucenik_id' => $ucenik->id]) }}" class="info_a">
                                <div class="info_details">
                                <p class="name">{{ $ucenik->name }}</p>
                                <p class="class">{{ $ucenik->razred->name }}</p>
                            </div>
                            </a>
                        </div>
                        <div><button class="student-button"  onclick="confirm('Da li ste sigurni da želite obrisati ovog učenika?') || event.stopImmediatePropagation()" wire:click.prevent="deleteStudent({{ $ucenik->id }})">Izbriši</button></div>
                    </div>
                @endforeach
                <div style="margin-top: 1rem">
                    {{ $ucenici->links() }}
                </div>
        </div>
        @else
            <p>Nema učenika.</p>
        @endif
    </div>
</main>