@extends('layouts.admin')

@section('content')
<div class="container" style="padding-top: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="section-title" style="margin-bottom: 0;"><i class="fas fa-users" style="color: var(--accent-color);"></i> Kullanıcı Yönetimi</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Geri Dön</a>
    </div>

    <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); overflow-x: auto;">
        
        <table style="width: 100%; text-align: left; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-color); background-color: rgba(255,255,255,0.02);">
                    <th style="padding: 1rem; font-weight: 600;">ID</th>
                    <th style="padding: 1rem; font-weight: 600;">Kullanıcı</th>
                    <th style="padding: 1rem; font-weight: 600;">E-Posta</th>
                    <th style="padding: 1rem; font-weight: 600; text-align: center;">Rol</th>
                    <th style="padding: 1rem; font-weight: 600;">Kayıt Tarihi</th>
                    <th style="padding: 1rem; font-weight: 600;">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 1rem; color: var(--text-muted);">#{{ $user->id }}</td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($user->avatar)
                                    <img src="{{ asset('avatars/' . $user->avatar) }}" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-base); display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <a href="{{ route('profile.show', $user->id) }}" target="_blank" style="font-weight: 500; color: var(--text-primary);">{{ $user->name }}</a>
                            </div>
                        </td>
                        <td style="padding: 1rem; color: var(--text-secondary);">{{ $user->email }}</td>
                        <td style="padding: 1rem; text-align: center;">
                            <span style="background-color: {{ $user->role === 'admin' ? 'rgba(99, 102, 241, 0.1)' : 'rgba(255, 255, 255, 0.05)' }}; color: {{ $user->role === 'admin' ? '#6366f1' : 'var(--text-secondary)' }}; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; display: inline-block;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td style="padding: 1rem; color: var(--text-muted); font-size: 0.9rem;">{{ $user->created_at->format('d M Y') }}</td>
                        <td style="padding: 1rem;">
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="padding: 0.4rem 0.75rem; border-color: rgba(239, 68, 68, 0.3); color: #ef4444;" title="Kullanıcıyı Sil">
                                    <i class="fas fa-trash"></i> Sil
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td style="padding: 2rem;" colspan="6" align="center">Sistemde henüz kayıtlı kullanıcı bulunmuyor.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 2rem;">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
