@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <div class="movie-detail">
        <div class="movie-detail-poster">
            @if(isset($movie['poster_path']) && $movie['poster_path'])
                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" style="width: 100%; border-radius: 0.5rem;">
            @else
                <div style="width: 100%; height: 450px; display:flex; align-items:center; justify-content:center; background:#334155; border-radius: 0.5rem;">
                    <i class="fas fa-film fa-5x" style="color: #94a3b8;"></i>
                </div>
            @endif
        </div>
        
        <div class="movie-detail-content">
            <h1 class="movie-detail-title">{{ $movie['title'] }} <span style="font-weight: 400; color: #94a3b8;">({{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : '' }})</span></h1>
            
            @if(isset($movie['tagline']) && $movie['tagline'])
                <p class="movie-tagline">{{ $movie['tagline'] }}</p>
            @endif

            <div class="movie-stats">
                <div class="stat-item" style="color: #f59e0b;">
                    <i class="fas fa-star fa-lg"></i>
                    <span style="font-size: 1.25rem; font-weight: bold;">{{ isset($movie['vote_average']) ? number_format($movie['vote_average'], 1) : '0.0' }}</span>
                </div>
                
                @if(isset($movie['runtime']))
                    <div class="stat-item">
                        <i class="far fa-clock"></i>
                        <span>{{ $movie['runtime'] }} dk</span>
                    </div>
                @endif
                
                @if(isset($movie['genres']))
                    <div class="stat-item">
                        <i class="fas fa-tags"></i>
                        <span>
                            @foreach($movie['genres'] as $genre)
                                {{ $genre['name'] }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    </div>
                @endif
            </div>

            @auth
                <div style="margin-bottom: 2.5rem;">
                    <button id="favorite-btn" class="btn {{ $isFavorite ? 'btn-accent' : 'btn-outline' }}" onclick="toggleFavorite()">
                        <i class="fa{{ $isFavorite ? 's' : 'r' }} fa-heart" id="favorite-icon"></i> 
                        <span id="favorite-text">{{ $isFavorite ? 'Favorilerden Çıkar' : 'Favorilere Ekle' }}</span>
                    </button>
                </div>
            @else
                <div style="margin-bottom: 2.5rem;">
                    <a href="{{ route('login') }}" class="btn btn-outline" title="Favorilere eklemek için giriş yapın">
                        <i class="far fa-heart"></i> Favorilere Ekle
                    </a>
                </div>
            @endauth

            <div>
                <h3 style="margin-bottom: 1rem; font-size: 1.25rem;">Özet</h3>
                <p class="movie-overview">{{ $movie['overview'] ?: 'Bu film için Türkçe özet bulunmamaktadır.' }}</p>
            </div>
        </div>
    </div>

    @if(isset($movie['similar']['results']) && count($movie['similar']['results']) > 0)
        <div style="margin-top: 5rem;">
            <h2 class="section-title">Benzer Filmler</h2>
            <div class="movie-grid">
                @foreach(array_slice($movie['similar']['results'], 0, 6) as $similarMovie)
                    @include('components.movie-card', ['movie' => $similarMovie])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function toggleFavorite() {
        const btn = document.getElementById('favorite-btn');
        const icon = document.getElementById('favorite-icon');
        const text = document.getElementById('favorite-text');
        
        btn.disabled = true;

        fetch('{{ route("movies.toggleFavorite") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                tmdb_id: {{ $movie['id'] }},
                title: '{{ addslashes($movie["title"]) }}',
                poster_path: '{{ $movie["poster_path"] ?? "" }}',
                release_date: '{{ $movie["release_date"] ?? "" }}',
                vote_average: {{ $movie['vote_average'] ?? 0 }}
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'added') {
                btn.classList.remove('btn-outline');
                btn.classList.add('btn-accent');
                icon.classList.remove('far');
                icon.classList.add('fas');
                text.textContent = 'Favorilerden Çıkar';
            } else {
                btn.classList.remove('btn-accent');
                btn.classList.add('btn-outline');
                icon.classList.remove('fas');
                icon.classList.add('far');
                text.textContent = 'Favorilere Ekle';
            }
        })
        .finally(() => {
            btn.disabled = false;
        });
    }
</script>
@endpush
