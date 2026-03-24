@extends('adminlte::page')

@section('title', 'Novo Material')

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
        --red:       #dc2626;
        --radius:    12px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,.08), 0 2px 6px rgba(0,0,0,.05);
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
        padding: 24px 32px;
        margin-bottom: 24px;
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
        width: 260px; height: 260px;
        background: radial-gradient(circle, rgba(28,110,243,.35) 0%, transparent 70%);
        pointer-events: none;
    }
    .page-header-left h1 {
        font-family: 'Roboto Slab', serif;
        font-weight: 800;
        font-size: 1.7rem;
        color: #fff;
        margin: 0 0 4px;
        letter-spacing: -.3px;
    }
    .page-header-left p {
        color: rgba(255,255,255,.5);
        font-size: .88rem;
        margin: 0;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
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
    }
    .btn-back:hover {
        background: rgba(255,255,255,.18);
        color: #fff !important;
        transform: translateY(-1px);
    }

    /* ── Form Card ── */
    .form-card {
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .form-card-header {
        padding: 18px 28px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-card-header-icon {
        width: 38px; height: 38px;
        border-radius: 9px;
        background: rgba(28,110,243,.1);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .form-card-header-title {
        font-family: 'Roboto Slab', serif;
        font-weight: 700;
        font-size: 1rem;
        color: var(--ink);
        margin: 0;
    }
    .form-card-header-sub {
        font-size: .8rem;
        color: var(--ink-muted);
        margin: 2px 0 0;
    }
    .form-card-body {
        padding: 28px;
    }

    /* ── Form Fields ── */
    .field-group {
        margin-bottom: 22px;
    }
    .field-label {
        display: block;
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 7px;
    }
    .field-label .req {
        color: var(--red);
        margin-left: 2px;
    }
    .field-input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .92rem;
        color: var(--ink);
        background: var(--surface);
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
        appearance: none;
    }
    .field-input:focus {
        border-color: var(--accent);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(28,110,243,.12);
    }
    .field-input.is-invalid {
        border-color: var(--red);
        background: #fff5f5;
    }
    .field-input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220,38,38,.12);
    }
    .field-hint {
        font-size: .78rem;
        color: var(--ink-muted);
        margin-top: 5px;
    }
    .field-error {
        font-size: .78rem;
        color: var(--red);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Section Divider ── */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 28px 0 22px;
    }
    .section-divider-label {
        font-family: 'Roboto Slab', serif;
        font-size: .82rem;
        font-weight: 600;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .7px;
        white-space: nowrap;
    }
    .section-divider-line {
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── Form Footer ── */
    .form-card-footer {
        padding: 20px 28px;
        border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 22px;
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .88rem;
        font-weight: 500;
        text-decoration: none !important;
        border: 1.5px solid var(--border);
        background: var(--card);
        color: var(--ink-soft) !important;
        transition: all .2s;
        cursor: pointer;
    }
    .btn-cancel:hover {
        border-color: var(--ink-muted);
        color: var(--ink) !important;
        transform: translateY(-1px);
    }
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 26px;
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .88rem;
        font-weight: 600;
        border: none;
        background: var(--accent);
        color: #fff;
        cursor: pointer;
        transition: all .2s;
    }
    .btn-save:hover {
        background: #1558d0;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(28,110,243,.35);
    }
    .btn-save:active {
        transform: translateY(0);
    }

    /* ── Validation Alert ── */
    .alert-validation {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .alert-validation-icon {
        color: var(--red);
        font-size: 1.1rem;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .alert-validation ul {
        margin: 6px 0 0;
        padding-left: 16px;
        font-size: .85rem;
        color: #991b1b;
    }
    .alert-validation-title {
        font-weight: 600;
        color: var(--red);
        font-size: .9rem;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1><i class="fas fa-plus-circle mr-2" style="font-size:1.3rem; opacity:.7;"></i>Novo Material</h1>
        <p>Preencha os campos abaixo para cadastrar um novo material</p>
    </div>
    <a href="{{ route('materiais.list') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Voltar à lista
    </a>
</div>

<!-- Validation Errors -->
@if($errors->any())
<div class="alert-validation">
    <div class="alert-validation-icon"><i class="fas fa-exclamation-circle"></i></div>
    <div>
        <div class="alert-validation-title">Corrija os erros abaixo para continuar</div>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<!-- Form Card -->
<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-header-icon">
            <i class="fas fa-cube"></i>
        </div>
        <div>
            <p class="form-card-header-title">Dados do Material</p>
            <p class="form-card-header-sub">Campos marcados com <span style="color:var(--red);">*</span> são obrigatórios</p>
        </div>
    </div>

    <form action="{{ route('materiais.store') }}" method="post" novalidate>
        @csrf
        <div class="form-card-body">
            @include('materiais.partials.form')
        </div>
        <div class="form-card-footer">
            <a href="{{ route('materiais.list') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Salvar Material
            </button>
        </div>
    </form>
</div>

@endsection