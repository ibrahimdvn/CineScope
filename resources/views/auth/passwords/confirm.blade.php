@extends('layouts.app')

@section('content')
<div class="container auth-wrapper">
    <div class="auth-container">
        <h2 class="auth-title">Şifreyi Onayla</h2>
        
        <p style="color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 1.5rem; text-align: center; line-height: 1.5;">
            Lütfen devam etmeden önce şifrenizi doğrulayın.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Şifreyi Onayla
            </button>
            
            @if (Route::has('password.request'))
                <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
                    <a href="{{ route('password.request') }}" style="color: var(--text-secondary); text-decoration: none;" onmouseover="this.style.color='var(--accent-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                        Şifrenizi mi unuttunuz?
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
