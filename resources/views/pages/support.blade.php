@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <div class="support-header">
        <div class="support-icon-wrapper">
            <i class="fas fa-heart fa-2x"></i>
        </div>
        <h1 class="section-title support-title">Bize <span class="highlight">Destek Olun</span></h1>
        <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem;">
            CineScope tamamen ücretsiz, reklamsız ve bağımsız bir platform olarak yayın hayatına devam ediyor. Sunucu masraflarımızı karşılamak ve platformu daha da geliştirebilmemiz için bize destek olabilirsiniz.
        </p>
    </div>

    <div class="support-grid">
        
        <!-- Tier 1 -->
        <div class="support-card">
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #3b82f6;"></div>
            <i class="fas fa-coffee fa-3x" style="color: #3b82f6; margin-bottom: 1.5rem;"></i>
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--text-primary);">Kahve Ismarla</h3>
            <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem;">Kod yazarken uyanık kalmamız için ufak bir destek.</p>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 2rem;">₺150 <span style="font-size: 1rem; color: var(--text-muted); font-weight: 400;">/tek seferlik</span></div>
            <a href="#" class="btn btn-outline" style="width: 100%; display: block; box-sizing: border-box; border-color: #3b82f6; color: #3b82f6;">Destek Ol</a>
        </div>

        <!-- Tier 2 -->
        <div class="support-card popular">
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--accent-color);"></div>
            <div style="position: absolute; top: 1rem; right: -2rem; background: var(--accent-color); color: white; padding: 0.25rem 3rem; transform: rotate(45deg); font-size: 0.75rem; font-weight: 700; letter-spacing: 1px;">POPÜLER</div>
            <i class="fas fa-ticket-alt fa-3x" style="color: var(--accent-color); margin-bottom: 1.5rem;"></i>
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--text-primary);">Sinema Bileti</h3>
            <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem;">Sunucu masraflarımızın büyük bir kısmını karşılar.</p>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 2rem;">₺300 <span style="font-size: 1rem; color: var(--text-muted); font-weight: 400;">/tek seferlik</span></div>
            <a href="#" class="btn btn-primary" style="width: 100%; display: block; box-sizing: border-box; box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);">Destek Ol</a>
        </div>

        <!-- Tier 3 -->
        <div class="support-card">
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #f59e0b;"></div>
            <i class="fas fa-crown fa-3x" style="color: #f59e0b; margin-bottom: 1.5rem;"></i>
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--text-primary);">Yapımcı Ol</h3>
            <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem;">CineScope'un gerçek bir kahramanı ve destekçisi olun.</p>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 2rem;">₺1000 <span style="font-size: 1rem; color: var(--text-muted); font-weight: 400;">/tek seferlik</span></div>
            <a href="#" class="btn btn-outline" style="width: 100%; display: block; box-sizing: border-box; border-color: #f59e0b; color: #f59e0b;">Destek Ol</a>
        </div>
        
    </div>
<style>
    .support-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto;
    }
    .support-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 4rem auto;
    }
    .support-title {
        font-size: 3rem;
        justify-content: center;
    }
    .support-icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        margin-bottom: 1.5rem;
    }
    .support-card {
        padding: 3rem 2rem;
        text-align: center;
        border-radius: var(--radius-lg);
        position: relative;
        overflow: hidden;
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .support-card.popular {
        border: 1px solid var(--accent-color);
        transform: scale(1.05);
        z-index: 10;
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15);
    }
    .support-card:hover {
        transform: translateY(-5px);
    }
    .support-card.popular:hover {
        transform: scale(1.05) translateY(-5px);
    }
    
    @media (max-width: 992px) {
        .support-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }
        .support-card.popular {
            transform: scale(1);
            z-index: 1;
        }
        .support-card.popular:hover {
            transform: translateY(-5px);
        }
    }

    @media (max-width: 768px) {
        .support-title {
            font-size: 2.2rem;
        }
        .support-header {
            margin-bottom: 2rem;
        }
        .support-header p {
            font-size: 1rem !important;
            padding: 0 1rem;
        }
        .support-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        .support-card {
            padding: 2rem 1.5rem;
        }
        .support-icon-wrapper {
            width: 60px;
            height: 60px;
        }
        .support-icon-wrapper i {
            font-size: 1.5em;
        }
    }
</style>
@endsection
