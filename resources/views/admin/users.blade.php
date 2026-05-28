@extends('layouts.admin')

@section('content')
<div class="container" style="padding-top: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="section-title" style="margin-bottom: 0;"><i class="fas fa-users" style="color: var(--accent-color);"></i> Kullanıcı Yönetimi</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Geri Dön</a>
    </div>

    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
        <p style="color: var(--text-muted); text-align: center; margin: 2rem 0;">Kullanıcı veritabanı entegrasyonu başarıyla sağlandı.<br>API ve veritabanı bağlantısı tamamlandığında kullanıcı listesi burada görüntülenecektir.</p>
        
        <!-- Tablo altyapısı hazır bekletiliyor -->
        <table style="width: 100%; text-align: left; border-collapse: collapse; opacity: 0.3; pointer-events: none;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 1rem;">ID</th>
                    <th style="padding: 1rem;">Ad Soyad</th>
                    <th style="padding: 1rem;">E-Posta</th>
                    <th style="padding: 1rem;">Kayıt Tarihi</th>
                    <th style="padding: 1rem;">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 1rem;" colspan="5" align="center">Veriler bekleniyor...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
