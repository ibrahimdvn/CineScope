@extends('layouts.app')

@section('content')
<style>
/* ===== CineScope Topluluk — Full Page Layout ===== */
.cs-forum-wrap {
    display: flex;
    width: 100%;
    height: calc(100vh - 76px);
    overflow: hidden;
}

/* ---- LEFT: Quick Nav ---- */
.cs-sidebar-left {
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
.cs-nav-link {
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
.cs-nav-link:hover, .cs-nav-link.active {
    background: rgba(0, 112, 243, 0.08);
    color: var(--text-primary);
}
.cs-nav-link.active {
    color: var(--accent-color);
    font-weight: 600;
}
.cs-nav-link i { width: 20px; text-align: center; font-size: 1rem; }
.cs-nav-divider {
    height: 1px;
    background: var(--border-color);
    margin: 0.75rem 0;
}
.cs-nav-section-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    text-transform: uppercase;
    padding: 0.5rem 1rem 0.25rem;
}
.cs-sidebar-user {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 10px;
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
}
.cs-sidebar-user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.9rem;
    background: linear-gradient(135deg, #0070f3, #7c3aed);
    color: #fff; flex-shrink: 0;
}
.cs-sidebar-user-name { font-size: 0.9rem; font-weight: 600; line-height: 1.2; }
.cs-sidebar-user-handle { font-size: 0.78rem; color: var(--text-muted); }

/* ---- MIDDLE: Feed ---- */
.cs-feed-col {
    flex: 1 1 0%;
    display: flex;
    flex-direction: column;
    min-width: 0;
    overflow-y: auto;
    border-right: 1px solid var(--border-color);
    background: var(--bg-base);
}
.cs-feed-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    background: rgba(6, 8, 10, 0.85);
    backdrop-filter: blur(16px);
    z-index: 10;
}
[data-theme="light"] .cs-feed-header {
    background: rgba(248, 250, 252, 0.85);
}
.cs-feed-header h1 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}
.cs-feed-tabs {
    display: flex;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
}
.cs-feed-tab {
    flex: 1;
    padding: 1rem;
    text-align: center;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    position: relative;
    transition: color 0.2s;
    background: none;
    border: none;
}
.cs-feed-tab.active {
    color: var(--text-primary);
}
.cs-feed-tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 50%;
    transform: translateX(-50%);
    width: 40px; height: 3px;
    border-radius: 2px;
    background: var(--accent-color);
}
.cs-compose-box {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    gap: 1rem;
}
.cs-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg, #0070f3, #7c3aed);
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1rem; color: #fff;
    overflow: hidden;
}
.cs-avatar img { width: 100%; height: 100%; object-fit: cover; }
.cs-compose-inner { flex: 1; min-width: 0; }
.cs-compose-textarea {
    width: 100%;
    background: transparent;
    border: none;
    outline: none;
    color: var(--text-primary);
    font-size: 1rem;
    resize: none;
    font-family: inherit;
    line-height: 1.5;
    padding: 0.5rem 0;
    min-height: 56px;
}
.cs-compose-textarea::placeholder { color: var(--text-muted); }
.cs-compose-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid var(--border-color);
    padding-top: 0.75rem;
    margin-top: 0.5rem;
}
.cs-compose-tools { display: flex; gap: 0.25rem; }
.cs-tool-btn {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 8px;
    color: var(--accent-color);
    font-size: 0.95rem;
    cursor: pointer;
    transition: background 0.2s;
    background: none; border: none;
}
.cs-tool-btn:hover { background: rgba(0, 112, 243, 0.1); }
.cs-post-btn {
    padding: 0.5rem 1.25rem;
    background: var(--accent-color);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
}
.cs-post-btn:hover { background: var(--accent-hover); transform: translateY(-1px); }

