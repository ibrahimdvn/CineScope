<header class="navbar">
    <div class="container">
        <div class="nav-brand-container">
            <a href="{{ route('movies.index') }}" class="brand">
                <img src="{{ asset('images/logo.svg') }}" alt="CineScope Logo" style="width: 42px; height: 42px; object-fit: contain; background: transparent;">
                <div style="line-height: 1; display: flex; align-items: center;">Cine<span>Scope</span></div>
            </a>
            
            @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('password.*') && !request()->routeIs('admin.login'))
            <nav class="nav-menu">
                <a href="{{ route('movies.index') }}" class="nav-link {{ request()->routeIs('movies.*') && !request()->routeIs('movies.search') ? 'active' : '' }}">Filmler</a>
                <a href="{{ route('tv.index') }}" class="nav-link {{ request()->routeIs('tv.*') ? 'active' : '' }}">Diziler</a>
            </nav>
            @endif
        </div>
        
        @if(!request()->routeIs('forum.*') && !request()->routeIs('notifications.*') && !request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('password.*') && !request()->routeIs('admin.login') && !request()->routeIs('pages.*'))
        <form action="{{ route('movies.search') }}" method="GET" class="search-form" style="position: relative;" id="smart-search-form">
            <input type="text" name="query" id="smart-search-input" placeholder="Film, dizi veya üye ara..." class="search-input" value="{{ request('query') }}" autocomplete="off" required>
            <button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i></button>
            
            <div id="smart-search-results" style="display: none; position: absolute; top: 100%; left: 0; width: 100%; background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-sm); margin-top: 0.5rem; box-shadow: var(--shadow-lg); z-index: 1000; overflow: hidden; flex-direction: column;">
            </div>
        </form>
        @endif

        <nav class="nav-links">
            <button id="theme-toggle" class="btn btn-outline" style="border:none; padding: 0.5rem;"><i class="fas fa-sun"></i></button>
            
            @guest
                <a href="{{ route('login') }}" class="nav-link">Giriş Yap</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Kayıt Ol</a>
            @else
                <a href="{{ route('pages.support') }}" class="btn btn-outline" style="border-color: #f59e0b; color: #f59e0b; display: flex; align-items: center; gap: 0.5rem; border-radius: var(--radius-full);" title="Destek Ol">
                    <i class="fas fa-coffee"></i> <span>Destek Ol</span>
                </a>
                
                <a href="{{ route('profile.show', Auth::id()) }}" class="nav-link" style="display: flex; align-items: center; gap: 0.5rem;" title="Profilim">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" alt="Profil" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                    @else
                        <i class="fas fa-user-circle"></i>
                    @endif
                    <span>Profilim</span>
                </a>
                <a href="{{ route('logout') }}" class="btn btn-outline" title="Çıkış Yap" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Çıkış Yap</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
                    @csrf
                </form>
            @endguest
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('smart-search-input');
    const searchResults = document.getElementById('smart-search-results');
    let timeoutId;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(timeoutId);
            
            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }

            timeoutId = setTimeout(() => {
                fetch(`{{ route('movies.ajaxSearch') }}?query=${encodeURIComponent(query)}&_t=${Date.now()}`)
                    .then(res => res.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        
                        if (data.length === 0) {
                            searchResults.innerHTML = '<div style="padding: 1rem; color: var(--text-muted); text-align: center; font-size: 0.9rem;">Sonuç bulunamadı.</div>';
                        } else {
                            data.forEach(item => {
                                const link = document.createElement('a');
                                link.href = item.url;
                                link.style.cssText = 'display: flex; align-items: center; gap: 1rem; padding: 0.75rem 1rem; text-decoration: none; border-bottom: 1px solid var(--border-color); color: var(--text-primary); transition: background-color 0.2s;';
                                link.onmouseover = () => link.style.backgroundColor = 'var(--bg-surface-hover)';
                                link.onmouseout = () => link.style.backgroundColor = 'transparent';
                                
                                const isUser = item.type === 'Üye';
                                const imgStyle = isUser 
                                    ? 'width: 40px; height: 40px; border-radius: 50%; object-fit: cover;' 
                                    : 'width: 40px; height: 60px; object-fit: cover; border-radius: 4px;';
                                const placeholderStyle = isUser 
                                    ? 'width: 40px; height: 40px; border-radius: 50%; background: var(--bg-base); display: flex; align-items: center; justify-content: center;' 
                                    : 'width: 40px; height: 60px; background: var(--bg-base); border-radius: 4px; display: flex; align-items: center; justify-content: center;';
                                const placeholderIcon = isUser ? 'fa-user' : 'fa-image';
                                
                                const posterHtml = item.poster 
                                    ? `<img src="${item.poster}" alt="" style="${imgStyle}">` 
                                    : `<div style="${placeholderStyle}"><i class="fas ${placeholderIcon}" style="color: var(--text-muted);"></i></div>`;
                                
                                link.innerHTML = `
                                    ${posterHtml}
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.9rem;">${item.title}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center;">
                                            <span>${item.date}</span>
                                            <span style="background: rgba(255,255,255,0.1); padding: 0.1rem 0.4rem; border-radius: 3px; font-size: 0.7rem;">${item.type}</span>
                                        </div>
                                    </div>
                                `;
                                searchResults.appendChild(link);
                            });
                            
                            const allResultsBtn = document.createElement('a');
                            allResultsBtn.href = `{{ route('movies.search') }}?query=${encodeURIComponent(query)}`;
                            allResultsBtn.style.cssText = 'display: block; padding: 0.75rem; text-align: center; color: var(--accent-color); font-weight: 500; font-size: 0.85rem; text-decoration: none;';
                            allResultsBtn.innerHTML = 'Tüm Sonuçları Gör <i class="fas fa-arrow-right" style="margin-left: 0.25rem;"></i>';
                            allResultsBtn.onmouseover = () => allResultsBtn.style.backgroundColor = 'var(--bg-surface-hover)';
                            allResultsBtn.onmouseout = () => allResultsBtn.style.backgroundColor = 'transparent';
                            searchResults.appendChild(allResultsBtn);
                        }
                        
                        searchResults.style.display = 'flex';
                    })
                    .catch(err => console.error('Search error:', err));
            }, 300);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (document.getElementById('smart-search-form') && !document.getElementById('smart-search-form').contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
        
        // Show dropdown again when input is focused if there's a query
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2 && searchResults.innerHTML !== '') {
                searchResults.style.display = 'flex';
            }
        });
    }
});
</script>
