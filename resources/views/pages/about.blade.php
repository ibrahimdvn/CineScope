@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title"><i class="fas fa-info-circle" style="color: var(--accent-color);"></i> Hakkımızda</h2>
    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); line-height: 1.8;">
        <p>CineScope, sinemaseverler için geliştirilmiş modern ve kullanıcı odaklı bir platformdur. Amacımız, dünyanın dört bir yanından binlerce filmi, güncel vizyon bilgilerini ve popüler içerikleri tek bir çatı altında toplamaktır.</p>
        <p style="margin-top: 1rem;">Kullanıcılarımız, kişisel hesaplarını oluşturarak favori filmlerini kaydedebilir, aradıkları içeriklere hızlıca ulaşabilir ve sinema dünyasının nabzını tutabilirler.</p>
        <p style="margin-top: 1rem;">Altyapımız TMDB (The Movie Database) API kullanılarak güçlendirilmiştir.</p>
    </div>
</div>
@endsection
