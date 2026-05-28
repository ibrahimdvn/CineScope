@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <!-- Profile Header -->
    <div class="movie-card profile-card" style="margin-bottom: 4rem;">
        <div class="profile-layout">
            <div class="profile-sidebar" style="justify-content: center;">
                <div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; background-color: var(--bg-surface-hover); display: flex; align-items: center; justify-content: center; border: 3px solid var(--accent-color); box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);">
                    @if($user->avatar)
                        <img src="{{ asset('avatars/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-user fa-5x" style="color: var(--text-muted);"></i>
                    @endif
                </div>
            </div>
            
            <div class="profile-content">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                            <h1 style="font-size: 2.5rem; color: var(--text-primary); letter-spacing: -0.02em; margin: 0;">{{ $user->name }}</h1>
                            @if($user->role === 'admin')
                                <span style="background: rgba(99, 102, 241, 0.15); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.3); padding: 0.3rem 0.8rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                                    <i class="fas fa-shield-alt"></i> Moderatör
                                </span>
                            @endif
                        </div>
                        <p style="color: var(--text-muted); margin: 0;"><i class="fas fa-calendar-alt"></i> Katılım: {{ $user->created_at->format('M Y') }}</p>
                    </div>
                    
                    @if(Auth::id() === $user->id)
                        <a href="{{ route('profile.index') }}" class="btn btn-outline" style="border-radius: var(--radius-sm);">
                            <i class="fas fa-edit"></i> Profili Düzenle
                        </a>
                    @endif
                </div>

                @if($user->bio)
                    <div style="background: rgba(255,255,255,0.02); padding: 1.5rem; border-radius: var(--radius-sm); border-left: 4px solid var(--accent-color);">
                        <p style="color: var(--text-secondary); line-height: 1.8; margin: 0; font-size: 1.05rem;">
                            {{ $user->bio }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Favorite Movies -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <h2 class="section-title" style="margin: 0;"><i class="fas fa-heart" style="color: var(--danger-color);"></i> Favori Filmleri</h2>
        <span style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color); padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 600; font-size: 0.875rem;">
            {{ $favoriteMovies->total() }} Film
        </span>
    </div>

    @if($favoriteMovies->count() > 0)
        <div class="movie-grid">
            @foreach($favoriteMovies as $movie)
                <!-- We pass 'movie' in the format expected by the component (which uses array syntax or object access) -->
                <!-- Since $movie is an Eloquent model here, we can pass it directly -->
                @include('components.movie-card', ['movie' => $movie])
            @endforeach
        </div>

        @if($favoriteMovies->lastPage() > 1)
            <div class="pagination" style="margin-top: 3rem;">
                {{ $favoriteMovies->links() }}
            </div>
        @endif
    @else
        <div style="text-align: center; padding: 5rem 0; background: var(--bg-surface); border-radius: var(--radius-md); border: 1px dashed var(--border-color);">
            <i class="fas fa-film fa-4x" style="color: var(--text-muted); margin-bottom: 1.5rem;"></i>
            <h3 style="color: var(--text-primary); font-size: 1.5rem; margin-bottom: 0.5rem;">Henüz favori filmi yok</h3>
            <p style="color: var(--text-secondary);">Bu kullanıcı henüz hiç film beğenmemiş.</p>
        </div>
    @endif
</div>
@endsection
