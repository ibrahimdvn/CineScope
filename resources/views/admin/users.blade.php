@extends('layouts.admin')

@section('content')
<div class="container" style="padding-top: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="section-title" style="margin-bottom: 0;"><i class="fas fa-users" style="color: var(--accent-color);"></i> Kullanıcı Yönetimi</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Geri Dön</a>
    </div>

    <div class="admin-grid" style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 2rem; align-items: start;">
        <!-- Sol Kısım: Kullanıcı Listesi -->
        <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
            <table style="width: 100%; text-align: left; border-collapse: collapse;">
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

        <!-- Sağ Kısım: Aktivite Logları -->
        <style>
            .activity-container::-webkit-scrollbar {
                width: 6px;
            }
            .activity-container::-webkit-scrollbar-track {
                background: transparent;
            }
            .activity-container::-webkit-scrollbar-thumb {
                background-color: var(--border-color);
                border-radius: 3px;
            }
            .activity-container::-webkit-scrollbar-thumb:hover {
                background-color: var(--accent-color);
            }
        </style>
        <div style="background-color: var(--bg-surface); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); display: flex; flex-direction: column; max-height: 420px;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem; color: var(--text-primary); flex-shrink: 0;">
                <span><i class="fas fa-history" style="color: var(--accent-color);"></i> Aktivite Günlüğü</span>
                <span style="font-size: 0.72rem; background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.25rem 0.6rem; border-radius: 4px; font-weight: 600;">Canlı</span>
            </h3>
            
            <div class="activity-container" style="display: flex; flex-direction: column; gap: 1rem; overflow-y: auto; padding-right: 0.5rem; flex: 1;">
                @forelse($logs as $log)
                    @php
                        $icon = 'info-circle';
                        $color = '#3b82f6';
                        if ($log->activity_type === 'register') {
                            $icon = 'user-plus';
                            $color = '#10b981';
                        } elseif ($log->activity_type === 'login') {
                            $icon = 'sign-in-alt';
                            $color = '#8b5cf6';
                        } elseif ($log->activity_type === 'create_post') {
                            $icon = 'paper-plane';
                            $color = '#0070f3';
                        }
                    @endphp
                    <div style="display: flex; gap: 0.75rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.85rem; align-items: flex-start;">
                        <div style="background: {{ $color }}15; color: {{ $color }}; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem;">
                            <i class="fas fa-{{ $icon }}"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.82rem; color: var(--text-primary); line-height: 1.4; word-wrap: break-word;">
                                {{ $log->description }}
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.4rem; font-size: 0.72rem; color: var(--text-muted);">
                                <span><i class="far fa-clock"></i> {{ $log->created_at->diffForHumans() }}</span>
                                <span title="{{ $log->user_agent }}"><i class="fas fa-desktop"></i> {{ $log->ip_address }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: var(--text-muted); padding: 2rem 0; font-size: 0.88rem;">
                        Henüz bir aktivite kaydı bulunmuyor.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
