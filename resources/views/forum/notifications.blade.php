@extends('layouts.app')

@section('content')
<style>
.notif-wrap {
    display: flex;
    width: 100%;
    height: calc(100vh - 76px);
    overflow: hidden;
}

/* ---- LEFT NAV (forum ile aynı) ---- */
.notif-leftnav {
    width: 260px;
    flex-shrink: 0;
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    padding: 1.5rem 1rem;
    gap: 0.25rem;
    overflow-y: auto;
    background: var(--bg-base);
}
.n-nav-link {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    color: var(--text-secondary);
    font-size: 0.95rem;
    font-weight: 500;
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
}
.n-nav-link:hover { background: rgba(0, 112, 243, 0.08); color: var(--text-primary); }
.n-nav-link.active { background: rgba(0, 112, 243, 0.08); color: var(--accent-color); font-weight: 600; }
.n-nav-link i { width: 20px; text-align: center; }
.n-nav-divider { height: 1px; background: var(--border-color); margin: 0.75rem 0; }

/* ---- ORTA BÖLÜM ---- */
.notif-middle {
    flex: 1 1 0%;
    min-width: 0;
    border-right: 1px solid var(--border-color);
    overflow-y: auto;
    background: var(--bg-base);
    display: flex;
    flex-direction: column;
}
.notif-top {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    background: rgba(6, 8, 10, 0.85);
    backdrop-filter: blur(16px);
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 1rem;
}
[data-theme="light"] .notif-top {
    background: rgba(248, 250, 252, 0.85);
}
.notif-top h1 { font-size: 1.1rem; font-weight: 700; margin: 0; }

/* ---- BİLDİRİM ÖĞELERİ ---- */
.notif-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    transition: background 0.15s;
}
.notif-item:hover { background: rgba(255,255,255,0.02); }
.notif-item.unread { background: rgba(0, 112, 243, 0.04); }
.notif-icon {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 0.95rem;
}
.notif-icon.like    { background: rgba(239,68,68,0.12); color: #ef4444; }
.notif-icon.comment { background: rgba(0,112,243,0.12); color: var(--accent-color); }
.notif-body { flex: 1; min-width: 0; }
.notif-msg { font-size: 0.92rem; color: var(--text-secondary); line-height: 1.5; }
.notif-msg strong { color: var(--text-primary); font-weight: 600; }
.notif-time { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem; }
.notif-preview {
    margin-top: 0.5rem;
    padding: 0.6rem 0.9rem;
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.84rem;
    color: var(--text-muted);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.notif-unread-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--accent-color);
    flex-shrink: 0; margin-top: 0.4rem;
}
.notif-empty {
    flex: 1;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 4rem 2rem; gap: 0.75rem;
    color: var(--text-muted); text-align: center;
}
.notif-empty-icon {
    width: 60px; height: 60px; border-radius: 50%;
    background: rgba(0,112,243,0.08);
    display: flex; align-items: center; justify-content: center;
    color: var(--accent-color); font-size: 1.5rem; margin-bottom: 0.5rem;
}

/* ---- SAĞ BİLGİ PANELİ ---- */
.notif-right {
    width: 300px;
    flex-shrink: 0;
    background: var(--bg-base);
    padding: 1.5rem 1.25rem;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.notif-widget {
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    overflow: hidden;
}
.notif-widget-title {
    font-size: 0.95rem;
    font-weight: 700;
    padding: 0.9rem 1.2rem 0.75rem;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    display: flex; align-items: center; gap: 0.5rem;
}
.notif-stat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 1.2rem;
    border-bottom: 1px solid var(--border-color);
    font-size: 0.88rem;
}
.notif-stat-row:last-child { border-bottom: none; }
.notif-stat-label { color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem; }
.notif-stat-val { font-weight: 700; color: var(--text-primary); font-size: 1rem; }

/* ---- MOBİL UYUMLULUK (RESPONSIVE) ---- */
@media (max-width: 1000px) { .notif-right { display: none; } }
@media (max-width: 680px)  { .notif-leftnav { display: none; } .notif-middle { border: none; } }
</style>

