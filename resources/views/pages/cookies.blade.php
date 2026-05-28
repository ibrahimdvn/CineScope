@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title"><i class="fas fa-cookie-bite" style="color: var(--accent-color);"></i> Çerez Politikası</h2>
    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); line-height: 1.8;">
        <p>Sizlere daha iyi hizmet verebilmek amacıyla sitemizde çerezler (cookies) kullanıyoruz.</p>
        <h4 style="margin-top: 1.5rem; margin-bottom: 0.5rem; color: var(--text-primary);">Neden Çerez Kullanıyoruz?</h4>
        <ul style="margin-left: 1.5rem;">
            <li><strong>Oturum Yönetimi:</strong> Sisteme giriş yapan kullanıcıların oturumlarını açık tutmak için zorunlu çerezler kullanılır.</li>
            <li><strong>Performans ve Analiz:</strong> Hangi sayfaların daha çok ziyaret edildiğini anlamak için anonim veriler toplanır.</li>
            <li><strong>Kişiselleştirme:</strong> Tercihlerinizi (örneğin tema seçimi) hatırlamak için.</li>
        </ul>
        <p style="margin-top: 1.5rem;">Çerez kullanımını tarayıcı ayarlarınızdan istediğiniz zaman devre dışı bırakabilirsiniz.</p>
    </div>
</div>
@endsection
