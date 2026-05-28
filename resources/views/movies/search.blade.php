@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title"><i class="fas fa-search" style="color: var(--accent-color);"></i> Arama Sonuçları: "{{ $query }}"</h2>
    
    @if(count($movies) > 0)
        <div class="movie-grid">
            @foreach($movies as $movie)
                @include('components.movie-card', ['movie' => $movie])
            @endforeach
        </div>

        @if($totalPages > 1)
            <div class="pagination">
                @if($page > 1)
                    <a href="{{ route('movies.search', ['query' => $query, 'page' => $page - 1]) }}" class="page-link">Önceki</a>
                @endif
                
                <span class="page-link active">{{ $page }}</span>
                
                @if($page < $totalPages)
                    <a href="{{ route('movies.search', ['query' => $query, 'page' => $page + 1]) }}" class="page-link">Sonraki</a>
                @endif
            </div>
        @endif
    @else
        <div style="text-align: center; padding: 4rem 0;">
            <i class="fas fa-search fa-3x" style="color: #64748b; margin-bottom: 1rem;"></i>
            <h3>Sonuç bulunamadı</h3>
            <p style="color: #94a3b8;">Lütfen farklı bir anahtar kelime ile tekrar deneyin.</p>
        </div>
    @endif
</div>
@endsection
