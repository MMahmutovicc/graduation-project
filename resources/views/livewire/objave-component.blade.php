@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/objave.css ')}}">
    <style>
        nav svg{
            height: 10px;
        }
    </style>
@endpush
<main>
    <div class="posts">
        @if (Route::has('login'))
            @auth
                @if (Auth::user()->utype === 'PROF')
                    @if (Session::has('objava_poruka'))
                        <div  class="alert alert-success" role="alert">{{ Session::get('objava_poruka') }}</div>
                    @endif
                    <form action="" enctype="multipart/form-data" class="posts-form" wire:submit.prevent="post()">
                        @csrf
                        <textarea name="body" id="" placeholder="Write a post!" wire:model="body"></textarea>
                        @error('body')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="file" wire:model="files" id="{{ $fileCounter }}" multiple>
                        <button type="submit">Objavi</button>
                    </form>
                @endif
            @endauth
        @endif
        @if ($objave->count()>0)
            @foreach ($objave as $objava)
                <div class="post">
                    <p class="post-head">Objavio/la <span class="post-name">{{ $objava->korisnik->name }} </span><span class="post-time"> {{$objava->created_at->diffForHumans() }}</span>
                        @if (Gate::allows('delete-post', $objava))
                            <a href="#" onclick="confirm('Da li ste sigurni da želite obrisati ovu objavu?') || event.stopImmediatePropagation()" wire:click.prevent="deletePost({{ $objava->id }})" title="Obriši Objavu" class="post-delete"><i class="fa-solid fa-xmark"></i></a>
                        @endif
                    </p>
                    <div class="post-body">{{ $objava->body }}</div>
                    @if ($objava->file)
                        @php
                            $files = explode(',', $objava->file);
                        @endphp
                        @foreach ($files as $file)
                            @php
                                $fname = explode('/', $file);
                            @endphp
                            <span class="post-files">| {{ $fname[1] }} |</span>
                        @endforeach
                        <a href="#" title="Preuzmi Datoteke" onclick="confirm('Da li ste sigurni da želite preuzeti ove datoteke?') || event.stopImmediatePropagation()" wire:click.prevent="downloadFiles({{ $objava->id }})"><i class="fa-solid fa-download"></i></a>
                    @endif
                </div>
            @endforeach
            <div style="margin-top: 1rem">
                {{ $objave->links() }}
            </div>
        @else
            <p>Trenutno Nema Objava</p>
        @endif
    </div>
</main>
