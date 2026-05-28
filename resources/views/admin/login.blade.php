@extends('layouts.admin')

@section('content')
<div class="auth-wrapper">
    <div class="auth-container">
        <h2 class="auth-title">Yönetici Girişi</h2>
        
        @if($errors->any())
            <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger-color); color: var(--danger-color); padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; text-align: center;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.authenticate') }}">
            @csrf

            <div class="form-group">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-accent btn-block" style="margin-top: 1.5rem;">
                Giriş Yap
            </button>
        </form>
    </div>
</div>
@endsection
