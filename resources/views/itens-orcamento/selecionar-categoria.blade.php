@extends('adminlte::page')

@section('content_header')
@endsection

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700;800&family=Roboto:wght@300;400;500;600&display=swap');

    :root {
        --ink:       #0d1117;
        --ink-soft:  #3a4252;
        --ink-muted: #8891a4;
        --surface:   #f4f5f7;
        --card:      #ffffff;
        --border:    #e2e5eb;
        --accent:    #1c6ef3;
        --green:     #16a34a;
        --amber:     #d97706;
        --red:       #dc2626;
        --purple:    #7c3aed;
        --teal:      #0891b2;
        --radius:    12px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,.08), 0 2px 6px rgba(0,0,0,.05);
        --shadow-lg: 0 10px 32px rgba(0,0,0,.10), 0 4px 12px rgba(0,0,0,.06);
    }

    * { box-sizing: border-box; }

    body, .wrapper {
        background: var(--surface) !important;
        font-family: 'Roboto', sans-serif !important;
        color: var(--ink) !important;
    }

    /* ── Page Header ── */
    .page-header {
        background: var(--ink);
        border-radius: var(--radius);
        padding: 28px 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        right: -60px; top: -60px;
        width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(28,110,243,.35) 0%, transparent 70%);
        pointer-events: none;
    }
    .page-header::after {
        content: '';
        position: absolute;
        right: 80px; bottom: -80px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(8,145,178,.2) 0%, transparent 70%);
        pointer-events: none;
    }
    .page-header-left h1 {
        font-family: 'Roboto Slab', serif;
        font-weight: 800;
        font-size: 1.9rem;
        color: #fff;
        margin: 0 0 4px;
        letter-spacing: -.3px;
    }
    .page-header-left p {
        color: rgba(255,255,255,.5);
        font-size: .92rem;
        margin: 0;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 500;
        text-decoration: none !important;
        transition: all .2s;
        background: rgba(255,255,255,.1);
        color: rgba(255,255,255,.85) !important;
        border: 1px solid rgba(255,255,255,.15);
        position: relative;
        z-index: 1;
        font-family: 'Roboto', sans-serif;
    }
    .btn-back:hover {
        background: rgba(255,255,255,.18);
        color: #fff !important;
        transform: translateY(-1px);
    }

    /* ── Section Title ── */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .section-title {
        font-family: 'Roboto Slab', serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--ink);
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }
    .section-title i { color: var(--accent); }
    .section-count {
        font-size: .82rem;
        font-weight: 500;
        color: var(--ink-muted);
        background: var(--card);
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid var(--border);
    }

    /* ── Category Cards ── */
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }
    .cat-card {
        background: var(--card);
        border-radius: var(--radius);
        border: 1.5px solid var(--border);
        padding: 24px 20px 20px;
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: transform .22s, box-shadow .22s, border-color .22s;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .cat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--teal));
        opacity: 0;
        transition: opacity .22s;
    }
    .cat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(28,110,243,.3);
        text-decoration: none !important;
    }
    .cat-card:hover::before {
        opacity: 1;
    }

    .cat-icon-wrap {
        width: 52px; height: 52px;
        border-radius: 12px;
        background: rgba(28,110,243,.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: var(--accent);
        transition: background .22s, color .22s, transform .22s;
        flex-shrink: 0;
    }
    .cat-card:hover .cat-icon-wrap {
        background: var(--accent);
        color: #fff;
        transform: scale(1.08);
    }

    .cat-body { flex: 1; }
    .cat-name {
        font-family: 'Roboto Slab', serif;
        font-weight: 700;
        font-size: .98rem;
        color: var(--ink);
        margin: 0 0 5px;
        line-height: 1.3;
        transition: color .2s;
    }
    .cat-card:hover .cat-name { color: var(--accent); }
    .cat-desc {
        font-size: .82rem;
        color: var(--ink-muted);
        margin: 0;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cat-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid var(--border);
    }
    .cat-code {
        display: inline-flex;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: .75rem;
        font-weight: 700;
        background: rgba(124,58,237,.08);
        color: var(--purple);
        font-family: 'Roboto', monospace;
        letter-spacing: .3px;
    }
    .cat-arrow {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: var(--surface);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ink-muted);
        font-size: .75rem;
        transition: all .2s;
    }
    .cat-card:hover .cat-arrow {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    /* ── Empty State ── */
    .empty-wrap {
        background: var(--card);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        text-align: center;
        padding: 64px 24px;
    }
    .empty-icon {
        font-size: 3rem;
        color: var(--border);
        margin-bottom: 16px;
    }
    .empty-wrap h4 {
        font-family: 'Roboto Slab', serif;
        font-weight: 700;
        color: var(--ink-soft);
        margin-bottom: 6px;
    }
    .empty-wrap p {
        color: var(--ink-muted);
        font-size: .9rem;
        margin-bottom: 22px;
    }
    .btn-empty {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 24px;
        background: var(--accent);
        color: #fff !important;
        border-radius: 8px;
        font-weight: 600;
        font-size: .9rem;
        text-decoration: none !important;
        transition: all .2s;
    }
    .btn-empty:hover { background: #1558d0; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(28,110,243,.35); }

    @media (max-width: 992px) { .cat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px)  { .cat-grid { grid-template-columns: 1fr; } }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1><i class="fas fa-folder-open mr-2" style="font-size:1.4rem; opacity:.7;"></i>Módulos de Medição</h1>
        <p>Selecione o módulo de medicao para visualizar ou gerir os seus itens</p>
    </div>
    <a href="{{ url('/home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<!-- Section Header -->
<div class="section-header">
    <h2 class="section-title">
        <i class="fas fa-th-large"></i> Módulos de Obra
    </h2>
    <span class="section-count">{{ $categorias->count() }} {{ $categorias->count() == 1 ? 'categoria' : 'categorias' }}</span>
</div>

<!-- Categories Grid -->
@if($categorias->isNotEmpty())
<div class="cat-grid">
    @foreach ($categorias as $categoria)
    <a href="{{ route('itens-orcamento.list', ['categoria_id' => $categoria->id]) }}" class="cat-card">
        <div class="cat-icon-wrap">
            <i class="fas fa-building"></i>
        </div>
        <div class="cat-body">
            <p class="cat-name">{{ $categoria->nome }}</p>
            <p class="cat-desc">{{ $categoria->descricao ?? 'Sem descrição disponível' }}</p>
        </div>
        <div class="cat-footer">
            <span class="cat-code">{{ $categoria->codigo }}</span>
            <span class="cat-arrow"><i class="fas fa-arrow-right"></i></span>
        </div>
    </a>
    @endforeach
</div>
@else
<div class="empty-wrap">
    <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
    <h4>Nenhum módulo encontrado</h4>
    <p>Crie um módulo de obra para começar a adicionar itens de orçamento.</p>
    <a href="{{ route('categorias-obra.create') }}" class="btn-empty">
        <i class="fas fa-plus"></i> Criar Novo Módulo
    </a>
</div>
@endif

@endsection