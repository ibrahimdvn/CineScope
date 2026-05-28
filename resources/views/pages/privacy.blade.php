@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title"><i class="fas fa-user-shield" style="color: var(--accent-color);"></i> Gizlilik Politikası</h2>
    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); line-height: 1.8;">
        <p>Gizliliğiniz bizim için önemlidir. CineScope, kişisel verilerinizi korumayı taahhüt eder.</p>
        <ul style="margin-top: 1rem; margin-left: 1.5rem;">
            <li>Sitemize üye olurken paylaştığınız e-posta ve şifre bilgileriniz güvenli bir şekilde şifrelenerek saklanır.</li>
            <li>Favoriye eklediğiniz filmler ve arama geçmişiniz sadece size daha iyi bir deneyim sunmak için kullanılır.</li>
            <li>Kişisel verileriniz hiçbir suretle üçüncü şahıslara veya kurumlara satılmaz.</li>
            <li>Kullanıcılar, diledikleri zaman hesaplarını ve bağlı verileri silme hakkına sahiptir.</li>
        </ul>
    </div>
</div>
@endsection
