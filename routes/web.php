<?php

use App\Http\Controllers\{
    AdministracaoController,
    DashboardController,
    DesembolsoinsController,
    DesembolsoController,
    DesembolsoinsfonteController,
    DesembolsodafController,
    DispensaController,
    DistribuicaoController,
    FonteController,
    GraficoController,
    ParticipanteController,
    ProjectoController,
    RecepcaoController,
    UserController,
    FornecedorController,
    ClienteController,
    PrecoMaterialController,
    PropostaController,
    RequisicaoController,
    MaterialController,
    GestaoController,
    PdfController,
    MedicaoController,
    OrcamentoController,
    TemplateOrcamentoController,
    OrcamentoAtividadeController,
    ProjetoController,
    ComposicaoCustoController,
    SubatividadeController,
    AtividadeController,
    ConfiguracaoController,
    GerenciaController,
    RequisicaocispoController,
    DashboarduserController,
    CategoriaObraController,
    ItemOrcamentoController,
    SummaryController,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== ROTA DE PROGRESSO ====================
Route::get('/progresso', function () {
    return view('progresso');
})->name('progresso')->middleware('auth');

// ==================== PERSONALIZAÇÃO DO LOGIN ====================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');
    
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->route('progresso');
    }
    
    return back()->withErrors([
        'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
    ])->onlyInput('email');
})->name('login');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register', function () {
    return redirect('/login');
})->name('register');

// ==================== GRÁFICOS ====================
Route::get('/relatorios/projecto/anos', [GraficoController::class, 'projectoAnos'])->name('relatorios.projecto.anos')->middleware(['auth']);
Route::get('/relatorios/projecto/ano', [GraficoController::class, 'projectoAno'])->name('relatorios.projecto.ano')->middleware(['auth']);
Route::get('/relatorios/administracao/anos', [GraficoController::class, 'administracaoAnos'])->name('relatorios.administracao.anos')->middleware(['auth']);
Route::get('/relatorios/administracao/ano', [GraficoController::class, 'administracaoAno'])->name('relatorios.administracao.ano')->middleware(['auth']);
Route::get('/relatorios/recepcao/anos', [GraficoController::class, 'recepcaoAnos'])->name('relatorios.recepcao.anos')->middleware(['auth']);
Route::get('/relatorios/recepcao/ano', [GraficoController::class, 'recepcaoAno'])->name('relatorios.recepcao.ano')->middleware(['auth']);
Route::get('/relatorios/participanteDN/anoN', [GraficoController::class, 'participanteAnoDN'])->name('relatorios.participanteDN.anoN')->middleware(['auth']);
Route::get('/relatorios/participanteDV/anoV', [GraficoController::class, 'participanteAnoDV'])->name('relatorios.participanteDV.anoV')->middleware(['auth']);
Route::get('/relatorios/fontedaf/ano', [GraficoController::class, 'fontedafAno'])->name('relatorios.fontedaf.ano')->middleware(['auth']);
Route::get('/relatorios/fontedaf/anos', [GraficoController::class, 'fontedafAnos'])->name('relatorios.fontedaf.anos')->middleware(['auth']);