<div class="notif-wrap">

    {{-- SOL YAN MENÜ --}}
    <aside class="notif-leftnav">
        <span style="font-size:0.7rem;font-weight:700;letter-spacing:.1em;color:var(--text-muted);text-transform:uppercase;padding:0.5rem 1rem 0.25rem;">Menü</span>
        <a href="{{ route('forum.index') }}" class="n-nav-link">
            <img src="{{ asset('images/logo.svg') }}" alt="CineScope Logo" style="width: 20px; height: 20px; object-fit: contain; flex-shrink: 0;"> Topluluk Akışı
        </a>
        <div class="n-nav-divider"></div>
        <span style="font-size:0.7rem;font-weight:700;letter-spacing:.1em;color:var(--text-muted);text-transform:uppercase;padding:0.5rem 1rem 0.25rem;">Kişisel</span>
        <a href="{{ route('profile.show', auth()->id()) }}" class="n-nav-link">
            <i class="fas fa-user fa-fw"></i> Profilim
        </a>
        <a href="{{ route('movies.favorites') }}" class="n-nav-link">
            <i class="fas fa-heart fa-fw"></i> Favorilerim
        </a>
        <a href="{{ route('notifications.index') }}" class="n-nav-link active">
            <i class="fas fa-bell fa-fw"></i> Bildirimler
        </a>
    </aside>

    {{-- ORTA ALAN: BİLDİRİMLER --}}
    <main class="notif-middle">
        <div class="notif-top">
            <a href="{{ route('forum.index') }}" style="color:var(--text-muted);text-decoration:none;display:flex;align-items:center;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Bildirimler</h1>
            @php $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count(); @endphp
            @if($unreadCount > 0)
                <span style="background:var(--accent-color);color:#fff;font-size:0.72rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:20px;">{{ $unreadCount }} yeni</span>
            @endif
        </div>

        @forelse($notifications as $notif)
        <div class="notif-item {{ $notif->isRead() ? '' : 'unread' }}">
            <div class="notif-icon {{ $notif->type }}">
                @if($notif->type === 'like')
                    <i class="fas fa-heart"></i>
                @else
                    <i class="fas fa-comment"></i>
                @endif
            </div>
            <div class="notif-body">
                <div class="notif-msg">
                    <strong>{{ $notif->fromUser->name }}</strong>
                    {{ $notif->type === 'like' ? 'gönderini beğendi.' : 'gönderine yorum yaptı.' }}
                </div>
                @if($notif->post)
                <div class="notif-preview">{{ Str::limit($notif->post->content, 90) }}</div>
                @endif
                <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
            </div>
            @if(!$notif->isRead())
                <div class="notif-unread-dot"></div>
            @endif
        </div>
        @empty
        <div class="notif-empty">
            <div class="notif-empty-icon"><i class="fas fa-bell"></i></div>
            <h3 style="font-size:1.1rem;font-weight:700;color:var(--text-primary);">Bildirim yok</h3>
            <p style="font-size:0.9rem;max-width:260px;">Birileri gönderini beğendiğinde veya yorum yaptığında burada göreceksin.</p>
        </div>
        @endforelse

        <div style="padding:1rem;display:flex;justify-content:center;">
            {{ $notifications->links() }}
        </div>
    </main>

    {{-- RIGHT PANEL --}}
    <aside class="notif-right">
        <div class="notif-widget">
            <div class="notif-widget-title">
                <i class="fas fa-chart-pie" style="color:var(--accent-color);"></i> Bildirim Özeti
            </div>
            @php
                $totalLikes    = auth()->user()->notifications()->where('type','like')->count();
                $totalComments = auth()->user()->notifications()->where('type','comment')->count();
                $unread        = auth()->user()->notifications()->whereNull('read_at')->count();
            @endphp
            <div class="notif-stat-row">
                <span class="notif-stat-label"><i class="fas fa-heart" style="color:#ef4444;"></i> Beğeni</span>
                <span class="notif-stat-val">{{ $totalLikes }}</span>
            </div>
            <div class="notif-stat-row">
                <span class="notif-stat-label"><i class="fas fa-comment" style="color:var(--accent-color);"></i> Yorum</span>
                <span class="notif-stat-val">{{ $totalComments }}</span>
            </div>
            <div class="notif-stat-row">
                <span class="notif-stat-label"><i class="fas fa-circle" style="color:#f59e0b; font-size:0.5rem;"></i> Okunmamış</span>
                <span class="notif-stat-val" style="{{ $unread > 0 ? 'color:#f59e0b;' : '' }}">{{ $unread }}</span>
            </div>
        </div>

        <div class="notif-widget">
            <div class="notif-widget-title">
                <i class="fas fa-link" style="color:var(--accent-color);"></i> Hızlı Erişim
            </div>
            <div style="padding:0.75rem 1.2rem;display:flex;flex-direction:column;gap:0.5rem;">
                <a href="{{ route('forum.index') }}" style="color:var(--text-secondary);text-decoration:none;font-size:0.88rem;display:flex;align-items:center;gap:0.5rem;">
                    <i class="fas fa-film" style="width:16px;color:var(--accent-color);"></i> Topluluk Akışı
                </a>
                <a href="{{ route('profile.show', auth()->id()) }}" style="color:var(--text-secondary);text-decoration:none;font-size:0.88rem;display:flex;align-items:center;gap:0.5rem;">
                    <i class="fas fa-user" style="width:16px;color:var(--accent-color);"></i> Profilim
                </a>
                <a href="{{ route('movies.favorites') }}" style="color:var(--text-secondary);text-decoration:none;font-size:0.88rem;display:flex;align-items:center;gap:0.5rem;">
                    <i class="fas fa-heart" style="width:16px;color:#ef4444;"></i> Favorilerim
                </a>
            </div>
        </div>
    </aside>

</div>
@endsection
