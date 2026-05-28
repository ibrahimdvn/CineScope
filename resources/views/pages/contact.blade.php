@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title"><i class="fas fa-envelope" style="color: var(--accent-color);"></i> İletişim</h2>
    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); line-height: 1.8;">
        <p>Bize ulaşmak için aşağıdaki kanalları kullanabilirsiniz:</p>
        <ul style="margin-top: 1rem; list-style-type: none; padding-left: 0;">
            <li style="margin-bottom: 0.5rem;"><i class="fas fa-envelope" style="width: 25px; color: var(--text-secondary);"></i> <strong>E-Posta:</strong> ibrahimcanduven1@gmail.com</li>
            <li style="margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt" style="width: 25px; color: var(--text-secondary);"></i> <strong>Adres:</strong> Balıkesir, Türkiye</li>
        </ul>
        <p style="margin-top: 2rem; color: var(--text-muted); font-size: 0.9rem;">Destek taleplerinize en geç 48 saat içerisinde dönüş yapılmaktadır.</p>
    </div>
</div>
@endsection
