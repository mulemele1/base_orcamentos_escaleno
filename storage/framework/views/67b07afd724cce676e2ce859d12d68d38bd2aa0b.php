

<?php $__env->startSection('title', 'Módulos de Obra'); ?>

<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
        font-family: 'Roboto', sans-serif;
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

    /* ── Filter Panel ── */
    .filter-panel {
        background: var(--card);
        border-radius: var(--radius);
        padding: 20px 24px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }
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
        text-decoration: none !important;
    }
    .btn-filter:hover { background: #1558d0; transform: translateY(-1px); }
    .btn-clear {
        width: 100%;
        padding: 9px 20px;
        background: var(--card);
        color: var(--ink-soft) !important;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .9rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all .2s;
        text-decoration: none !important;
    }
    .btn-clear:hover {
        border-color: var(--ink-muted);
        color: var(--ink) !important;
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
    .mat-table thead th:last-child  { padding-right: 24px; text-align: center; }
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

    /* ── Chips ── */
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
    }
    .chip-code {
        background: rgba(124,58,237,.08);
        color: var(--purple);
        font-family: 'Roboto', monospace;
        letter-spacing: .3px;
    }
    .chip-order {
        background: rgba(8,145,178,.1);
        color: var(--teal);
        font-weight: 700;
    }
    .mat-name {
        font-weight: 600;
        color: var(--ink);
        font-size: .92rem;
    }
    .mat-desc {
        font-size: .88rem;
        color: var(--ink-muted);
    }

    /* ── Action Buttons ── */
    .action-group { display: flex; gap: 6px; justify-content: center; }
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
    .btn-icon-pdf {
        background: rgba(220,38,38,.08);
        color: var(--red);
    }
    .btn-icon-pdf:hover {
        background: var(--red);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220,38,38,.3);
    }
    .btn-icon-del {
        background: rgba(13,17,23,.06);
        color: var(--ink-soft);
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
        font-family: 'Roboto Slab', serif;
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
    .pagination li a svg,
    .pagination li span svg {
        width: 14px !important;
        height: 14px !important;
        vertical-align: middle;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1><i class="fas fa-folder-open mr-2" style="font-size:1.4rem; opacity:.7;"></i>Módulos de Obra</h1>
        <p>Gerenciamento de Módulos e estrutura de obras</p>
    </div>
    <div class="page-header-right">
        <a href="<?php echo e(url('/home')); ?>" class="btn-header btn-header-ghost">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="<?php echo e(route('categorias-obra.create')); ?>" class="btn-header btn-header-primary">
            <i class="fas fa-plus"></i> Novo Módulo
        </a>
    </div>
</div>

<!-- Filter Panel -->
<div class="filter-panel">
    <form method="GET" action="<?php echo e(route('categorias-obra.list')); ?>">
        <div class="row" style="margin: 0 -8px; align-items: flex-end;">
            <div class="col-md-8" style="padding: 0 8px;">
                <label class="filter-label"><i class="fas fa-search mr-1"></i>Pesquisar</label>
                <input type="text" class="filter-control" name="search"
                       placeholder="Código, nome ou descrição..."
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2" style="padding: 0 8px;">
                <label class="filter-label" style="visibility:hidden;">.</label>
                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </div>
            <div class="col-md-2" style="padding: 0 8px;">
                <label class="filter-label" style="visibility:hidden;">.</label>
                <a href="<?php echo e(route('categorias-obra.list')); ?>" class="btn-clear">
                    <i class="fas fa-times"></i> Limpar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-card-header">
        <h3 class="table-card-title">
            <i class="fas fa-folder"></i> Lista de Módulo
        </h3>
        <span class="table-count">
            <?php if($categorias->total() > 0): ?>
                <?php echo e($categorias->firstItem()); ?>–<?php echo e($categorias->lastItem()); ?> de <?php echo e($categorias->total()); ?>

            <?php else: ?>
                0 registros
            <?php endif; ?>
        </span>
    </div>

    <div style="overflow-x: auto;">
        <table class="mat-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Ordem</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span class="chip chip-id"><?php echo e($categoria->id); ?></span></td>
                    <td><span class="chip chip-code"><?php echo e($categoria->codigo); ?></span></td>
                    <td><span class="mat-name"><?php echo e($categoria->nome); ?></span></td>
                    <td><span class="chip chip-order"><?php echo e($categoria->ordem); ?></span></td>
                    <td><span class="mat-desc"><?php echo e($categoria->descricao ?? '—'); ?></span></td>
                    <td>
                        <div class="action-group">
                            <a href="<?php echo e(route('categorias-obra.edit', $categoria->id)); ?>"
                               class="btn-icon btn-icon-edit" title="Editar">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="<?php echo e(route('pdf.categoria', $categoria->id)); ?>"
                               target="_blank"
                               class="btn-icon btn-icon-pdf" title="Gerar PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <button type="button"
                                    class="btn-icon btn-icon-del"
                                    onclick="confirmDelete(<?php echo e($categoria->id); ?>, '<?php echo e(addslashes($categoria->nome)); ?>')"
                                    title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-folder-open"></i></div>
                            <h4>Nenhum Módulo encontrada</h4>
                            <p>Tente ajustar o filtro ou cadastre um novo Módulo.</p>
                            <a href="<?php echo e(route('categorias-obra.create')); ?>" class="btn-empty">
                                <i class="fas fa-plus"></i> Novo Módulo
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($categorias->hasPages()): ?>
    <div class="table-footer">
        <div class="pagination-info">
            <i class="fas fa-list mr-1"></i>
            Exibindo <strong><?php echo e($categorias->firstItem()); ?></strong> a <strong><?php echo e($categorias->lastItem()); ?></strong>
            de <strong><?php echo e($categorias->total()); ?></strong> registros
        </div>
        <div>
            <?php echo e($categorias->appends(request()->query())->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>

<script>
    function confirmDelete(id, nome) {
        Swal.fire({
            title: 'Excluir categoria?',
            html: `<p style="color:#6b7280; margin-bottom:4px;">Você está prestes a excluir:</p>
                   <strong style="color:#dc2626;">"${nome}"</strong>
                   <p style="color:#9ca3af; font-size:.85rem; margin-top:8px; margin-bottom:0;">Esta ação não pode ser desfeita.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Excluir',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) return;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo e(route("categorias-obra.destroy", "")); ?>/' + id;

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

    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '<?php echo e(session('success')); ?>',
            showConfirmButton: false,
            timer: 3000,
            toast: true,
            position: 'top-end'
        });
    <?php endif; ?>

    <?php if(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: '<?php echo e(session('error')); ?>',
            confirmButtonColor: '#dc2626'
        });
    <?php endif; ?>
</script>

<?php echo $__env->make('layouts.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/categorias-obra/list.blade.php ENDPATH**/ ?>