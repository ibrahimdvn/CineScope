<!DOCTYPE html>
<html lang="tr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CineScope Admin Paneli</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Admin paneli için özel eklemeler (gerekirse) */
        .admin-header {
            background-color: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .admin-brand i {
            color: var(--danger-color);
        }
    </style>
</head>
<body>
    @if(session('admin_logged_in'))
        <header class="admin-header">
            <div class="admin-brand">
                <i class="fas fa-user-shield"></i> CineScope Admin
            </div>
            <div>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 0.4rem 1rem;"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</button>
                </form>
            </div>
        </header>
    @endif

    <main style="padding-top: 2rem;">
        @yield('content')
    </main>

</body>
</html>
