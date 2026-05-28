@extends('layouts.admin')

@section('content')
<div class="container" style="padding-top: 1rem;">

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <!-- İstatistik Kartı 1 -->
        <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); text-align: center;">
            <i class="fas fa-users fa-3x" style="color: var(--accent-color); margin-bottom: 1rem;"></i>
            <h3>Kullanıcı Yönetimi</h3>
            <p style="margin-top: 0.5rem; color: var(--text-muted);">Sisteme kayıtlı kullanıcıları görüntüleyin, yetkilerini düzenleyin veya engelleyin.</p>
            <a href="{{ route('admin.users') }}" class="btn btn-outline" style="margin-top: 1.5rem; width: 100%; display: inline-block; box-sizing: border-box;">Kullanıcıları Yönet</a>
        </div>

        <!-- İstatistik Kartı 2 -->
        <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); text-align: center;">
            <i class="fas fa-film fa-3x" style="color: var(--accent-color); margin-bottom: 1rem;"></i>
            <h3>Film Yönetimi</h3>
            <p style="margin-top: 0.5rem; color: var(--text-muted);">Veritabanındaki filmleri düzenleyin, özel koleksiyonlar oluşturun veya silin.</p>
            <a href="{{ route('admin.movies') }}" class="btn btn-outline" style="margin-top: 1.5rem; width: 100%; display: inline-block; box-sizing: border-box;">Filmleri Yönet</a>
        </div>

        <!-- İstatistik Kartı 3 -->
        <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); text-align: center;">
            <i class="fas fa-cogs fa-3x" style="color: var(--accent-color); margin-bottom: 1rem;"></i>
            <h3>Sistem Ayarları</h3>
            <p style="margin-top: 0.5rem; color: var(--text-muted);">TMDB API bağlantısını test edin, site ayarlarını ve önbelleği yapılandırın.</p>
            <a href="{{ route('admin.settings') }}" class="btn btn-outline" style="margin-top: 1.5rem; width: 100%; display: inline-block; box-sizing: border-box;">Ayarları Aç</a>
        </div>

    </div>
</div>
@endsection
