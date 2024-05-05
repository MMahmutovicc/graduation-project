@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/lekcija.css') }}">
@endpush
<main>
    <div class="backdrop"></div>
    <div class="lekcija-box">
        <h1 class="lekcija-heading">{{ $lekcija->title }}</h1>
        <div class="primjer">
            <h2 class="primjer-heading">Video + Objašnjenje</h2>
            <div class="primjer-body">
                <div class="primjer-body_img-container">
                    @if ($vidExists == 1)
                        <iframe width="560" height="315" src="{{ $lekcija->video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @else
                        <h2>Nije moguće pronaći video.</h2>
                    @endif
                </div>
                <div class="primjer-body_text">
                    <h2 class="objasnjenje-heading">Objašnjenje</h2>
                    <p class="objasnjenje-text">{{ $lekcija->explanation }}</p>
                    @if ($lekcija->hint)
                        <button class="primjer-body_rjesenje" onclick="primjer1()">Pogledaj Savjet</button>
                        <div class="rjesenje_hidden">
                            <p>{{ $lekcija->hint }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @php
            $k=-1;
        @endphp
        @foreach ($lekcija->primjeri as $key=>$primjer)
            @if ($primjer->type == '2')
                @php
                    $k++;
                @endphp
                <div class="primjer">
                    <h2 class="primjer-heading">{{ $primjer->title }}</h2>
                    <div class="primjer-body">
                        <div class="primjer-body_img-container" id="img-container_3">
                            <img src="{{ asset("storage/examples"."/".$primjer->photo) }}" alt="">
                        </div>
                        <div class="primjer-3-btn-div">
                            <button class="primjer3-btn" onclick="primjer3({{ $k }})">Prikaži Objašnjenje</button>
                        </div>
                        <div class="primjer-3-objasnjenje">{{ $primjer->explanation }}</div>
                    </div>
                </div>
            @else
                <div class="primjer">
                    <h2 class="primjer-heading">{{ $primjer->title }}</h2>
                    <div class="primjer-body" id="primjer2-body">
                        <div class="primjer-body_img-container" id="img-container_2">
                            <img src="{{ asset("storage/examples"."/".$primjer->photo) }}" alt="">
                        </div>
                        <div class="primjer-body_text">
                            <h2 class="primjer2-title">{{ $primjer->explanation }}</h2>
                            <p class="primjer2-subtitle">U polje ispod napiši šta fali kodu na slici</p>
                            <form action="" wire:submit.prevent="checkInput({{ $key }})">
                                @csrf
                                @if ($check[$key] == 1)
                                    <input type="text" class="primjer2-input correct" wire:model="input.{{ $key }}">
                                @elseif($check[$key] == 0)
                                    <input type="text" class="primjer2-input incorrect" wire:model="input.{{ $key }}">
                                @else
                                    <input type="text" class="primjer2-input" wire:model="input.{{ $key }}">
                                @endif
                                <button type="submit" class="primjer2-btn">Potvrdi</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="bubble-body">
            <div class="bubble" title="Početak lekcije" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"><i class="fas fa-arrow-up"></i></div>    
            @if ($next)
                <a href="{{ route('lekcija', ['lekcija_id' => $next ]) }}"><div class="bubble" title="Sljedeca Lekcija"><i class="fa-solid fa-arrow-right"></i></div></a>
            @else
                <a href="{{ route('lekcije', ['sekcija_id' => $lekcija->section_id ]) }}"><div class="bubble" title="Oblast"><i class="fa-solid fa-arrow-right"></i></div></a>
            @endif
        </div>
    </div>
</main>

@push('scripts')
    <script>
        backdrop = document.querySelector('.backdrop');
        rjesenje = document.querySelector('.rjesenje_hidden');
        btn1 = document.querySelector('.primjer-body_rjesenje');
        pr3o = document.querySelectorAll('.primjer-3-objasnjenje');
        var i;

        function primjer1()
        {
            backdrop.style.display = "block";
            rjesenje.style.display = "block";
            rjesenje.classList.remove("close");
            rjesenje.classList.add("open");

            btn1.classList.remove("open");
            btn1.classList.add("close");
        }

        backdrop.addEventListener('click', function(){
            backdrop.style.display = "none";
            if(btn1 !== null)
            {
                if(btn1.classList.contains("close"))
                {
                    btn1.classList.remove("close");
                    btn1.classList.add("open");
                    rjesenje.classList.remove("open");
                    rjesenje.classList.add("close");
                    rjesenje.style.display = "none";
                }
            }
            if(pr3o[i].style.display == "block")
            {
                pr3o[i].style.display = "none";
                pr3o[i].style.zIndex = "1";
            }

        });

        function primjer3(key)
        {
            i=key;
            backdrop.style.display = "block";
            pr3o[key].style.display = "block";
            pr3o[key].style.zIndex = "200";
        }
        
    </script>
@endpush