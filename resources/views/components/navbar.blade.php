<header class="navbar">
    <div class="container">
        <a href="{{ route('movies.index') }}" class="brand">
            <i class="fas fa-film"></i>
            <div>Cine<span>Scope</span></div>
        </a>
        
        <form action="{{ route('movies.search') }}" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Film ara..." class="search-input" value="{{ request('query') }}" required>
            <button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i></button>
        </form>

        <nav class="nav-links">
            <button id="theme-toggle" class="btn btn-outline" style="border:none; padding: 0.5rem;"><i class="fas fa-sun"></i></button>
            
            @guest
                <a href="{{ route('login') }}" class="nav-link">Giriş Yap</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Kayıt Ol</a>
            @else
                <a href="{{ route('movies.favorites') }}" class="nav-link">Favorilerim</a>
                <a href="{{ route('logout') }}" class="btn btn-outline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Çıkış Yap
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
                    @csrf
                </form>
            @endguest
        </nav>
    </div>
</header>
