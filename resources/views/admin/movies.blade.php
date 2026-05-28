@extends('layouts.admin')

@section('content')
<div class="container" style="padding-top: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="section-title" style="margin-bottom: 0;"><i class="fas fa-film" style="color: var(--accent-color);"></i> Film Yönetimi</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Geri Dön</a>
    </div>

    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
            <p style="color: var(--text-secondary);">TMDB API Entegrasyonu bekleniyor...</p>
            <button class="btn btn-accent btn-sm" disabled><i class="fas fa-sync-alt"></i> Senkronize Et</button>
        </div>
        
        <div style="text-align: center; padding: 3rem 0;">
            <i class="fas fa-database fa-3x" style="color: var(--text-muted); margin-bottom: 1rem;"></i>
            <p style="color: var(--text-muted);">API bağlantısı kurulduğunda, TMDB veritabanındaki filmler burada yönetilebilecektir.</p>
        </div>
    </div>
</div>
@endsection
