@extends('layouts.app')

@section('content')
<div class="container auth-wrapper">
    <div class="auth-container">
        <h2 class="auth-title">Kayıt Ol</h2>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Ad Soyad</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">E-Posta</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    <button type="button" id="send-code-btn" class="btn btn-outline" style="white-space: nowrap; display: none; padding: 0.5rem 1rem;">Kodu Gönder</button>
                </div>

                @error('email')
                    <span style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <span id="email-verification-message" style="font-size: 0.8rem; margin-top: 0.25rem; display: block;"></span>
            </div>

            <div class="form-group" id="verification-code-group" style="display: none;">
                <label for="verification_code" class="form-label">E-Posta Doğrulama Kodu</label>
                <input id="verification_code" type="text" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" placeholder="6 haneli kodu girin" maxlength="6" autocomplete="off">
                
                @error('verification_code')
                    <span style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Şifre Tekrar</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Kayıt Ol
            </button>
            
            <div style="margin-top: 1rem; text-align: center; font-size: 0.875rem;">
                Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const sendCodeBtn = document.getElementById('send-code-btn');
    const verificationGroup = document.getElementById('verification-code-group');
    const verificationInput = document.getElementById('verification_code');
    const messageSpan = document.getElementById('email-verification-message');

    // Sayfa yüklendiğinde eski veri varsa veya hata durumunda kontrol et
    checkEmailDomain();

    emailInput.addEventListener('input', checkEmailDomain);

    function checkEmailDomain() {
        const email = emailInput.value.trim().toLowerCase();
        if (email.endsWith('@gmail.com')) {
            sendCodeBtn.style.display = 'block';
            verificationGroup.style.display = 'block';
            verificationInput.required = true;
        } else {
            sendCodeBtn.style.display = 'none';
            verificationGroup.style.display = 'none';
            verificationInput.required = false;
        }
    }

    sendCodeBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        if (!email || !email.toLowerCase().endsWith('@gmail.com')) {
            alert('Lütfen geçerli bir Gmail adresi girin.');
            return;
        }

        sendCodeBtn.disabled = true;
        sendCodeBtn.textContent = 'Gönderiliyor...';
        messageSpan.style.color = '#38bdf8';
        messageSpan.textContent = 'Doğrulama kodu gönderiliyor...';

        fetch("{{ route('register.sendCode') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageSpan.style.color = '#22c55e';
                messageSpan.textContent = data.message;
                verificationGroup.style.display = 'block';
                verificationInput.focus();

                // 60 saniye boyunca butonu deaktif yap
                let countdown = 60;
                const interval = setInterval(() => {
                    countdown--;
                    if (countdown <= 0) {
                        clearInterval(interval);
                        sendCodeBtn.disabled = false;
                        sendCodeBtn.textContent = 'Kodu Gönder';
                    } else {
                        sendCodeBtn.textContent = `Tekrar Gönder (${countdown})`;
                    }
                }, 1000);
            } else {
                messageSpan.style.color = 'var(--danger-color)';
                messageSpan.textContent = data.message || 'Kod gönderilirken bir hata oluştu.';
                sendCodeBtn.disabled = false;
                sendCodeBtn.textContent = 'Kodu Gönder';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageSpan.style.color = 'var(--danger-color)';
            messageSpan.textContent = 'Sunucuyla bağlantı kurulurken bir hata oluştu.';
            sendCodeBtn.disabled = false;
            sendCodeBtn.textContent = 'Kodu Gönder';
        });
    });
});
</script>
@endpush
