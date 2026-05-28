@extends('layouts.app')

@section('content')
<section class="hero">
    <div class="container">
        <h1>Popüler Diziler.</h1>
        <p>Milyonlarca film, dizi ve kişileri keşfedin. Şimdi keşfetmeye başlayın.</p>
    </div>
</section>

<div class="container">
    <h2 class="section-title"><i class="fas fa-fire" style="color: var(--accent-color);"></i> Popüler Diziler</h2>
    
    <div class="movie-grid">
        @foreach($movies as $movie)
            @include('components.movie-card', ['movie' => $movie])
        @endforeach
    </div>

    @if($totalPages > 1)
        <div class="pagination">
            @if($page > 1)
                <a href="{{ route('tv.index', ['page' => $page - 1]) }}" class="page-link">Önceki</a>
            @endif
            
            <span class="page-link active">{{ $page }}</span>
            
            @if($page < $totalPages && $page < 500) {{-- TMDB limits page to 500 --}}
                <a href="{{ route('tv.index', ['page' => $page + 1]) }}" class="page-link">Sonraki</a>
            @endif
        </div>
    @endif
</div>
@endsection
