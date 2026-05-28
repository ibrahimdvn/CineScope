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
</div>
@endsection
