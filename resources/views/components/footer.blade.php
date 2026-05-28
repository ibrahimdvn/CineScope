<footer class="corporate-footer">
    <div class="container footer-content">
        <div class="footer-brand">
            <h3>CineScope</h3>
            <p>Modern sinema dünyasını keşfedin. En güncel filmler, detaylı incelemeler ve kişisel favori listeniz tek bir platformda.</p>
        </div>
        
        <div class="footer-links">
            <h4>Hızlı Bağlantılar</h4>
            <ul>
                <li><a href="{{ route('movies.index') }}">Ana Sayfa</a></li>
                <li><a href="{{ route('movies.index') }}">Popüler Filmler</a></li>
                <li><a href="{{ route('movies.now_playing') }}">Vizyondakiler</a></li>
                <li><a href="{{ route('forum.index') }}">Topluluk (Forum)</a></li>
                <li><a href="{{ route('pages.about') }}">Hakkımızda</a></li>
            </ul>
        </div>
        
        <div class="footer-links">
            <h4>Yasal</h4>
            <ul>
                <li><a href="{{ route('pages.terms') }}">Kullanım Koşulları</a></li>
                <li><a href="{{ route('pages.privacy') }}">Gizlilik Politikası</a></li>
                <li><a href="{{ route('pages.cookies') }}">Çerez Politikası</a></li>
                <li><a href="{{ route('pages.contact') }}">İletişim</a></li>
            </ul>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p>&copy; {{ date('Y') }} CineScope. Tüm hakları saklıdır.</p>
            <div class="social-icons">
                <a href="https://instagram.com/ibrahimdven" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/in/ibrahim-can-d%C3%BCven-8a7480251/" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                <a href="https://github.com/ibrahimdvn" target="_blank" title="GitHub"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </div>
</footer>
