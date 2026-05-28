@extends('layouts.app')

@section('content')
<div class="container auth-wrapper">
    <div class="auth-container">
        <h2 class="auth-title">Giriş Yap</h2>
        
        @if (session('success'))
            <div style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; padding: 0.75rem; border-radius: var(--radius-sm); margin-bottom: 1rem; font-size: 0.875rem; text-align: center;">
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
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

            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" style="font-size: 0.875rem;">Beni Hatırla</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: var(--accent-color); text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Şifremi Unuttum</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Giriş Yap
            </button>
            
            <div style="margin-top: 1rem; text-align: center; font-size: 0.875rem;">
                Hesabınız yok mu? <a href="{{ route('register') }}">Kayıt Ol</a>
            </div>
            
            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                <a href="{{ route('movies.index') }}" style="color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.color='var(--text-primary)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class="fas fa-arrow-left"></i> Anasayfaya Dön
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
