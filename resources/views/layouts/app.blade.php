<!DOCTYPE html>
<html lang="tr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CineScope | Modern Film Keşif Platformu</title>
    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('theme-toggle');
            if(toggle) {
                toggle.addEventListener('click', function() {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    this.innerHTML = newTheme === 'light' ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
                });
            }
        });

        function toggleCardFavorite(btn) {
            const icon = btn.querySelector('i');
            btn.disabled = true;

            fetch('{{ route("movies.toggleFavorite") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tmdb_id: btn.dataset.id,
                    media_type: btn.dataset.type,
                    title: btn.dataset.title,
                    poster_path: btn.dataset.poster,
                    release_date: btn.dataset.date,
                    vote_average: btn.dataset.vote
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'added') {
                    btn.style.color = '#ef4444';
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    btn.style.color = '#fff';
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            })
            .finally(() => {
                btn.disabled = false;
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
