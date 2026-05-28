@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
    <h2 class="section-title"><i class="fas fa-search" style="color: var(--accent-color);"></i> Arama Sonuçları: "{{ $query }}"</h2>
    
    {{-- Kayıtlı Üyeler Bölümü --}}
    @if(isset($users) && count($users) > 0)
        <div style="margin-bottom: 3rem;">
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; color: var(--text-primary);">
                <i class="fas fa-users" style="color: var(--accent-color);"></i> Eşleşen Üyeler ({{ count($users) }})
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem;">
                @foreach($users as $user)
                    <a href="{{ route('profile.show', $user->id) }}" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-md); text-decoration: none; color: var(--text-primary); transition: transform 0.2s, border-color 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='var(--accent-color)'" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border-color)'">
                        <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; background: var(--bg-base); flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                            @if($user->avatar)
                                <img src="{{ asset('avatars/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-user fa-lg" style="color: var(--text-muted);"></i>
                            @endif
                        </div>
                        <div style="min-width: 0; flex: 1;">
                            <div style="font-weight: 600; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $user->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $user->bio ?? 'CineScope Üyesi' }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <hr style="border: 0; border-top: 1px solid var(--border-color); margin-bottom: 2.5rem;">
    @endif

    {{-- Filmler ve Diziler Bölümü --}}
    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; color: var(--text-primary);">
        <i class="fas fa-film" style="color: var(--accent-color);"></i> Filmler ve Diziler
    </h3>

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
            <i class="fas fa-film fa-3x" style="color: #64748b; margin-bottom: 1rem;"></i>
            <h3>Film veya dizi bulunamadı</h3>
            <p style="color: #94a3b8;">Lütfen farklı bir anahtar kelime ile tekrar deneyin.</p>
        </div>
    @endif
</div>
@endsection
