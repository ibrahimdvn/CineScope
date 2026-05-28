@php
    // DB'den gelen model: $movie->tmdb_id | API'den gelen array: $movie['id']
    $isModel  = $movie instanceof \App\Models\Movie;
    $tmdbId   = $isModel ? $movie->tmdb_id : ($movie['id'] ?? $movie['tmdb_id'] ?? null);
    $isTv     = $isModel
        ? (isset($movie->media_type) && $movie->media_type === 'tv')
        : (isset($movie['media_type']) && $movie['media_type'] === 'tv');
    $isPerson = !$isModel && isset($movie['media_type']) && $movie['media_type'] === 'person';
    $routeUrl = $isPerson 
        ? "https://www.themoviedb.org/person/{$tmdbId}" 
        : ($isTv ? route('tv.show', $tmdbId) : route('movies.show', $tmdbId));
    $title    = $isModel ? $movie->title : ($movie['title'] ?? $movie['name'] ?? 'İsimsiz');
    $date     = $isModel ? $movie->release_date : ($movie['release_date'] ?? $movie['first_air_date'] ?? null);
    $poster   = $isModel ? $movie->poster_path : ($movie['poster_path'] ?? $movie['profile_path'] ?? null);
    $vote     = $isModel ? $movie->vote_average : ($movie['vote_average'] ?? 0);
@endphp
<a href="{{ $routeUrl }}" class="movie-card" @if($isPerson) target="_blank" @endif>
    <div class="movie-poster-wrapper">
        @if($poster)
            <img src="https://image.tmdb.org/t/p/w500{{ $poster }}" alt="{{ $title }}" class="movie-poster">
        @else
            <div class="movie-poster" style="display:flex; align-items:center; justify-content:center; background:#334155;">
                <i class="fas fa-{{ $isPerson ? 'user' : 'film' }} fa-3x" style="color: #94a3b8;"></i>
            </div>
        @endif
        
        @auth
            @if(!$isPerson)
                @php
                    $isFav = \App\Models\Movie::where('tmdb_id', $tmdbId)->whereHas('users', function($q) {
                        $q->where('user_id', Auth::id());
                    })->exists();
                @endphp
                <button class="card-fav-btn" 
                        data-id="{{ $tmdbId }}"
                        data-type="{{ $isTv ? 'tv' : 'movie' }}"
                        data-title="{{ $title }}"
                        data-poster="{{ $poster }}"
                        data-date="{{ $date }}"
                        data-vote="{{ $vote }}"
                        onclick="event.preventDefault(); toggleCardFavorite(this);"
                        style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.2); color: {{ $isFav ? '#ef4444' : '#fff' }}; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; transition: all 0.2s;">
                    <i class="{{ $isFav ? 'fas' : 'far' }} fa-heart"></i>
                </button>
            @endif
        @endauth
    </div>
    <div class="movie-info">
        <h3 class="movie-title">{{ $title }}</h3>
        <div class="movie-meta">
            <span>{{ $isPerson ? 'Kişi' : ($date ? substr($date, 0, 4) : 'N/A') }}</span>
            @if(!$isPerson)
                <div class="movie-rating">
                    <i class="fas fa-star"></i>
                    <span>{{ $vote ? number_format($vote, 1) : '0.0' }}</span>
                </div>
            @endif
        </div>
    </div>
</a>
