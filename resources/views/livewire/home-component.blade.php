@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endpush
<main>
    <section id="home-start" class="slide-in">
        {{-- <div class="home-start_image-box">
            <img src="{{ asset('assets/slike/home.png') }}" alt="" class="home-start_image"> 
        </div> --}}
        @foreach ($homeSliders as $key=>$hS)
            {{-- <div class="home-start_quote">
                <h1>{{ $hS->name }}</h1>
                <div class="home-start_quote-text">
                {{-- <p>while <span class="white">( doubt )</span></p>
                <p><span class="white">{</span> <span class="blue">exercise</span><span class="white">;</span></p>  
                <p>if <span class="white">( tired )</span> break <span class="white">;</span></p> 
                <p><span class="blue">sweat it out</span><span class="white">;</span> <span class="white">}</span></p> 
                    <p>{{ $hS->description }}</p>
                </div>
            </div> --}}
                <div class="home-start_quote">
                    <a href="{{ route('lekcije', ['sekcija_id' => $hS->id]) }}">
                    <h1>{{ $hS->name }}</h1>
                    <div class="home-start_quote-text">
                        <p>{{ $hSDescription[$key] }}</p>
                    </div>
                    </a>
                </div>
        @endforeach
    </section>
    <section id="administrators">
        <h1 class="administrators-title">C++</h1>
        @foreach ($homes as $key=>$home)
            @if ($key % 2 != 0)
                <div class="story" id="admin-2">
                    <div class="story_info">
                        <h1 class="story_name">{{ $home->title }}
                            @if (Route::has('login'))
                                @auth
                                    @if (Auth::user()->utype === 'PROF')
                                        <a href="{{ route('home.uredi', ['home_id' => $home->id]) }}" class="edit"><i title="Uredi" class="fa-solid fa-pen-to-square"></i></a>
                                    @endif
                                @endauth
                            @endif    
                        </h1>
                        <p class="story_text">{{ $home->description }}</p>
                    </div>
                    <div class="story_image-box">
                        <img src="{{ asset("storage/home"."/".$home->photo) }}" alt="" class="story_image">
                    </div>
                </div>
            @else
                <div class="story" id="admin-1">
                    <div class="story_image-box">
                        <img src="{{ asset("storage/home"."/".$home->photo) }}" alt="" class="story_image">
                    </div>
                    <div class="story_info">
                        <h1 class="story_name">{{ $home->title }}
                            @if (Route::has('login'))
                                @auth
                                    @if (Auth::user()->utype === 'PROF')
                                        <a href="{{ route('home.uredi', ['home_id' => $home->id]) }}" class="edit"><i title="Uredi" class="fa-solid fa-pen-to-square"></i></a>
                                    @endif
                                @endauth
                            @endif 
                        </h1>
                        <p class="story_text">{{ $home->description }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </section>
</main>