/* ---- POST CARD ---- */
.cs-post {
    display: flex;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    transition: background 0.15s;
    cursor: default;
}
.cs-post:hover { background: rgba(255,255,255,0.02); }
.cs-post-meta {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    margin-bottom: 0.35rem;
    flex-wrap: wrap;
}
.cs-post-meta a {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--text-primary);
    text-decoration: none;
}
.cs-post-meta a:hover { color: var(--accent-color); }
.cs-post-handle { font-size: 0.85rem; color: var(--text-muted); }
.cs-post-body { font-size: 0.95rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 0.85rem; white-space: pre-wrap; word-break: break-word; }
.cs-post-actions { display: flex; gap: 1.5rem; }
.cs-action-btn {
    display: flex; align-items: center; gap: 0.4rem;
    font-size: 0.82rem; color: var(--text-muted);
    cursor: pointer; border: none; background: none;
    padding: 0.3rem 0.5rem;
    border-radius: 6px;
    transition: background 0.2s, color 0.2s;
}
.cs-action-btn:hover { color: var(--accent-color); background: rgba(0, 112, 243, 0.07); }
.cs-action-btn.like:hover { color: #ef4444; background: rgba(239, 68, 68, 0.07); }
.cs-action-btn.delete:hover { color: #ef4444; background: rgba(239, 68, 68, 0.07); }

/* ---- RIGHT: Sidebar ---- */
.cs-sidebar-right {
    width: 320px;
    flex-shrink: 0;
    background: var(--bg-base);
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    padding: 1.5rem 1.25rem;
    overflow-y: auto;
}
.cs-widget {
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    overflow: hidden;
}
.cs-widget-title {
    font-size: 1rem;
    font-weight: 800;
    padding: 1rem 1.25rem 0.75rem;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    display: flex; align-items: center; gap: 0.6rem;
}
.cs-widget-title i { color: var(--accent-color); }
.cs-trend-item {
    padding: 0.85rem 1.25rem;
    border-bottom: 1px solid var(--border-color);
    cursor: pointer;
    transition: background 0.15s;
}
.cs-trend-item:last-child { border-bottom: none; }
.cs-trend-item:hover { background: rgba(255,255,255,0.02); }
.cs-trend-tag {
    display: inline-block;
    font-size: 0.75rem;
    background: rgba(0, 112, 243, 0.1);
    color: var(--accent-color);
    border-radius: 4px;
    padding: 0.1rem 0.5rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.cs-trend-title { font-weight: 700; font-size: 0.92rem; color: var(--text-primary); }
.cs-trend-count { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.1rem; }
.cs-user-suggest {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0.85rem 1.25rem;
    border-bottom: 1px solid var(--border-color);
    cursor: pointer; transition: background 0.15s;
}
.cs-user-suggest:last-child { border-bottom: none; }
.cs-user-suggest:hover { background: rgba(255,255,255,0.02); }
.cs-user-info { display: flex; align-items: center; gap: 0.75rem; }
.cs-suggest-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.9rem; color: #fff; flex-shrink: 0;
}
.cs-suggest-name { font-weight: 700; font-size: 0.9rem; color: var(--text-primary); line-height: 1.2; }
.cs-suggest-handle { font-size: 0.78rem; color: var(--text-muted); }
.cs-follow-btn {
    padding: 0.35rem 1rem;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 700;
    border: 1px solid var(--border-color);
    background: transparent;
    color: var(--text-primary);
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
}
.cs-follow-btn:hover { background: var(--accent-color); border-color: var(--accent-color); color: #fff; }

.cs-search-box {
    display: flex; align-items: center;
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 0.65rem 1rem;
    gap: 0.75rem;
    transition: border-color 0.2s;
}
.cs-search-box:focus-within { border-color: var(--accent-color); }
.cs-search-box i { color: var(--text-muted); font-size: 0.9rem; }
.cs-search-box input {
    background: transparent; border: none; outline: none;
    color: var(--text-primary); font-size: 0.9rem;
    width: 100%; font-family: inherit;
}
.cs-search-box input::placeholder { color: var(--text-muted); }

/* ---- Empty State ---- */
.cs-empty {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 4rem 2rem; text-align: center; gap: 0.75rem;
    color: var(--text-muted); flex: 1;
}
.cs-empty-icon {
    width: 60px; height: 60px; border-radius: 50%;
    background: rgba(0, 112, 243, 0.08);
    display: flex; align-items: center; justify-content: center;
    color: var(--accent-color); font-size: 1.5rem;
    margin-bottom: 0.5rem;
}
.cs-empty h3 { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
.cs-empty p { font-size: 0.9rem; max-width: 280px; }

/* ---- MOBİL UYUMLULUK (RESPONSIVE) ---- */
@media (max-width: 1100px) {
    .cs-sidebar-right { width: 270px; padding: 1rem; }
}
@media (max-width: 900px) {
    .cs-sidebar-right { display: none; }
}
@media (max-width: 680px) {
    .cs-sidebar-left { display: none; }
    .cs-feed-col { border-right: none; }
}
.cs-action-btn.liked { color: #ef4444; }
.cs-action-btn.liked i { color: #ef4444; }

/* ---- UYARI PENCERELERİ (ALERT) ---- */
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
.cs-alert.show { display: flex; }
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
.cs-alert-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.4rem; }
.cs-alert-desc { font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 1.5rem; }
.cs-alert-actions { display: flex; gap: 0.75rem; justify-content: center; }
.cs-alert-cancel {
    padding: 0.6rem 1.5rem; border-radius: 8px;
    border: 1px solid var(--border-color); background: transparent;
    color: var(--text-primary); font-size: 0.9rem; cursor: pointer;
    transition: background 0.2s;
}
.cs-alert-cancel:hover { background: var(--bg-surface-hover); }
.cs-alert-confirm {
    padding: 0.6rem 1.5rem; border-radius: 8px;
    border: none; background: #ef4444;
    color: #fff; font-size: 0.9rem; font-weight: 600; cursor: pointer;
    transition: background 0.2s;
}
.cs-alert-confirm:hover { background: #dc2626; }

/* ---- BİLDİRİM TOAST ---- */
.cs-toast {
    position: fixed;
    bottom: 1.5rem; right: 1.5rem;
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-left: 3px solid var(--accent-color);
    border-radius: 10px;
    padding: 0.85rem 1.25rem;
    display: flex; align-items: center; gap: 0.75rem;
    font-size: 0.9rem;
    box-shadow: var(--shadow-md);
    z-index: 9999;
    animation: toastIn 0.3s ease;
    max-width: 320px;
}
.cs-toast.danger { border-left-color: #ef4444; }
@keyframes toastIn {
    from { transform: translateX(100%); opacity: 0; }
    to   { transform: translateX(0); opacity: 1; }
}
</style>
<script>
function toggleComment(postId) {
    var box = document.getElementById('comment-box-' + postId);
    box.style.display = box.style.display === 'none' ? 'block' : 'none';
    if (box.style.display === 'block') box.querySelector('input').focus();
}
var _deleteTargetId = null;
function confirmDelete(postId) {
    _deleteTargetId = postId;
    document.getElementById('cs-delete-alert').classList.add('show');
}
function cancelDelete() {
    document.getElementById('cs-delete-alert').classList.remove('show');
    _deleteTargetId = null;
}
function doDelete() {
    if (_deleteTargetId) document.getElementById('delete-form-' + _deleteTargetId).submit();
}
// Auto-dismiss toast
window.addEventListener('DOMContentLoaded', function() {
    var toast = document.getElementById('cs-toast');
    if (toast) setTimeout(function() { toast.style.opacity = 0; toast.style.transition = 'opacity 0.5s'; setTimeout(function(){ toast.remove(); }, 500); }, 3500);
});
</script>

<div class="cs-forum-wrap">

    {{-- SOL YAN MENÜ --}}
    <aside class="cs-sidebar-left">
        <span class="cs-nav-section-label">Menü</span>
        <a href="{{ route('forum.index') }}" class="cs-nav-link active">
            <img src="{{ asset('images/logo.svg') }}" alt="CineScope Logo" style="width: 20px; height: 20px; object-fit: contain; flex-shrink: 0;"> Topluluk Akışı
        </a>
        <div class="cs-nav-divider"></div>
        <span class="cs-nav-section-label">Kişisel</span>
        @auth
        <a href="{{ route('profile.show', auth()->id()) }}" class="cs-nav-link">
            <i class="fas fa-user"></i> Profilim
        </a>
        <a href="{{ route('movies.favorites') }}" class="cs-nav-link">
            <i class="fas fa-heart"></i> Favorilerim
        </a>
        @endauth
        @auth
        <a href="{{ route('notifications.index') }}" class="cs-nav-link">
            <i class="fas fa-bell"></i> Bildirimler
        </a>
        @endauth

        @auth
        <div class="cs-nav-divider"></div>
        <div class="cs-sidebar-user">
            <div class="cs-sidebar-user-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('avatars/' . auth()->user()->avatar) }}" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="cs-sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="cs-sidebar-user-handle">&#64;{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</div>
            </div>
        </div>
        @endauth
    </aside>

    {{-- ORTA ALAN: GÖNDERİ AKIŞI --}}
    <main class="cs-feed-col" @guest style="border-right: none;" @endguest>
        <div class="cs-feed-header">
            <img src="{{ asset('images/logo.svg') }}" alt="CineScope Logo" style="width: 24px; height: 24px; object-fit: contain; flex-shrink: 0;">
            <h1>CineScope Topluluk</h1>
        </div>

        @auth
        <div class="cs-feed-tabs">
            <button class="cs-feed-tab active">Tümü</button>
            <button class="cs-feed-tab">Filmler</button>
            <button class="cs-feed-tab">Diziler</button>
            <button class="cs-feed-tab">İncelemeler</button>
        </div>
        @endauth

        @auth
        <div class="cs-compose-box">
            <div class="cs-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('avatars/' . auth()->user()->avatar) }}" alt="Avatar">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="cs-compose-inner">
                <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data" style="position:relative;">
                    @csrf
                    <textarea name="content" class="cs-compose-textarea" placeholder="Ne izledin? Düşüncelerini paylaş..." required maxlength="1000" rows="2" oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'"></textarea>
                    
                    {{-- Gizli Girdiler --}}
                    <input type="file" name="image" id="composer-image-input" accept="image/*" style="display:none;" onchange="previewImage(this)">
                    <input type="hidden" name="rating" id="composer-rating-value">
                    <input type="hidden" name="tagged_movie_id" id="composer-tag-id">
                    <input type="hidden" name="tagged_movie_title" id="composer-tag-title">
                    <input type="hidden" name="tagged_movie_type" id="composer-tag-type">

                    {{-- Önizleme Alanları --}}
                    <div id="composer-image-preview-container" style="display:none; position:relative; margin-top:0.75rem;">
                        <img id="composer-image-preview" src="" style="max-height: 200px; border-radius: 8px; border: 1px solid var(--border-color); object-fit: cover;">
                        <button type="button" onclick="clearSelectedImage()" style="position:absolute; top:8px; left:8px; background:rgba(0,0,0,0.6); color:#fff; border:none; border-radius:50%; width:28px; height:28px; cursor:pointer; display:flex; align-items:center; justify-content:center;"><i class="fas fa-times"></i></button>
                    </div>

                    <div id="composer-tag-container" style="display:none; align-items:center; gap:0.5rem; background:rgba(0,112,243,0.1); border:1px solid rgba(0,112,243,0.2); padding:0.4rem 0.8rem; border-radius:20px; font-size:0.82rem; color:var(--accent-color); width:fit-content; margin-top:0.75rem;">
                        <i class="fas fa-clapperboard"></i> <span id="composer-tag-label"></span>
                        <button type="button" onclick="clearSelectedTag()" style="background:none; border:none; color:var(--accent-color); cursor:pointer; padding:0; display:inline-flex; align-items:center; margin-left:0.25rem;"><i class="fas fa-times"></i></button>
                    </div>

                    <div id="composer-rating-container" style="display:none; align-items:center; gap:0.5rem; margin-top:0.75rem; font-size:0.88rem; color:var(--text-secondary);">
                        <span>Puanın:</span>
                        <div class="composer-stars" style="display:flex; gap:0.25rem; color:#f59e0b; font-size:1.1rem; cursor:pointer;">
                            <i class="far fa-star star-item" data-val="1" onclick="selectRating(1)"></i>
                            <i class="far fa-star star-item" data-val="2" onclick="selectRating(2)"></i>
                            <i class="far fa-star star-item" data-val="3" onclick="selectRating(3)"></i>
                            <i class="far fa-star star-item" data-val="4" onclick="selectRating(4)"></i>
                            <i class="far fa-star star-item" data-val="5" onclick="selectRating(5)"></i>
                        </div>
                        <button type="button" onclick="clearSelectedRating()" style="background:none; border:none; color:var(--text-muted); cursor:pointer; padding:0; display:inline-flex; align-items:center; margin-left:0.5rem;"><i class="fas fa-times"></i></button>
                    </div>

                    <div class="cs-compose-actions" style="position:relative;">
                        <div class="cs-compose-tools">
                            <button type="button" class="cs-tool-btn" title="Görsel Ekle" onclick="triggerImageInput()"><i class="far fa-image"></i></button>
                            <button type="button" class="cs-tool-btn" title="Film Etiketle" onclick="openTagModal()"><i class="fas fa-clapperboard"></i></button>
                            <button type="button" class="cs-tool-btn" title="Puan Ver" onclick="toggleRatingSelector()"><i class="fas fa-star"></i></button>
                            <button type="button" class="cs-tool-btn" title="Duygu Durumu" onclick="toggleEmojiPopover()"><i class="far fa-face-smile"></i></button>
                        </div>
                        
                        {{-- Emoji Seçim Penceresi --}}
                        <div id="composer-emoji-popover" style="display:none; position:absolute; bottom:50px; left:10px; background:var(--bg-surface); border:1px solid var(--border-color); padding:0.5rem; border-radius:10px; box-shadow:var(--shadow-md); z-index:20; display:none; grid-template-columns:repeat(5, 1fr); gap:0.35rem; font-size:1.2rem;">
                            <span onclick="insertEmoji('🍿')" style="cursor:pointer; padding:0.2rem;">🍿</span>
                            <span onclick="insertEmoji('🎬')" style="cursor:pointer; padding:0.2rem;">🎬</span>
                            <span onclick="insertEmoji('😍')" style="cursor:pointer; padding:0.2rem;">😍</span>
                            <span onclick="insertEmoji('😱')" style="cursor:pointer; padding:0.2rem;">😱</span>
                            <span onclick="insertEmoji('😂')" style="cursor:pointer; padding:0.2rem;">😂</span>
                            <span onclick="insertEmoji('😢')" style="cursor:pointer; padding:0.2rem;">😢</span>
                            <span onclick="insertEmoji('👍')" style="cursor:pointer; padding:0.2rem;">👍</span>
                            <span onclick="insertEmoji('👎')" style="cursor:pointer; padding:0.2rem;">👎</span>
                            <span onclick="insertEmoji('🔥')" style="cursor:pointer; padding:0.2rem;">🔥</span>
                            <span onclick="insertEmoji('😴')" style="cursor:pointer; padding:0.2rem;">😴</span>
                        </div>

                        <button type="submit" class="cs-post-btn"><i class="fas fa-paper-plane"></i> Paylaş</button>
                    </div>
                </form>
            </div>
        </div>
        @endauth

        @auth
        {{-- GÖNDERİLER --}}
        @forelse($posts as $post)
        <div class="cs-post">
            <div class="cs-avatar">
                @if($post->user->avatar)
                    <img src="{{ asset('avatars/' . $post->user->avatar) }}" alt="Avatar">
                @else
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                @endif
            </div>
            <div style="flex: 1; min-width: 0;">
                <div class="cs-post-meta">
                    <a href="{{ route('profile.show', $post->user->id) }}">{{ $post->user->name }}</a>
                    @if($post->user->role === 'admin')
                        <span style="background: rgba(0,112,243,0.1); color: var(--accent-color); font-size: 0.72rem; padding: 0.1rem 0.5rem; border-radius: 4px; font-weight: 600;">
                            <i class="fas fa-shield-halved"></i> Mod
                        </span>
                    @endif
                    <span class="cs-post-handle">&#64;{{ strtolower(str_replace(' ', '', $post->user->name)) }}</span>
                    <span class="cs-post-handle">· {{ $post->created_at->diffForHumans(null, true, true) }}</span>
                    @if($post->rating)
                    <span style="color:#f59e0b; font-size:0.75rem; display:flex; gap:0.1rem; align-items:center; margin-left:0.5rem;" title="{{ $post->rating }}/5 Yıldız">
                        @for($i=1; $i<=5; $i++)
                            <i class="{{ $i <= $post->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </span>
                    @endif
                </div>
                <div class="cs-post-body">{{ $post->content }}</div>

                {{-- Tagged Movie Badge --}}
                @if($post->tagged_movie_title)
                <div style="margin-top:0.6rem; display:flex;">
                    <a href="{{ $post->tagged_movie_type === 'tv' ? route('tv.show', $post->tagged_movie_id) : route('movies.show', $post->tagged_movie_id) }}" 
                       style="background:rgba(0,112,243,0.06); border:1px solid rgba(0,112,243,0.15); border-radius:20px; padding:0.3rem 0.75rem; font-size:0.78rem; font-weight:600; color:var(--accent-color); display:inline-flex; align-items:center; gap:0.4rem; transition:var(--transition-smooth);"
                       onmouseover="this.style.background='rgba(0,112,243,0.12)'"
                       onmouseout="this.style.background='rgba(0,112,243,0.06)'">
                        <i class="fas fa-clapperboard"></i> {{ $post->tagged_movie_title }}
                    </a>
                </div>
                @endif

                {{-- Post Image --}}
                @if($post->image_path)
                <div style="margin-top:0.75rem; border-radius:12px; overflow:hidden; border:1px solid var(--border-color); max-height: 380px; display:flex; background:rgba(0,0,0,0.2);">
                    <img src="{{ asset('posts/' . $post->image_path) }}" alt="Post image" style="width:100%; height:100%; object-fit:cover; cursor:pointer;" onclick="window.open(this.src)">
                </div>
                @endif
                <div class="cs-post-actions">
                    {{-- YORUM --}}
                    @auth
                    <button class="cs-action-btn" onclick="toggleComment({{ $post->id }})">
                        <i class="far fa-comment"></i> {{ $post->comments_count }}
                    </button>
                    {{-- BEĞENİ --}}
                    <form action="{{ route('forum.like', $post) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="cs-action-btn like {{ $post->isLikedBy(auth()->user()) ? 'liked' : '' }}">
                            <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart"></i> {{ $post->likes_count }}
                        </button>
                    </form>
                    {{-- SİL (sadece kendi gönderisi) --}}
                    @if(auth()->id() == $post->user_id)
                    <button class="cs-action-btn delete" style="margin-left:auto; color: var(--text-muted);" onclick="confirmDelete({{ $post->id }})" title="Sil">
                        <i class="fas fa-trash"></i>
                    </button>
                    <form id="delete-form-{{ $post->id }}" action="{{ route('forum.destroy', $post) }}" method="POST" style="display:none;">
                        @csrf @method('DELETE')
                    </form>
                    @endif
                    @else
                    <span class="cs-action-btn"><i class="far fa-comment"></i> {{ $post->comments_count }}</span>
                    <span class="cs-action-btn like"><i class="far fa-heart"></i> {{ $post->likes_count }}</span>
                    @endauth
                </div>
                {{-- YORUM FORMU (gizli, toggle ile açılır) --}}
                @auth
                <div id="comment-box-{{ $post->id }}" style="display:none; margin-top: 0.75rem;">
                    <form action="{{ route('forum.comment', $post) }}" method="POST" style="display:flex; gap: 0.5rem;">
                        @csrf
                        <input type="text" name="content" placeholder="Yorumunu yaz..." maxlength="500" required
                            style="flex:1; background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: 8px; padding: 0.5rem 0.75rem; color: var(--text-primary); font-size: 0.88rem; outline:none;">
                        <button type="submit" class="cs-post-btn" style="padding: 0.5rem 1rem; font-size: 0.88rem;">Gönder</button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
        @empty
        <div class="cs-empty">
            <div class="cs-empty-icon"><i class="fas fa-film"></i></div>
            <h3>Henüz gönderi yok</h3>
            <p>Sinema dünyasını konuşturan ilk kişi sen ol.</p>
        </div>
        @endforelse
        @else
        <div style="padding: 5rem 1.5rem; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: calc(100vh - 250px);">
            <div class="cs-empty-icon" style="margin: 0 auto 1.5rem; width: 80px; height: 80px; font-size: 2.5rem; background: rgba(0, 112, 243, 0.1); color: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-film"></i></div>
            <h2 style="margin-bottom: 0.75rem; font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">CineScope Topluluğuna Katıl</h2>
            <p style="color: var(--text-secondary); font-size: 1.05rem; margin-bottom: 2rem; max-width: 420px; line-height: 1.6;">Film yorumlarını paylaş, diğer sinema severlerle tartış.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; align-items: center;">
                <a href="{{ route('login') }}" class="cs-post-btn" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; padding: 0.75rem 2rem; font-size: 1rem; border-radius: 8px;"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a>
                <a href="{{ route('register') }}" class="cs-follow-btn" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; padding: 0.75rem 2rem; font-size: 1rem; border-radius: 8px;">Kayıt Ol</a>
            </div>
        </div>
        @endauth
    </main>

    {{-- RIGHT SIDEBAR --}}
    @auth
    <aside class="cs-sidebar-right">
        <div class="cs-search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Film veya konu ara...">
        </div>

        <div class="cs-widget">
            <div class="cs-widget-title"><i class="fas fa-fire"></i> Gündemdekiler</div>
            @forelse($trendingTags as $item)
            <div class="cs-trend-item">
                <span class="cs-trend-tag">#{{ $item['tag'] }}</span>
                <div class="cs-trend-title">#{{ $item['tag'] }}</div>
                <div class="cs-trend-count">{{ $item['count'] }} {{ $item['count'] === 1 ? 'gönderi' : 'gönderi' }}</div>
            </div>
            @empty
            <div style="padding: 1.25rem; color: var(--text-muted); font-size: 0.88rem; text-align: center;">
                <i class="fas fa-hashtag" style="margin-bottom: 0.5rem; display: block; font-size: 1.25rem; color: var(--accent-color);"></i>
                Henüz etiket yok.<br>Gönderinde <strong>#etiket</strong> kullan!
            </div>
            @endforelse
        </div>

        <div class="cs-widget">
            <div class="cs-widget-title"><i class="fas fa-users"></i> Topluluktan</div>
            @forelse($suggestedUsers as $suggestedUser)
            @php
                $gradients = [
                    'linear-gradient(135deg, #0070f3, #7c3aed)',
                    'linear-gradient(135deg, #ef4444, #b91c1c)',
                    'linear-gradient(135deg, #10b981, #059669)',
                    'linear-gradient(135deg, #f59e0b, #d97706)',
                ];
                $gradient = $gradients[$loop->index % count($gradients)];
            @endphp
            <div class="cs-user-suggest">
                <div class="cs-user-info">
                    <div class="cs-suggest-avatar" style="background: {{ $gradient }};">
                        @if($suggestedUser->avatar)
                            <img src="{{ asset('avatars/' . $suggestedUser->avatar) }}" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ strtoupper(substr($suggestedUser->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="cs-suggest-name">{{ $suggestedUser->name }}</div>
                        <div class="cs-suggest-handle">&#64;{{ strtolower(str_replace(' ', '', $suggestedUser->name)) }} · {{ $suggestedUser->posts_count }} gönderi</div>
                    </div>
                </div>
                <a href="{{ route('profile.show', $suggestedUser->id) }}" class="cs-follow-btn">Profil</a>
            </div>
            @empty
            <div style="padding: 1.25rem; color: var(--text-muted); font-size: 0.88rem; text-align: center;">
                Henüz başka üye yok.
            </div>
            @endforelse
        </div>

        <div class="cs-widget" style="padding: 1rem 1.25rem;">
            <div style="font-size: 0.72rem; color: var(--text-muted); line-height: 1.8;">
                <a href="{{ route('pages.terms') }}" style="color: inherit; text-decoration:none; margin-right: 0.75rem;">Kullanım Koşulları</a>
                <a href="{{ route('pages.privacy') }}" style="color: inherit; text-decoration:none; margin-right: 0.75rem;">Gizlilik</a>
                <a href="{{ route('pages.contact') }}" style="color: inherit; text-decoration:none;">İletişim</a>
                <br>© {{ date('Y') }} CineScope
            </div>
        </div>
    </aside>
    @endauth

</div>

{{-- GÖNDERİ SİLME ONAY MODALİ --}}
<div id="cs-delete-alert" class="cs-alert" onclick="if(event.target===this) cancelDelete()">
    <div class="cs-alert-box">
        <div class="cs-alert-icon"><i class="fas fa-trash-alt"></i></div>
        <div class="cs-alert-title">Gönderiyi sil</div>
        <div class="cs-alert-desc">Bu gönderi kalıcı olarak silinecek. Bu işlem geri alınamaz.</div>
        <div class="cs-alert-actions">
            <button class="cs-alert-cancel" onclick="cancelDelete()">İptal</button>
            <button class="cs-alert-confirm" onclick="doDelete()"><i class="fas fa-trash-alt"></i> Sil</button>
        </div>
    </div>
</div>

{{-- SESSION TOAST --}}
@if(session('success'))
<div id="cs-toast" class="cs-toast">
    <i class="fas fa-check-circle" style="color: var(--accent-color); font-size: 1.1rem;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

{{-- FİLM VE DİZİ ETİKETLEME MODALİ --}}
<div id="cs-tag-modal" class="cs-alert" onclick="if(event.target===this) closeTagModal()">
    <div class="cs-alert-box" style="max-width: 450px; width: 90%;">
        <div class="cs-alert-icon" style="background: rgba(0,112,243,0.1); color: var(--accent-color);"><i class="fas fa-clapperboard"></i></div>
        <div class="cs-alert-title">Film veya Dizi Etiketle</div>
        <div style="padding: 1rem 0;">
            <input type="text" id="tag-search-input" placeholder="Film veya dizi adı yazın..." oninput="searchTagMedia(this.value)"
                   style="width: 100%; background: var(--bg-base); border: 1px solid var(--border-color); border-radius: 8px; padding: 0.75rem 1rem; color: var(--text-primary); outline: none;">
            <div id="tag-search-results" style="margin-top: 1rem; max-height: 250px; overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem;">
                <div style="color:var(--text-muted); text-align:center; padding:1rem; font-size:0.88rem;">Aramak için yazın...</div>
            </div>
        </div>
        <div class="cs-alert-actions" style="margin-top: 0;">
            <button class="cs-alert-cancel" onclick="closeTagModal()" style="width: 100%;">Vazgeç</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // EMOJI PICKER
    function toggleEmojiPopover() {
        const popover = document.getElementById('composer-emoji-popover');
        if (popover.style.display === 'none' || popover.style.display === '') {
            popover.style.display = 'grid';
        } else {
            popover.style.display = 'none';
        }
    }
    function insertEmoji(emoji) {
        const textarea = document.querySelector('.cs-compose-textarea');
        textarea.value += emoji;
        document.getElementById('composer-emoji-popover').style.display = 'none';
        textarea.focus();
    }

    // IMAGE UPLOAD PREVIEW
    function triggerImageInput() {
        document.getElementById('composer-image-input').click();
    }
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('composer-image-preview').src = e.target.result;
                document.getElementById('composer-image-preview-container').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
    function clearSelectedImage() {
        document.getElementById('composer-image-input').value = '';
        document.getElementById('composer-image-preview-container').style.display = 'none';
        document.getElementById('composer-image-preview').src = '';
    }

    // RATING SYSTEM
    function toggleRatingSelector() {
        const container = document.getElementById('composer-rating-container');
        if (container.style.display === 'none' || container.style.display === '') {
            container.style.display = 'flex';
            selectRating(5); // default to 5 stars
        } else {
            clearSelectedRating();
        }
    }
    function selectRating(val) {
        document.getElementById('composer-rating-value').value = val;
        const stars = document.querySelectorAll('.star-item');
        stars.forEach(star => {
            const starVal = parseInt(star.dataset.val);
            if (starVal <= val) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }
    function clearSelectedRating() {
        document.getElementById('composer-rating-value').value = '';
        document.getElementById('composer-rating-container').style.display = 'none';
        const stars = document.querySelectorAll('.star-item');
        stars.forEach(star => {
            star.classList.remove('fas');
            star.classList.add('far');
        });
    }

    // MOVIE/TV TAG SYSTEM
    function openTagModal() {
        document.getElementById('cs-tag-modal').classList.add('show');
        document.getElementById('tag-search-input').value = '';
        document.getElementById('tag-search-results').innerHTML = '<div style="color:var(--text-muted); text-align:center; padding:1rem; font-size:0.88rem;">Aramak için yazın...</div>';
        document.getElementById('tag-search-input').focus();
    }
    function closeTagModal() {
        document.getElementById('cs-tag-modal').classList.remove('show');
    }

    let searchTimeout = null;
    function searchTagMedia(query) {
        clearTimeout(searchTimeout);
        if (!query || query.trim().length < 2) {
            document.getElementById('tag-search-results').innerHTML = '<div style="color:var(--text-muted); text-align:center; padding:1rem; font-size:0.88rem;">En az 2 harf yazın...</div>';
            return;
        }
        
        document.getElementById('tag-search-results').innerHTML = '<div style="color:var(--text-muted); text-align:center; padding:1rem; font-size:0.88rem;"><i class="fas fa-spinner fa-spin"></i> Aranıyor...</div>';
        
        searchTimeout = setTimeout(() => {
            fetch('{{ route("movies.ajaxSearch") }}?query=' + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.length === 0) {
                        html = '<div style="color:var(--text-muted); text-align:center; padding:1rem; font-size:0.88rem;">Sonuç bulunamadı.</div>';
                    } else {
                        data.forEach(item => {
                            const posterHtml = item.poster 
                                ? `<img src="${item.poster}" style="width:34px; height:50px; object-fit:cover; border-radius:4px;">`
                                : `<div style="width:34px; height:50px; background:#2d3748; border-radius:4px; display:flex; align-items:center; justify-content:center; color:var(--text-muted);"><i class="fas fa-film" style="font-size:0.8rem;"></i></div>`;
                            
                            const escapedTitle = item.title.replace(/'/g, "\\'");
                            const type = item.type === 'Dizi' ? 'tv' : 'movie';
                            
                            html += `
                                <div onclick="selectTagMedia(${item.id}, '${escapedTitle}', '${type}')" 
                                     style="display:flex; align-items:center; gap:0.75rem; padding:0.6rem; border-radius:8px; cursor:pointer; background:var(--bg-surface); border:1px solid var(--border-color); transition:background 0.2s;"
                                     onmouseover="this.style.background='var(--bg-surface-hover)'"
                                     onmouseout="this.style.background='var(--bg-surface)'">
                                    ${posterHtml}
                                    <div style="flex:1; min-width:0; text-align:left;">
                                        <div style="font-weight:600; font-size:0.88rem; color:var(--text-primary); text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">${item.title}</div>
                                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:0.15rem;">${item.type} • ${item.date || 'Belirtilmemiş'}</div>
                                    </div>
                                </div>
                            `;
                        });
                    }
                    document.getElementById('tag-search-results').innerHTML = html;
                });
        }, 400);
    }

    function selectTagMedia(id, title, type) {
        document.getElementById('composer-tag-id').value = id;
        document.getElementById('composer-tag-title').value = title;
        document.getElementById('composer-tag-type').value = type;
        
        document.getElementById('composer-tag-label').innerText = (type === 'tv' ? 'Dizi: ' : 'Film: ') + title;
        document.getElementById('composer-tag-container').style.display = 'flex';
        closeTagModal();
    }

    function clearSelectedTag() {
        document.getElementById('composer-tag-id').value = '';
        document.getElementById('composer-tag-title').value = '';
        document.getElementById('composer-tag-type').value = '';
        document.getElementById('composer-tag-container').style.display = 'none';
    }
</script>
@endpush

@endsection
