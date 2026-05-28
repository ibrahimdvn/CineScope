@extends('layouts.app')

@section('content')
<div class="container auth-wrapper">
    <div class="auth-container">
        <h2 class="auth-title">Şifre Sıfırlama</h2>
        
        <p style="color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 1.5rem; text-align: center; line-height: 1.5;">
            E-posta adresinizi girin, şifrenizi sıfırlamanız için size bir bağlantı gönderelim.
        </p>

        @if (session('status'))
            <div style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; padding: 0.75rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.875rem; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">E-Posta Adresi</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Şifre Sıfırlama Bağlantısı Gönder
            </button>
            
            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
                <a href="{{ route('login') }}" style="color: var(--text-secondary); text-decoration: none;" onmouseover="this.style.color='var(--accent-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fas fa-arrow-left" style="margin-right: 0.25rem;"></i> Giriş Sayfasına Dön
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