// ==================== ROTAS AUTENTICADAS ====================
Route::middleware(['auth'])->group(function () {
    
    // ==================== USERS ====================
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users/list', [UserController::class, 'list'])->name('users.list');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    // ==================== CLIENTES ====================
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::get('/clientes/list', [ClienteController::class, 'list'])->name('clientes.list');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');

    // ==================== FORNECEDORES ====================
    Route::prefix('fornecedores')->name('fornecedores.')->group(function () {
        Route::get('/list', [FornecedorController::class, 'list'])->name('list');
        Route::get('/create', [FornecedorController::class, 'create'])->name('create');
        Route::post('/store', [FornecedorController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [FornecedorController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FornecedorController::class, 'update'])->name('update');
        Route::delete('/{id}', [FornecedorController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [FornecedorController::class, 'show'])->name('show');
    });

    // ==================== CATEGORIAS DE OBRA ====================
    Route::prefix('categorias-obra')->name('categorias-obra.')->group(function () {
        Route::get('/list', [CategoriaObraController::class, 'list'])->name('list');
        Route::get('/create', [CategoriaObraController::class, 'create'])->name('create');
        Route::post('/store', [CategoriaObraController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoriaObraController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoriaObraController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoriaObraController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [CategoriaObraController::class, 'show'])->name('show');
    });

    // ==================== MATERIAIS ====================
    Route::prefix('materiais')->name('materiais.')->group(function () {
        Route::get('/list', [MaterialController::class, 'list'])->name('list');
        Route::get('/create', [MaterialController::class, 'create'])->name('create');
        Route::post('/store', [MaterialController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MaterialController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MaterialController::class, 'update'])->name('update');
        Route::delete('/{id}', [MaterialController::class, 'destroy'])->name('destroy');
        Route::get('/export', [MaterialController::class, 'export'])->name('export');
        Route::get('/{id}', [MaterialController::class, 'show'])->name('show');
        Route::get('/{id}/duplicate', [MaterialController::class, 'duplicate'])->name('duplicate');
        Route::post('/bulk-update', [MaterialController::class, 'bulkUpdate'])->name('bulk-update');
        Route::get('/categoria/{categoria}', [MaterialController::class, 'getByCategoria'])->name('categoria');
        Route::post('/import', [MaterialController::class, 'import'])->name('import');
    });

    // ==================== PROJETOS ====================
    Route::prefix('projetos')->name('projetos.')->group(function () {
        Route::get('/', [ProjetoController::class, 'index'])->name('index');
        Route::get('/create', [ProjetoController::class, 'create'])->name('create');
        Route::post('/', [ProjetoController::class, 'store'])->name('store');
        Route::get('/{id}', [ProjetoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProjetoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProjetoController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProjetoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/nova-versao', [ProjetoController::class, 'novaVersao'])->name('nova-versao');
    });

    // ==================== MEDIÇÕES (VIA PROJETO) ====================
    Route::prefix('projetos/{projeto}/medicoes')->name('medicoes.')->group(function () {
        Route::get('/dashboard', [MedicaoController::class, 'dashboard'])->name('dashboard');
        Route::get('/create', [MedicaoController::class, 'create'])->name('create');
        Route::post('/', [MedicaoController::class, 'store'])->name('store');
        Route::get('/{medicao}/edit', [MedicaoController::class, 'edit'])->name('edit');
        Route::put('/{medicao}', [MedicaoController::class, 'update'])->name('update');
        Route::delete('/{medicao}', [MedicaoController::class, 'destroy'])->name('destroy');
        Route::put('/finalizar', [MedicaoController::class, 'finalizar'])->name('finalizar');
    });

    // ==================== ADMIN - ESTRUTURA ====================
    Route::prefix('admin/estrutura')->name('admin.estrutura.')->middleware(['can:is_admin'])->group(function () {
        
        // Dashboard
        Route::get('/', [App\Http\Controllers\Admin\EstruturaController::class, 'index'])->name('index');
        
        // Módulos
        Route::get('/modulos', [App\Http\Controllers\Admin\EstruturaController::class, 'modulos'])->name('modulos');
        Route::get('/modulos/create', [App\Http\Controllers\Admin\EstruturaController::class, 'moduloCreate'])->name('modulo.create');
        Route::post('/modulos', [App\Http\Controllers\Admin\EstruturaController::class, 'moduloStore'])->name('modulo.store');
        Route::get('/modulos/{id}/edit', [App\Http\Controllers\Admin\EstruturaController::class, 'moduloEdit'])->name('modulo.edit');
        Route::put('/modulos/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'moduloUpdate'])->name('modulo.update');
        Route::delete('/modulos/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'moduloDestroy'])->name('modulo.destroy');
        
        // Capítulos
        Route::get('/capitulos/{modulo_id?}', [App\Http\Controllers\Admin\EstruturaController::class, 'capitulos'])->name('capitulos');
        Route::get('/capitulos/create/{modulo_id?}', [App\Http\Controllers\Admin\EstruturaController::class, 'capituloCreate'])->name('capitulo.create');
        Route::post('/capitulos', [App\Http\Controllers\Admin\EstruturaController::class, 'capituloStore'])->name('capitulo.store');
        Route::get('/capitulos/{id}/edit', [App\Http\Controllers\Admin\EstruturaController::class, 'capituloEdit'])->name('capitulo.edit');
        Route::put('/capitulos/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'capituloUpdate'])->name('capitulo.update');
        Route::delete('/capitulos/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'capituloDestroy'])->name('capitulo.destroy');
        
        // Actividades
        Route::get('/actividades/{capitulo_id?}', [App\Http\Controllers\Admin\EstruturaController::class, 'actividades'])->name('actividades');
        Route::get('/actividades/create/{capitulo_id?}', [App\Http\Controllers\Admin\EstruturaController::class, 'actividadeCreate'])->name('actividade.create');
        Route::post('/actividades', [App\Http\Controllers\Admin\EstruturaController::class, 'actividadeStore'])->name('actividade.store');
        Route::get('/actividades/{id}/edit', [App\Http\Controllers\Admin\EstruturaController::class, 'actividadeEdit'])->name('actividade.edit');
        Route::put('/actividades/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'actividadeUpdate'])->name('actividade.update');
        Route::delete('/actividades/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'actividadeDestroy'])->name('actividade.destroy');
        
        // Grupos
        Route::get('/grupos/{actividade_id?}', [App\Http\Controllers\Admin\EstruturaController::class, 'grupos'])->name('grupos');
        Route::get('/grupos/create/{actividade_id?}', [App\Http\Controllers\Admin\EstruturaController::class, 'grupoCreate'])->name('grupo.create');
        Route::post('/grupos', [App\Http\Controllers\Admin\EstruturaController::class, 'grupoStore'])->name('grupo.store');
        Route::get('/grupos/{id}/edit', [App\Http\Controllers\Admin\EstruturaController::class, 'grupoEdit'])->name('grupo.edit');
        Route::put('/grupos/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'grupoUpdate'])->name('grupo.update');
        Route::delete('/grupos/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'grupoDestroy'])->name('grupo.destroy');
        
        // Componentes - Rotas separadas para evitar problemas de parâmetros
        Route::get('/componentes/por-grupo/{grupo_id}', [App\Http\Controllers\Admin\EstruturaController::class, 'componentesPorGrupo'])->name('componentes.por-grupo');
        Route::get('/componentes/por-actividade/{actividade_id}', [App\Http\Controllers\Admin\EstruturaController::class, 'componentesPorActividade'])->name('componentes.por-actividade');
        Route::get('/componentes/todos', [App\Http\Controllers\Admin\EstruturaController::class, 'componentesTodos'])->name('componentes.todos');
        
        // CRUD de Componentes
        Route::get('/componentes/create/{grupo_id?}/{actividade_id?}', [App\Http\Controllers\Admin\EstruturaController::class, 'componenteCreate'])->name('componente.create');
        Route::post('/componentes', [App\Http\Controllers\Admin\EstruturaController::class, 'componenteStore'])->name('componente.store');
        Route::get('/componentes/{id}/edit', [App\Http\Controllers\Admin\EstruturaController::class, 'componenteEdit'])->name('componente.edit');
        Route::put('/componentes/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'componenteUpdate'])->name('componente.update');
        Route::delete('/componentes/{id}', [App\Http\Controllers\Admin\EstruturaController::class, 'componenteDestroy'])->name('componente.destroy');
    });

    // ==================== ORÇAMENTOS (VIA PROJETO) ====================
    Route::prefix('projetos/{projeto}/orcamentos')->name('orcamentos.')->group(function () {
        Route::get('/gerar', [OrcamentoController::class, 'gerar'])->name('gerar');
        Route::post('/salvar', [OrcamentoController::class, 'salvar'])->name('salvar');
        Route::get('/{orcamento}', [OrcamentoController::class, 'show'])->name('show');
        Route::get('/{orcamento}/pdf', [OrcamentoController::class, 'exportPdf'])->name('pdf');
        Route::get('/{orcamento}/excel', [OrcamentoController::class, 'exportExcel'])->name('excel');
    });

    // ==================== ORÇAMENTOS (GERAL) ====================
    Route::prefix('orcamentos')->name('orcamentos.')->group(function () {
        Route::get('/', [OrcamentoController::class, 'index'])->name('index');
        Route::get('/{id}', [OrcamentoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [OrcamentoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [OrcamentoController::class, 'update'])->name('update');
        Route::post('/{id}/calcular', [OrcamentoController::class, 'calcular'])->name('calcular');
        Route::post('/{id}/status', [OrcamentoController::class, 'alterarStatus'])->name('status');
        Route::get('/{id}/pdf', [OrcamentoController::class, 'exportarPdf'])->name('pdf');
        Route::get('/{id}/excel', [OrcamentoController::class, 'exportarExcel'])->name('excel');
    });

    // ==================== ORÇAMENTOS - GERENCIAR ATIVIDADES ====================
    Route::prefix('orcamentos/{orcamento}/atividades')->name('orcamentos.atividades.')->group(function () {
        Route::get('/', [OrcamentoAtividadeController::class, 'index'])->name('index');
        Route::post('/', [OrcamentoAtividadeController::class, 'store'])->name('store');
        Route::delete('/{atividadeId}', [OrcamentoAtividadeController::class, 'destroy'])->name('destroy');
    });

    // ==================== TEMPLATES ====================
    Route::prefix('templates')->name('templates.')->group(function () {
        Route::get('/', [TemplateOrcamentoController::class, 'index'])->name('index');
        Route::get('/create', [TemplateOrcamentoController::class, 'create'])->name('create');
        Route::post('/', [TemplateOrcamentoController::class, 'store'])->name('store');
        Route::get('/{id}', [TemplateOrcamentoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [TemplateOrcamentoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TemplateOrcamentoController::class, 'update'])->name('update');
        Route::delete('/{id}', [TemplateOrcamentoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/aplicar', [TemplateOrcamentoController::class, 'aplicar'])->name('aplicar');
    });

    // ==================== ITENS DE ORÇAMENTO ====================
    Route::prefix('itens-orcamento')->name('itens-orcamento.')->group(function () {
        Route::get('/list/{categoria_id?}', [ItemOrcamentoController::class, 'list'])->name('list');
        Route::get('/create/{categoria_id}', [ItemOrcamentoController::class, 'create'])->name('create');
        Route::post('/store', [ItemOrcamentoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ItemOrcamentoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ItemOrcamentoController::class, 'update'])->name('update');
        Route::delete('/{id}', [ItemOrcamentoController::class, 'destroy'])->name('destroy');
        Route::post('/calcular', [ItemOrcamentoController::class, 'calcular'])->name('calcular');
        Route::get('/{id}/duplicate', [ItemOrcamentoController::class, 'duplicate'])->name('duplicate');
        Route::get('/export/{categoria_id}', [ItemOrcamentoController::class, 'export'])->name('export');
    });

    // ==================== PDF REPORTS ====================
    Route::prefix('pdf')->name('pdf.')->group(function () {
        Route::get('/summary', [PdfController::class, 'summary'])->name('summary');
        Route::get('/categoria/{id}', [PdfController::class, 'categoria'])->name('categoria');
        Route::get('/item/{id}', [PdfController::class, 'item'])->name('item');
    });

    // ==================== CONFIGURAÇÕES ====================
    Route::prefix('configuracoes')->name('configuracoes.')->group(function () {
        Route::get('/', [ConfiguracaoController::class, 'index'])->name('index');
        Route::get('/index', [ConfiguracaoController::class, 'index'])->name('index.alt');
        Route::post('/update', [ConfiguracaoController::class, 'update'])->name('update');
    });

    // ==================== ATIVIDADES ====================
    Route::prefix('atividades')->name('atividades.')->group(function () {
        Route::get('/list', [AtividadeController::class, 'index'])->name('index');
        Route::get('/create', [AtividadeController::class, 'create'])->name('create');
        Route::post('/store', [AtividadeController::class, 'store'])->name('store');
        Route::get('/{atividade}/edit', [AtividadeController::class, 'edit'])->name('edit');
        Route::put('/{atividade}', [AtividadeController::class, 'update'])->name('update');
        Route::delete('/{atividade}', [AtividadeController::class, 'destroy'])->name('destroy');
        Route::get('/{atividade}', [AtividadeController::class, 'show'])->name('show');
    });

    // ==================== SUBATIVIDADES ====================
    Route::prefix('subatividades')->name('subatividades.')->group(function () {
        Route::get('/list', [SubatividadeController::class, 'index'])->name('index');
        Route::get('/create', [SubatividadeController::class, 'create'])->name('create');
        Route::post('/store', [SubatividadeController::class, 'store'])->name('store');
        Route::post('/calcular', [SubatividadeController::class, 'calcular'])->name('calcular');
        Route::get('/{subatividade}/edit', [SubatividadeController::class, 'edit'])->name('edit');
        Route::put('/{subatividade}', [SubatividadeController::class, 'update'])->name('update');
        Route::delete('/{subatividade}', [SubatividadeController::class, 'destroy'])->name('destroy');
        Route::get('/{subatividade}', [SubatividadeController::class, 'show'])->name('show');
    });

    // ==================== COMPOSIÇÃO DE CUSTOS ====================
    Route::prefix('composicoes')->name('composicoes.')->group(function () {
        Route::get('/list', [ComposicaoCustoController::class, 'index'])->name('index');
        Route::get('/create', [ComposicaoCustoController::class, 'create'])->name('create');
        Route::post('/store', [ComposicaoCustoController::class, 'store'])->name('store');
        Route::get('/material/{id}', [ComposicaoCustoController::class, 'getMaterialData'])->name('material-data');
        Route::get('/{composicao}/edit', [ComposicaoCustoController::class, 'edit'])->name('edit');
        Route::put('/{composicao}', [ComposicaoCustoController::class, 'update'])->name('update');
        Route::delete('/{composicao}', [ComposicaoCustoController::class, 'destroy'])->name('destroy');
    });

    // ==================== PREÇOS ====================
    Route::prefix('precos')->name('precos.')->group(function () {
        Route::get('/list', [PrecoMaterialController::class, 'list'])->name('list');
        Route::get('/dashboard', [PrecoMaterialController::class, 'dashboard'])->name('dashboard');
        Route::get('/create', [PrecoMaterialController::class, 'create'])->name('create');
        Route::post('/store', [PrecoMaterialController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PrecoMaterialController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PrecoMaterialController::class, 'update'])->name('update');
        Route::delete('/{id}', [PrecoMaterialController::class, 'destroy'])->name('destroy');
        Route::post('/ajax/store', [PrecoMaterialController::class, 'storeAjax'])->name('store-ajax');
    });
    
    // ==================== DISPENSAS ====================
    Route::delete('/dispensas/{id}', [DispensaController::class, 'delete'])->name('dispensas.delete');
    Route::put('/dispensas/{id}', [DispensaController::class, 'update'])->name('dispensas.update');
    Route::get('/dispensas/{id}/edit', [DispensaController::class, 'edit'])->name('dispensas.edit');
    Route::get('/dispensas/list', [DispensaController::class, 'list'])->name('dispensas.list');
    Route::get('/dispensas/create', [DispensaController::class, 'create'])->name('dispensas.create');
    Route::post('/dispensas', [DispensaController::class, 'store'])->name('dispensas.store');
    Route::get('/dispensas/{id}', [DispensaController::class, 'show'])->name('dispensas.show');

    // ==================== SUMMARY ====================
    Route::get('/summary', [SummaryController::class, 'index'])->name('summary.index');
    Route::get('/summary/pdf', [SummaryController::class, 'exportPdf'])->name('summary.pdf');
    Route::get('/summary/excel', [SummaryController::class, 'exportExcel'])->name('summary.excel');
});

// ==================== ROTAS PÚBLICAS ====================
Route::get('/', function () {
    return view('auth/login');
});

// ==================== ROTA HOME (DASHBOARD) ====================
Route::get('/home', [DashboardController::class, 'recuperar'])->name('recuperar')->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'recuperar'])->name('dashboard')->middleware('auth');