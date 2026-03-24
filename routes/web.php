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

    TemplateOrcamentoController,
    OrcamentoAtividadeController,
    OrcamentoController,
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
// Desabilitar as rotas de login padrão do Laravel e criar manualmente
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');
    
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        
        // Redireciona para a página de progresso
        return redirect()->route('progresso');
    }
    
    return back()->withErrors([
        'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
    ])->onlyInput('email');
})->name('login');

// Logout personalizado
Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Registro (se não precisar, pode remover)
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

// ==================== CADASTROS (AUTENTICADOS) ====================
Route::middleware(['auth'])->group(function () {
    
    // Users
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users/list', [UserController::class, 'list'])->name('users.list');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    // Clientes
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::get('/clientes/list', [ClienteController::class, 'list'])->name('clientes.list');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');

    // FORNECEDORES
    Route::prefix('fornecedores')->name('fornecedores.')->group(function () {
        Route::get('/list', [FornecedorController::class, 'list'])->name('list');
        Route::get('/create', [FornecedorController::class, 'create'])->name('create');
        Route::post('/store', [FornecedorController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [FornecedorController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FornecedorController::class, 'update'])->name('update');
        Route::delete('/{id}', [FornecedorController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [FornecedorController::class, 'show'])->name('show');
    });

    // CATEGORIAS DE OBRA
    Route::prefix('categorias-obra')->name('categorias-obra.')->group(function () {
        Route::get('/list', [CategoriaObraController::class, 'list'])->name('list');
        Route::get('/create', [CategoriaObraController::class, 'create'])->name('create');
        Route::post('/store', [CategoriaObraController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoriaObraController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoriaObraController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoriaObraController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [CategoriaObraController::class, 'show'])->name('show');
    });

    // MATERIAIS
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

    // PROJETOS
    Route::prefix('projetos')->name('projetos.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProjetoController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\ProjetoController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\ProjetoController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\ProjetoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\ProjetoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\ProjetoController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\ProjetoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/nova-versao', [App\Http\Controllers\ProjetoController::class, 'novaVersao'])->name('nova-versao');
    });

    // ORÇAMENTOS
    Route::prefix('orcamentos')->name('orcamentos.')->group(function () {
        Route::get('/', [App\Http\Controllers\OrcamentoController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\OrcamentoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\OrcamentoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\OrcamentoController::class, 'update'])->name('update');
        Route::post('/{id}/calcular', [App\Http\Controllers\OrcamentoController::class, 'calcular'])->name('calcular');
        Route::post('/{id}/status', [App\Http\Controllers\OrcamentoController::class, 'alterarStatus'])->name('status');
        Route::get('/{id}/pdf', [App\Http\Controllers\OrcamentoController::class, 'exportarPdf'])->name('pdf');
        Route::get('/{id}/excel', [App\Http\Controllers\OrcamentoController::class, 'exportarExcel'])->name('excel');
    });

    // ORÇAMENTOS - GERENCIAR ATIVIDADES
    Route::prefix('orcamentos/{orcamento}/atividades')->name('orcamentos.atividades.')->group(function () {
        Route::get('/', [OrcamentoAtividadeController::class, 'index'])->name('index');
        Route::post('/', [OrcamentoAtividadeController::class, 'store'])->name('store');
        Route::delete('/{atividadeId}', [OrcamentoAtividadeController::class, 'destroy'])->name('destroy');
    });

    // TEMPLATES
    Route::prefix('templates')->name('templates.')->middleware('auth')->group(function () {
        Route::get('/', [TemplateOrcamentoController::class, 'index'])->name('index');
        Route::get('/create', [TemplateOrcamentoController::class, 'create'])->name('create');
        Route::post('/', [TemplateOrcamentoController::class, 'store'])->name('store');
        Route::get('/{id}', [TemplateOrcamentoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [TemplateOrcamentoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TemplateOrcamentoController::class, 'update'])->name('update');
        Route::delete('/{id}', [TemplateOrcamentoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/aplicar', [TemplateOrcamentoController::class, 'aplicar'])->name('aplicar');
    });

    // ITENS DE ORÇAMENTO
    Route::prefix('itens-orcamento')->name('itens-orcamento.')->middleware(['auth'])->group(function () {
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

    // PDF REPORTS
    Route::prefix('pdf')->name('pdf.')->middleware(['auth'])->group(function () {
        Route::get('/summary', [PdfController::class, 'summary'])->name('summary');
        Route::get('/categoria/{id}', [PdfController::class, 'categoria'])->name('categoria');
        Route::get('/item/{id}', [PdfController::class, 'item'])->name('item');
    });

    // CONFIGURAÇAO
    Route::prefix('configuracoes')->name('configuracoes.')->group(function () {
        Route::get('/', [ConfiguracaoController::class, 'index'])->name('index');
        Route::get('/index', [ConfiguracaoController::class, 'index'])->name('index.alt');
        Route::post('/update', [ConfiguracaoController::class, 'update'])->name('update');
    });

    // ATIVIDADES
    Route::prefix('atividades')->name('atividades.')->group(function () {
        Route::get('/list', [AtividadeController::class, 'index'])->name('index');
        Route::get('/create', [AtividadeController::class, 'create'])->name('create');
        Route::post('/store', [AtividadeController::class, 'store'])->name('store');
        Route::get('/{atividade}/edit', [AtividadeController::class, 'edit'])->name('edit');
        Route::put('/{atividade}', [AtividadeController::class, 'update'])->name('update');
        Route::delete('/{atividade}', [AtividadeController::class, 'destroy'])->name('destroy');
        Route::get('/{atividade}', [AtividadeController::class, 'show'])->name('show');
    });

    // SUBATIVIDADES (ITENS)
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

    // COMPOSIÇÃO DE CUSTOS (MATERIAIS)
    Route::prefix('composicoes')->name('composicoes.')->group(function () {
        Route::get('/list', [ComposicaoCustoController::class, 'index'])->name('index');
        Route::get('/create', [ComposicaoCustoController::class, 'create'])->name('create');
        Route::post('/store', [ComposicaoCustoController::class, 'store'])->name('store');
        Route::get('/material/{id}', [ComposicaoCustoController::class, 'getMaterialData'])->name('material-data');
        Route::get('/{composicao}/edit', [ComposicaoCustoController::class, 'edit'])->name('edit');
        Route::put('/{composicao}', [ComposicaoCustoController::class, 'update'])->name('update');
        Route::delete('/{composicao}', [ComposicaoCustoController::class, 'destroy'])->name('destroy');
    });

    // PREÇOS
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
    
    Route::delete('/dispensas/{id}', [DispensaController::class, 'delete'])->name('dispensas.delete');
    Route::put('/dispensas/{id}', [DispensaController::class, 'update'])->name('dispensas.update');
    Route::get('/dispensas/{id}/edit', [DispensaController::class, 'edit'])->name('dispensas.edit');
    Route::get('/dispensas/list', [DispensaController::class, 'list'])->name('dispensas.list');
    Route::get('/dispensas/create', [DispensaController::class, 'create'])->name('dispensas.create');
    Route::post('/dispensas', [DispensaController::class, 'store'])->name('dispensas.store');
    Route::get('/dispensas/{id}', [DispensaController::class, 'show'])->name('dispensas.show');

    // SUMMARY (RESUMO DO ORÇAMENTO)
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