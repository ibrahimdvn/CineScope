@extends('layouts.app')

@section('content')
<div class="container auth-wrapper">
    <div class="auth-container">
        <h2 class="auth-title">Yeni Şifre Belirle</h2>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email" class="form-label">E-Posta Adresi</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Yeni Şifre</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Yeni Şifre Tekrar</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Şifreyi Güncelle
            </button>
        </form>
    </div>
</div>
@endsection
