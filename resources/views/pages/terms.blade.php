@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title"><i class="fas fa-file-contract" style="color: var(--accent-color);"></i> Kullanım Koşulları</h2>
    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); line-height: 1.8;">
        <p>CineScope platformunu kullanarak aşağıdaki şartları ve kuralları kabul etmiş sayılırsınız:</p>
        <ul style="margin-top: 1rem; margin-left: 1.5rem;">
            <li>Sitede yer alan film bilgileri ve görselleri The Movie Database (TMDB) API aracılığıyla sağlanmaktadır.</li>
            <li>Platformdaki içeriklerin ticari amaçla kopyalanması, çoğaltılması ve dağıtılması yasaktır.</li>
            <li>CineScope, platform üzerinde önceden bildirmeksizin değişiklik yapma hakkını saklı tutar.</li>
            <li>Kullanıcılar, oluşturdukları hesapların güvenliğinden kendileri sorumludur.</li>
        </ul>
    </div>
</div>
@endsection
