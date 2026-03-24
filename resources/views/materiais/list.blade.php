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
        --accent-2:  #0ea5e9;
        --green:     #16a34a;
        --amber:     #d97706;
        --red:       #dc2626;
        --purple:    #7c3aed;
        --radius:    12px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,.08), 0 2px 6px rgba(0,0,0,.05);
        --shadow-lg: 0 10px 40px rgba(0,0,0,.10), 0 4px 12px rgba(0,0,0,.06);
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
        background: radial-gradient(circle, rgba(14,165,233,.2) 0%, transparent 70%);
        pointer-events: none;
    }
    .page-header-left h1 {
        font-family: 'Roboto Slab', serif;
        font-weight: 800;
        font-size: 1.9rem;
        color: #fff;
        margin: 0 0 4px;
        letter-spacing: -.5px;
    }
    .page-header-left p {
        color: rgba(255,255,255,.5);
        font-size: .92rem;
        margin: 0;
        font-weight: 400;
    }
    .page-header-right {
        display: flex;
        gap: 10px;
        position: relative;
        z-index: 1;
    }
    .btn-header {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none !important;
        transition: all .2s;
        border: none;
        cursor: pointer;
    }
    .btn-header-primary {
        background: var(--accent);
        color: #fff !important;
    }
    .btn-header-primary:hover {
        background: #1558d0;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(28,110,243,.4);
        color: #fff !important;
    }
    .btn-header-ghost {
        background: rgba(255,255,255,.1);
        color: rgba(255,255,255,.85) !important;
        border: 1px solid rgba(255,255,255,.15);
    }
    .btn-header-ghost:hover {
        background: rgba(255,255,255,.18);
        color: #fff !important;
        transform: translateY(-1px);
    }

    /* ── Stat Cards ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: var(--card);
        border-radius: var(--radius);
        padding: 22px 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: box-shadow .2s, transform .2s;
    }
    .stat-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.3rem;
    }
    .stat-icon.blue   { background: rgba(28,110,243,.1);  color: var(--accent); }
    .stat-icon.green  { background: rgba(22,163,74,.1);   color: var(--green); }
    .stat-icon.amber  { background: rgba(217,119,6,.1);   color: var(--amber); }
    .stat-body {}
    .stat-value {
        font-family: 'Roboto Slab', serif;
        font-size: 1.7rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
        margin-bottom: 3px;
    }
    .stat-label {
        font-size: .82rem;
        color: var(--ink-muted);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    /* ── Filter Panel ── */
    .filter-panel {
        background: var(--card);
        border-radius: var(--radius);
        padding: 20px 24px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }
    .filter-panel .row { align-items: flex-end; }
    .filter-label {
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 6px;
        display: block;
    }
    .filter-control {
        width: 100%;
        padding: 9px 14px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .9rem;
        color: var(--ink);
        background: var(--surface);
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        appearance: none;
    }
    .filter-control:focus {
        border-color: var(--accent);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(28,110,243,.12);
    }
    .btn-filter {
        width: 100%;
        padding: 9px 20px;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background .2s, transform .2s;
    }
    .btn-filter:hover {
        background: #1558d0;
        transform: translateY(-1px);
    }

    /* ── Table Card ── */
    .table-card {
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .table-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-card-title {
        font-family: 'Roboto Slab', serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--ink);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-card-title i { color: var(--accent); }
    .table-count {
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 500;
        color: var(--ink-muted);
        background: var(--surface);
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid var(--border);
    }

    /* ── Table ── */
    .mat-table { width: 100%; border-collapse: collapse; }
    .mat-table thead th {
        padding: 11px 14px;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
        color: var(--ink-muted);
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    .mat-table thead th:first-child { padding-left: 24px; }
    .mat-table thead th:last-child  { padding-right: 24px; }
    .mat-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .mat-table tbody tr:last-child { border-bottom: none; }
    .mat-table tbody tr:hover { background: rgba(28,110,243,.03); }
    .mat-table tbody td {
        padding: 13px 14px;
        font-size: .9rem;
        color: var(--ink-soft);
        vertical-align: middle;
    }
    .mat-table tbody td:first-child { padding-left: 24px; }
    .mat-table tbody td:last-child  { padding-right: 24px; }

    /* ── Chips / Badges ── */
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: .78rem;
        font-weight: 600;
        line-height: 1.5;
    }
    .chip-id {
        background: var(--surface);
        color: var(--ink-muted);
        border: 1px solid var(--border);
        font-variant-numeric: tabular-nums;
    }
    .chip-code {
        background: rgba(124,58,237,.08);
        color: var(--purple);
        font-family: 'Syne', monospace;
        letter-spacing: .3px;
    }
    .chip-unit {
        background: rgba(14,165,233,.1);
        color: #0369a1;
    }
    .chip-cat {
        background: rgba(28,110,243,.08);
        color: var(--accent);
    }

    /* ── Values ── */
    .val-main {
        font-weight: 700;
        color: var(--green);
        font-size: .95rem;
        font-variant-numeric: tabular-nums;
    }
    .val-unit {
        display: block;
        font-size: .78rem;
        color: var(--ink-muted);
        font-weight: 400;
        margin-top: 1px;
    }
    .mat-name {
        font-weight: 600;
        color: var(--ink);
        font-size: .92rem;
    }

    /* ── Action Buttons ── */
    .action-group { display: flex; gap: 6px; }
    .btn-icon {
        width: 34px; height: 34px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: .82rem;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-icon-edit {
        background: rgba(217,119,6,.1);
        color: var(--amber);
    }
    .btn-icon-edit:hover {
        background: var(--amber);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(217,119,6,.3);
    }
    .btn-icon-del {
        background: rgba(220,38,38,.08);
        color: var(--red);
    }
    .btn-icon-del:hover {
        background: var(--red);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220,38,38,.3);
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state-icon {
        font-size: 3rem;
        color: var(--border);
        margin-bottom: 16px;
    }
    .empty-state h4 {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        color: var(--ink-soft);
        margin-bottom: 6px;
    }
    .empty-state p {
        color: var(--ink-muted);
        font-size: .9rem;
        margin-bottom: 20px;
    }
    .btn-empty {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 22px;
        background: var(--accent);
        color: #fff !important;
        border-radius: 8px;
        font-weight: 600;
        font-size: .88rem;
        text-decoration: none !important;
        transition: all .2s;
    }
    .btn-empty:hover { background: #1558d0; transform: translateY(-1px); }

    /* ── Pagination ── */
    .table-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pagination-info {
        font-size: .85rem;
        color: var(--ink-muted);
    }
    .pagination {
        display: flex;
        gap: 4px;
        margin: 0;
        list-style: none;
        padding: 0;
    }
    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid var(--border);
        color: var(--ink-soft);
        background: var(--card);
        transition: all .2s;
    }
    .pagination li a:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: rgba(28,110,243,.05);
    }
    .pagination li.active span {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }
    .pagination li.disabled span {
        opacity: .4;
        cursor: not-allowed;
    }

    /* ── Fix oversized Prev / Next arrows from Laravel pagination ── */
    .pagination li a svg,
    .pagination li span svg {
        width: 14px !important;
        height: 14px !important;
        vertical-align: middle;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .stats-row { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; gap: 16px; align-items: flex-start; }
        .page-header::before, .page-header::after { display: none; }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1><i class="fas fa-cubes mr-2" style="font-size:1.5rem; opacity:.7;"></i>Base de Preços</h1>
        <p>Gestão de materiais e insumos &mdash; {{ $stats['total'] }} itens cadastrados</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('materiais.export') }}" class="btn-header btn-header-ghost">
            <i class="fas fa-download"></i> Exportar
        </a>
        <a href="{{ route('materiais.create') }}" class="btn-header btn-header-primary">
            <i class="fas fa-plus"></i> Novo Material
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-cubes"></i></div>
        <div class="stat-body">
            <div class="stat-value">{{ number_format($stats['total'], 0, ',', '.') }}</div>
            <div class="stat-label">Total de Materiais</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-tags"></i></div>
        <div class="stat-body">
            <div class="stat-value">{{ number_format($stats['total_categorias'], 0) }}</div>
            <div class="stat-label">Categorias</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fas fa-chart-line"></i></div>
        <div class="stat-body">
            <div class="stat-value" style="font-size:1.3rem;">MT {{ number_format($stats['valor_medio'], 2, ',', '.') }}</div>
            <div class="stat-label">Valor Médio</div>
        </div>
    </div>
