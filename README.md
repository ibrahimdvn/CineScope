# CineScope 🎬

CineScope, Laravel ile geliştirilmiş modern, tam özellikli bir film keşif, takip ve sosyal etkileşim (forum) platformudur. Premium SaaS tarzı koyu tema arayüzü sunar ve en popüler/güncel yapımları çekmek için **TMDB (The Movie Database) API** ile entegre çalışır.

## ✨ Özellikler

- **Canlı Film ve Dizi Verileri:** Popüler, vizyondakiler ve güncel dizi listelerini doğrudan TMDB'den asenkron çeker.
- **SaaS Kalitesinde Tasarım (UI/UX):** Saf CSS ile yazılmış, responsive (mobil uyumlu), cam morfolojisi (glassmorphism) esintili şık ve özgün karanlık tema arayüzü.
- **Sosyal Forum & Akış:** Kullanıcıların gönderi paylaşabildiği, gönderileri beğenebildiği ve yorum yapabildiği gelişmiş sosyal akış paneli.
  - **Zengin Paylaşım Kutusu:** Gönderilere görsel yükleme önizlemesi, 5 yıldızlı puan verme sistemi, asenkron film/dizi etiketleme desteği ve hızlı emoji seçici.
- **Favori Sistemi:** Kayıtlı kullanıcıların sevdikleri film ve dizileri profillerinde listelemek üzere favorilerine ekleyebilmesi.
- **İzole Yönetim (Admin) Paneli:** Kullanıcıları, sistem ayarlarını ve içerikleri yönetmek için tamamen bağımsız ve güvenli bir panel (`/admin`).
- **Gelişmiş Arama:** TMDB arama API'sini kullanan çok yönlü akıllı arama motoru.
- **Şifremi Unuttum Altyapısı:** Şifresini unutan kullanıcılar için tasarıma uygun şifre sıfırlama, onaylama ve yeni şifre belirleme akışı.
- **Bildirim Sistemi:** Kullanıcıların gönderilerine gelen beğeni ve yorumları anlık olarak takip edebileceği entegre bildirim sayfası.

## 🛠 Kullanılan Teknolojiler

- **Arka Uç (Backend):** Laravel 10 (PHP)
- **Ön Uç (Frontend):** Blade Şablon Motoru, Vanilla CSS (Flexbox/Grid), FontAwesome 6, JavaScript (Vanilla ES6)
- **Veritabanı:** MySQL / SQLite
- **API Bağlantısı:** [TMDB API](https://developer.themoviedb.org/docs)

## 🚀 Kurulum ve Çalıştırma

Lokal bilgisayarınızda projeyi ayağa kaldırmak için aşağıdaki adımları takip edebilirsiniz.

### 1. Gereksinimler
- PHP >= 8.1
- Composer
- TMDB API Key ([TMDB](https://www.themoviedb.org/settings/api) adresinden ücretsiz alabilirsiniz)

### 2. Depoyu Klonlayın
```bash
git clone https://github.com/ibrahimdvn/cinescope.git
cd cinescope
```

### 3. Bağımlılıkları Yükleyin
```bash
composer install
```

### 4. Çevre (.env) Yapılandırması
Örnek dosyayı kopyalayarak `.env` dosyanızı oluşturun:
```bash
cp .env.example .env
```
`.env` dosyasını açıp veritabanı ayarlarınızı girin. Ardından dosyanın en altına TMDB API anahtarınızı ekleyin:
```env
TMDB_API_KEY=api_anahtariniz_buraya
```

Ayrıca şifre sıfırlama maillerini test etmek için e-posta ayarlarını `log` veya SMTP servisinizle güncelleyebilirsiniz:
```env
MAIL_MAILER=log
```

### 5. Uygulama Anahtarını Üretin ve Veritabanını Göç Ettirin
```bash
php artisan key:generate
php artisan migrate
```

### 6. Geliştirme Sunucusunu Başlatın
```bash
php artisan serve
```
Uygulamanız hazır! `http://127.0.0.1:8000` adresinden tarayıcıda açabilirsiniz.

## 🛡 Yönetim Paneli Giriş Bilgileri

Yönetici paneline erişmek için:
**URL:** `http://127.0.0.1:8000/admin`

**Varsayılan Giriş Bilgileri:**
- **Kullanıcı Adı:** `admin`
- **Şifre:** `123456`

## 👨‍💻 Geliştirici

**İbrahim Can Düven**
- [LinkedIn](https://www.linkedin.com/in/ibrahim-can-d%C3%BCven-8a7480251/)
- [GitHub](https://github.com/ibrahimdvn)

---

*CineScope uses the TMDB API but is not endorsed or certified by TMDB.*
