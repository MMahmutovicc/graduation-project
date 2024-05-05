@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/student-registracija.css') }}">
@endpush
<main>
    <div class="all">
        <a href="{{ route('ucenici') }}" class="all-button">Svi Učenici</a>
    </div>
    <div class="register-box">
        <h1 class="register-heading">Registrujte Novog Učenika</h1>
        @if (Session::has('registracija_poruka'))
            <div  class="alert alert-success" role="alert">{{ Session::get('registracija_poruka') }}</div>
        @endif
        <form class="register-form" method="POST" wire:submit.prevent="registerStudent()">
            @csrf
            <div class="register-form_group">
                <label for="name">Ime i Prezime</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" wire:model='name'>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="username">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus wire:model='email'>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="school_class_id">Razred i Odjeljenje</label>
                <div class="register-flex">
                    <select name="school_class_id" id="school_class_id" wire:model='school_class_id'>
                        <option value="">Izaberite Razred</option>
                        @foreach ($razredi as $razred)
                            <option value="{{ $razred->id }}">{{ $razred->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('razredi') }}" class="gen-pass">Pogledaj Razrede</a>
                </div>
                @error('school_class_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form_group">
                <label for="">Password</label>
                <div class="register-flex" wire:ignore>
                    <i class="fa-solid fa-eye icon" id="pass-visible" onclick="switchPassword()"></i>
                    <i class="fa-solid fa-eye-slash icon" id="pass-hidden" onclick="switchPassword()"></i>
                    <input type="password" id="password" value="123" name="password" wire:model="password"> 
                    <button type="button" class="gen-pass" wire:click.prevent="generatePassword()">Generiši Password</button>
                </div>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-submit">
                <button type="submit">Registrujte</button>
            </div>
        </form>
    </div>
</main>

@push('scripts')
    <script>
        pass = document.getElementById('password');
        passVisible = document.getElementById('pass-visible');
        passHidden = document.getElementById('pass-hidden');
        function switchPassword() {
            if(pass.getAttribute('type') === 'password')
            {
                pass.setAttribute('type', 'text')
                passVisible.style.display = 'block';
                passHidden.style.display = 'none';
            }

            else if(pass.getAttribute('type') === 'text')
            {
                pass.setAttribute('type', 'password')
                passVisible.style.display = 'none';
                passHidden.style.display = 'block';
            }
        }
    </script>
@endpush