@extends('layouts.admin')

@section('content')
<div class="container" style="padding-top: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="section-title" style="margin-bottom: 0;"><i class="fas fa-cogs" style="color: var(--accent-color);"></i> Sistem Ayarları</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Geri Dön</a>
    </div>

    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); max-width: 600px;">
        <h4 style="margin-bottom: 1.5rem; color: var(--text-primary); border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">API Yapılandırması</h4>
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" style="color: var(--text-secondary);">TMDB API Anahtarı (API Key)</label>
            <input type="text" class="form-control" value="{{ env('TMDB_API_KEY', '') }}" placeholder="API Anahtarınızı girin..." disabled style="opacity: 0.7; cursor: not-allowed;">
            <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;"><i class="fas fa-info-circle"></i> Güvenlik sebebiyle API anahtarı sadece .env dosyası üzerinden değiştirilebilir.</small>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" style="color: var(--text-secondary);">Varsayılan Dil (Language)</label>
            <input type="text" class="form-control" value="tr-TR" disabled style="opacity: 0.7; cursor: not-allowed;">
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button class="btn btn-accent" disabled>Değişiklikleri Kaydet</button>
            <button class="btn btn-outline" disabled>Önbelleği Temizle (Cache)</button>
        </div>
    </div>
</div>
@endsection
