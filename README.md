# CineScope 🎬

CineScope is a modern, full-featured movie discovery and tracking platform built with Laravel. It offers a premium SaaS-style dark-mode UI, seamlessly integrating with the **TMDB (The Movie Database) API** to deliver real-time data on popular and upcoming films.

## ✨ Features

- **Real-Time Movie Data:** Fetches dynamically updated lists of popular and now-playing movies directly from TMDB.
- **SaaS-Grade UI/UX:** A sleek, fully responsive, glassmorphism-inspired dark mode interface engineered with pure CSS.
- **User Authentication:** Complete registration and login system with automatic routing logic.
- **Favorites System:** Authenticated users can save and manage their favorite movies in their personal library.
- **Isolated Admin Panel:** A secure, completely detached administration dashboard (`/admin`) for managing users, movies, and system settings.
- **Dynamic Search:** Integrated movie search mechanism connecting to the TMDB search endpoints.

## 🛠 Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade Templating, Vanilla CSS (Flexbox/Grid architecture), FontAwesome 6
- **Database:** MySQL / SQLite
- **API:** [TMDB API](https://developer.themoviedb.org/docs)

## 🚀 Installation & Setup

Follow these instructions to get a local copy up and running.

### 1. Prerequisites
- PHP >= 8.1
- Composer
- A TMDB API Key (Get one for free at [TMDB](https://www.themoviedb.org/settings/api))

### 2. Clone the Repository
```bash
git clone https://github.com/ibrahimdvn/cinescope.git
cd cinescope
```

### 3. Install Dependencies
```bash
composer install
```

### 4. Environment Setup
Copy the example environment file and configure it:
```bash
cp .env.example .env
```
Open the `.env` file and add your database credentials. Most importantly, add your TMDB API key at the bottom of the file:
```env
TMDB_API_KEY=your_api_key_here
```

### 5. Generate Application Key & Migrate Database
Generate the Laravel security key and run the database migrations (this will set up the users and favorites tables):
```bash
php artisan key:generate
php artisan migrate
```

### 6. Run the Development Server
```bash
php artisan serve
```
Your application will be live at `http://127.0.0.1:8000`.

## 🛡 Admin Panel Access

The application includes a completely separate and secure admin panel. You can access it by navigating to:
**URL:** `http://127.0.0.1:8000/admin`

**Default Credentials:**
- **Username:** `admin`
- **Password:** `123456`

## 👨‍💻 Author

**İbrahim Can Düven**
- [LinkedIn](https://www.linkedin.com/in/ibrahim-can-d%C3%BCven-8a7480251/)
- [GitHub](https://github.com/ibrahimdvn)

---

*CineScope uses the TMDB API but is not endorsed or certified by TMDB.*
