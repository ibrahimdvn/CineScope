@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <h2 class="section-title"><i class="fas fa-user-edit" style="color: var(--accent-color);"></i> Profili Düzenle</h2>
    
    @if(session('success'))
        <div style="background-color: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 2rem; border: 1px solid rgba(16, 185, 129, 0.2);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="movie-card profile-card">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="profile-layout">
                
                <!-- Sol Kısım: Fotoğraf -->
                <div class="profile-sidebar">
                    <div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; background-color: var(--bg-surface-hover); display: flex; align-items: center; justify-content: center; border: 3px solid var(--accent-color); box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);">
                        @if($user->avatar)
                            <img src="{{ asset('avatars/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-user fa-5x" style="color: var(--text-muted);"></i>
                        @endif
                    </div>
                    
                    <div style="width: 100%; text-align: center;">
                        <label for="avatar" class="btn btn-outline" style="cursor: pointer; display: inline-flex; width: 100%; justify-content: center; padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-camera"></i> Fotoğraf Seç
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" onchange="document.getElementById('file-name').textContent = this.files[0].name">
                        <div id="file-name" style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.5rem; word-break: break-all;"></div>
                        @error('avatar')
                            <div style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Sağ Kısım: Bilgiler -->
                <div class="profile-content">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div>
                            <label for="name" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">Ad Soyad</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background-color: var(--bg-base); color: var(--text-primary); outline: none; transition: border-color 0.2s;">
                            @error('name')
                                <div style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">E-posta Adresi</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background-color: var(--bg-base); color: var(--text-primary); outline: none; transition: border-color 0.2s;">
                            @error('email')
                                <div style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="bio" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">Hakkımda (Açıklama)</label>
                        <textarea id="bio" name="bio" rows="4" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background-color: var(--bg-base); color: var(--text-primary); outline: none; transition: border-color 0.2s;">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <div style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                        <div>
                            <label for="password" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">Yeni Şifre (İsteğe bağlı)</label>
                            <input type="password" id="password" name="password" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background-color: var(--bg-base); color: var(--text-primary); outline: none; transition: border-color 0.2s;">
                            @error('password')
                                <div style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">Yeni Şifre Tekrar</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background-color: var(--bg-base); color: var(--text-primary); outline: none; transition: border-color 0.2s;">
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem; font-size: 1rem;">
                            <i class="fas fa-save"></i> Değişiklikleri Kaydet
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Tehlikeli Bölge: Hesabı Sil -->
    <div class="movie-card profile-card" style="margin-top: 2rem; border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.02); padding: 1.5rem 2rem;">
        <h3 style="color: #ef4444; font-size: 1.1rem; font-weight: 700; margin-top: 0; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-exclamation-triangle"></i> Tehlikeli Bölge
        </h3>
        <p style="color: var(--text-secondary); font-size: 0.88rem; margin: 0 0 1.5rem 0; line-height: 1.5;">
            Hesabınızı sildiğinizde, favorileriniz, gönderileriniz, beğenileriniz ve tüm kişisel verileriniz kalıcı olarak silinecektir. Bu işlem geri alınamaz.
        </p>
        <div style="display: flex; justify-content: flex-start;">
            <button type="button" class="btn" onclick="openDeleteAccountModal()"
                    style="background: #ef4444; color: #fff; border: none; padding: 0.75rem 1.5rem; font-size: 0.88rem; border-radius: var(--radius-sm); font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: background 0.2s; cursor: pointer;"
                    onmouseover="this.style.background='#dc2626'"
                    onmouseout="this.style.background='#ef4444'">
                <i class="fas fa-trash-alt"></i> Hesabımı Kalıcı Olarak Sil
            </button>
        </div>
    </div>

    <!-- HESAP SİLME ONAY MODALİ -->
    <div id="cs-delete-account-modal" class="cs-alert" onclick="if(event.target===this) closeDeleteAccountModal()">
        <div class="cs-alert-box">
            <div class="cs-alert-icon"><i class="fas fa-trash-alt"></i></div>
            <div class="cs-alert-title">Hesabınızı Silmek İstiyor musunuz?</div>
            <div class="cs-alert-desc">Bu işlem geri alınamaz. Şifrenizi onaylayarak hesabınızı kalıcı olarak silebilirsiniz.</div>
            
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div style="margin-bottom: 1.5rem; text-align: left;">
                    <label for="delete_confirm_password" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-size: 0.82rem;">Mevcut Şifreniz</label>
                    <input type="password" id="delete_confirm_password" name="password" required placeholder="Şifrenizi yazın..." 
                           style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background-color: var(--bg-base); color: var(--text-primary); outline: none;">
                    @error('delete_confirm')
                        <span style="color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="cs-alert-actions">
                    <button type="button" class="cs-alert-cancel" onclick="closeDeleteAccountModal()">İptal</button>
                    <button type="submit" class="cs-alert-confirm" style="display: flex; align-items: center; gap: 0.4rem; justify-content: center;"><i class="fas fa-trash-alt"></i> Sil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.cs-alert {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
}
.cs-alert-box {
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 2rem;
    max-width: 380px;
    width: 90%;
    text-align: center;
    box-shadow: var(--shadow-lg);
    animation: alertSlide 0.25s ease;
}
@keyframes alertSlide {
    from { transform: scale(0.92) translateY(16px); opacity: 0; }
    to   { transform: scale(1) translateY(0); opacity: 1; }
}
.cs-alert-icon {
    width: 52px; height: 52px; border-radius: 50%;
    background: rgba(239, 68, 68, 0.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; color: #ef4444;
    margin: 0 auto 1rem;
}
.cs-alert-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.4rem; color: var(--text-primary); }
.cs-alert-desc { font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.4; }
.cs-alert-actions { display: flex; gap: 0.75rem; justify-content: center; }
.cs-alert-cancel {
    flex: 1;
    padding: 0.6rem 1.5rem; border-radius: 8px;
    border: 1px solid var(--border-color); background: transparent;
    color: var(--text-primary); font-size: 0.9rem; cursor: pointer;
    transition: background 0.2s;
}
.cs-alert-cancel:hover { background: var(--bg-surface-hover); }
.cs-alert-confirm {
    flex: 1;
    padding: 0.6rem 1.5rem; border-radius: 8px;
    border: none; background: #ef4444;
    color: #fff; font-size: 0.9rem; font-weight: 600; cursor: pointer;
    transition: background 0.2s;
}
.cs-alert-confirm:hover { background: #dc2626; }
</style>

@push('scripts')
<script>
    function openDeleteAccountModal() {
        document.getElementById('cs-delete-account-modal').style.display = 'flex';
        document.getElementById('delete_confirm_password').focus();
    }
    function closeDeleteAccountModal() {
        document.getElementById('cs-delete-account-modal').style.display = 'none';
    }
</script>
@endpush

@if($errors->has('delete_confirm'))
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        openDeleteAccountModal();
    });
</script>
@endpush
@endif

@endsection
