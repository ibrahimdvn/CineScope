<a href="{{ route('movies.show', $movie['id'] ?? $movie['tmdb_id']) }}" class="movie-card">
    <div class="movie-poster-wrapper">
        @if(isset($movie['poster_path']) && $movie['poster_path'])
            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="movie-poster">
        @else
            <div class="movie-poster" style="display:flex; align-items:center; justify-content:center; background:#334155;">
                <i class="fas fa-film fa-3x" style="color: #94a3b8;"></i>
            </div>
        @endif
    </div>
    <div class="movie-info">
        <h3 class="movie-title">{{ $movie['title'] }}</h3>
        <div class="movie-meta">
            <span>{{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'N/A' }}</span>
            <div class="movie-rating">
                <i class="fas fa-star"></i>
                <span>{{ isset($movie['vote_average']) ? number_format($movie['vote_average'], 1) : '0.0' }}</span>
            </div>
        </div>
    </div>
</a>