</div>

<!-- Filter Panel -->
<div class="filter-panel">
    <form method="GET" action="{{ route('materiais.list') }}">
        <div class="row" style="gap: 0; margin: 0 -8px;">
            <div class="col-md-4" style="padding: 0 8px;">
                <label class="filter-label"><i class="fas fa-search mr-1"></i>Pesquisar</label>
                <input type="text" class="filter-control" name="search"
                       placeholder="Código, nome ou categoria..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3" style="padding: 0 8px;">
                <label class="filter-label"><i class="fas fa-layer-group mr-1"></i>Categoria</label>
                <select class="filter-control" name="categoria">
                    <option value="">Todas as categorias</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3" style="padding: 0 8px;">
                <label class="filter-label"><i class="fas fa-sort-amount-down mr-1"></i>Ordenar por</label>
                <select class="filter-control" name="ordenar_por" id="ordenarPor">
                    <option value="categoria"   {{ request('ordenar_por') == 'categoria'   ? 'selected' : '' }}>Categoria</option>
                    <option value="nome"        {{ request('ordenar_por') == 'nome'        ? 'selected' : '' }}>Nome</option>
                    <option value="codigo"      {{ request('ordenar_por') == 'codigo'      ? 'selected' : '' }}>Código</option>
                    <option value="valor_compra"{{ request('ordenar_por') == 'valor_compra'? 'selected' : '' }}>Valor</option>
                </select>
            </div>
            <div class="col-md-2" style="padding: 0 8px;">
                <label class="filter-label" style="visibility:hidden;">.</label>
                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-card-header">
        <h3 class="table-card-title">
            <i class="fas fa-boxes"></i> Lista de Materiais
        </h3>
        <span class="table-count">
            @if($materiais->total() > 0)
                {{ $materiais->firstItem() }}–{{ $materiais->lastItem() }} de {{ $materiais->total() }}
            @else
                0 registros
            @endif
        </span>
    </div>

    <div style="overflow-x: auto;">
        <table class="mat-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Nome do Material</th>
                    <th>Unid.</th>
                    <th>Valor Compra</th>
                    <th>Rendimento</th>
                    <th>Custo Unit.*</th>
                    <th>Categoria</th>
                    <th style="text-align:center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($materiais as $material)
                <tr>
                    <td><span class="chip chip-id">{{ $material->id }}</span></td>
                    <td><span class="chip chip-code">{{ $material->codigo }}</span></td>
                    <td><span class="mat-name">{{ $material->nome }}</span></td>
                    <td><span class="chip chip-unit">{{ $material->unidade }}</span></td>
                    <td><span class="val-main">MT {{ $material->valor_compra_formatado }}</span></td>
                    <td style="color: var(--ink-muted);">{{ $material->rendimento_formatado }}</td>
                    <td>
                        @if($material->rendimento > 0)
                            <span class="val-main">
                                MT {{ number_format($material->valor_compra / $material->rendimento, 2, ',', '.') }}
                            </span>
                            <span class="val-unit">/{{ $material->unidade }}</span>
                        @else
                            <span style="color: var(--ink-muted);">—</span>
                        @endif
                    </td>
                    <td><span class="chip chip-cat"><i class="fas fa-tag" style="font-size:.7rem;"></i> {{ $material->categoria }}</span></td>
                    <td>
                        <div class="action-group" style="justify-content:center;">
                            <a href="{{ route('materiais.edit', $material->id) }}"
                               class="btn-icon btn-icon-edit" title="Editar">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button"
                                    class="btn-icon btn-icon-del"
                                    onclick="confirmDelete({{ $material->id }}, '{{ addslashes($material->nome) }}')"
                                    title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-box-open"></i></div>
                            <h4>Nenhum material encontrado</h4>
                            <p>Tente ajustar os filtros ou adicione um novo material.</p>
                            <a href="{{ route('materiais.create') }}" class="btn-empty">
                                <i class="fas fa-plus"></i> Adicionar Material
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($materiais->hasPages())
    <div class="table-footer">
        <div class="pagination-info">
            <i class="fas fa-list mr-1"></i>
            Exibindo <strong>{{ $materiais->firstItem() }}</strong> a <strong>{{ $materiais->lastItem() }}</strong>
            de <strong>{{ $materiais->total() }}</strong> registros
        </div>
        <div>
            {{ $materiais->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>

<script>
    function confirmDelete(id, nome) {
        Swal.fire({
            title: 'Excluir material?',
            html: `<p style="color:#6b7280; margin-bottom:4px;">Você está prestes a excluir:</p>
                   <strong style="color:#dc2626;">"${nome}"</strong>
                   <p style="color:#9ca3af; font-size:.85rem; margin-top:8px; margin-bottom:0;">Esta ação não pode ser desfeita.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Excluir',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                popup: 'swal-rounded',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) { console.error('CSRF token not found'); return; }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("materiais.destroy", "") }}/' + id;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');

                form.appendChild(methodInput);
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Flash notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            toast: true,
            position: 'top-end'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626'
        });
    @endif

    // Auto-submit on sort change
    document.getElementById('ordenarPor')?.addEventListener('change', function () {
        this.closest('form').submit();
    });
</script>

@endsection