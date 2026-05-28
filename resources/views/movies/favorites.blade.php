@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title" style="justify-content: center;"><i class="fas fa-heart" style="color: var(--danger-color);"></i> Favori Filmlerim</h2>
    
    @if(count($movies) > 0)
        <div class="movie-grid">
            @foreach($movies as $movie)
                @include('components.movie-card', ['movie' => $movie])
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $movies->links('pagination::default') }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 0;">
            <i class="far fa-folder-open fa-3x" style="color: #64748b; margin-bottom: 1rem;"></i>
            <h3>Favori filminiz bulunmuyor</h3>
            <p style="color: #94a3b8; margin-bottom: 1rem;">Henüz favorilerinize film eklemediniz.</p>
            <a href="{{ route('movies.index') }}" class="btn btn-primary">Filmleri Keşfet</a>
        </div>
    @endif
</div>
@endsection
