{{-- resources/views/medicoes/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Adicionar Medição - ' . $projeto->nome)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle"></i> Adicionar Medição
                    </h3>
                </div>
                <div class="card-body">
                    @if($componente)
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-info-circle"></i> Localização:</strong><br>
                                    @if($componente->grupo)
                                        Módulo: {{ $componente->grupo->actividade->capitulo->modulo->nome }}<br>
                                        Capítulo: {{ $componente->grupo->actividade->capitulo->nome }}<br>
                                        Actividade: {{ $componente->grupo->actividade->nome }}<br>
                                        Grupo: {{ $componente->grupo->nome }}
                                    @else
                                        Módulo: {{ $componente->actividade->capitulo->modulo->nome }}<br>
                                        Capítulo: {{ $componente->actividade->capitulo->nome }}<br>
                                        Actividade: {{ $componente->actividade->nome }}
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-calculator"></i> Informações do Componente:</strong><br>
                                    Nome: {{ $componente->nome }}<br>
                                    Unidade: {{ $componente->unidade }}<br>
                                    Fórmula: 
                                    @switch($componente->formula_calculo)
                                        @case('volume')
                                            NPI × C × L × H
                                            @break
                                        @case('area')
                                            NPI × C × L
                                            @break
                                        @case('area_parede')
                                            NPI × C × H
                                            @break
                                        @case('area_lateral')
                                            NPI × L × H
                                            @break
                                        @case('comprimento')
                                            NPI × C
                                            @break
                                        @case('valor_fixo')
                                            NPI × H (kg por unidade)
                                            @break
                                    @endswitch
                                    <br>
                                    Perda padrão: {{ $componente->perda_padrao }}%
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ route('medicoes.store', $projeto) }}" method="POST" enctype="multipart/form-data" id="form-medicao">
                        @csrf
                        
                        @if(!$componente)
                            <div class="form-group">
                                <label for="componente_id">Componente <span class="text-danger">*</span></label>
                                <select name="componente_id" id="componente_id" class="form-control" required>
                                    <option value="">Selecione o componente...</option>
                                    @foreach(\App\Models\Componente::with(['grupo.actividade.capitulo.modulo', 'actividade.capitulo.modulo'])->orderBy('nome')->get() as $comp)
                                        <option value="{{ $comp->id }}" {{ old('componente_id') == $comp->id ? 'selected' : '' }}>
                                            {{ $comp->grupo?->actividade->capitulo->modulo->nome ?? $comp->actividade->capitulo->modulo->nome }} / 
                                            {{ $comp->grupo?->actividade->capitulo->nome ?? $comp->actividade->capitulo->nome }} / 
                                            {{ $comp->grupo?->nome ? $comp->grupo->nome . ' / ' : '' }}{{ $comp->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="componente_id" value="{{ $componente->id }}">
                        @endif
                        
                        <div class="form-group">
                            <label>Origem da Medição <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input type="radio" name="origem" value="desenho" id="origem_desenho" class="form-check-input" 
                                       {{ old('origem', 'desenho') == 'desenho' ? 'checked' : '' }}>
                                <label for="origem_desenho" class="form-check-label">
                                    <i class="fas fa-drafting-compass"></i> Desenho/Planta
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="origem" value="campo" id="origem_campo" class="form-check-input"
                                       {{ old('origem') == 'campo' ? 'checked' : '' }}>
                                <label for="origem_campo" class="form-check-label">
                                    <i class="fas fa-hard-hat"></i> Medição em Campo
                                </label>
                            </div>
                        </div>
                        
                        <div id="campos_desenho" class="campos-origem" style="{{ old('origem', 'desenho') == 'desenho' ? 'display:block' : 'display:none' }}">
                            <div class="form-group">
                                <label for="prancha">Número da Prancha/Desenho</label>
                                <input type="text" name="prancha" id="prancha" class="form-control" value="{{ old('prancha') }}" placeholder="Ex: E-01, ARQ-02">
                            </div>
                        </div>
                        
                        <div id="campos_campo" class="campos-origem" style="{{ old('origem') == 'campo' ? 'display:block' : 'display:none' }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_medicao">Data da Medição</label>
                                        <input type="date" name="data_medicao" id="data_medicao" class="form-control" value="{{ old('data_medicao', date('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="medido_por">Medido por</label>
                                        <input type="text" name="medido_por" id="medido_por" class="form-control" value="{{ old('medido_por', Auth::user()->name) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto da Medição</label>
                                <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                                <small class="form-text text-muted">Formatos: JPG, PNG (máx. 5MB)</small>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="npi">NPI (Nº repetições) <span class="text-danger">*</span></label>
                                    <input type="number" name="npi" id="npi" class="form-control" step="1" min="1" value="{{ old('npi', 1) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="comprimento">Comprimento (C)</label>
                                    <input type="number" name="comprimento" id="comprimento" class="form-control" step="0.01" value="{{ old('comprimento') }}" placeholder="metros">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="largura">Largura (L)</label>
                                    <input type="number" name="largura" id="largura" class="form-control" step="0.01" value="{{ old('largura') }}" placeholder="metros">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="altura">Altura/Espessura (H)</label>
                                    <input type="number" name="altura" id="altura" class="form-control" step="0.01" value="{{ old('altura') }}" placeholder="metros">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="perda">Perda (%)</label>
                                    <input type="number" name="perda" id="perda" class="form-control" step="0.5" value="{{ old('perda', $componente->perda_padrao ?? 5) }}">
                                    <small class="form-text text-muted">Deixe em branco para usar a perda padrão</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info" id="resultado-calculo">
                            <strong><i class="fas fa-calculator"></i> Cálculo:</strong><br>
                            <span id="calculo-elementar">Aguardando dados...</span>
                        </div>
                        
                        <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes" class="form-control" rows="3">{{ old('observacoes') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar Medição
                            </button>
                            <a href="{{ route('medicoes.dashboard', $projeto) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Ajuda
                    </h3>
                </div>
                <div class="card-body">
                    <h5><i class="fas fa-calculator"></i> Como funciona o cálculo?</h5>
                    <p>A quantidade é calculada automaticamente baseado na fórmula do componente:</p>
                    <ul>
                        <li><strong>Volume:</strong> NPI × C × L × H</li>
                        <li><strong>Área:</strong> NPI × C × L</li>
                        <li><strong>Área de Parede:</strong> NPI × C × H</li>
                        <li><strong>Comprimento Linear:</strong> NPI × C</li>
                        <li><strong>Valor Fixo:</strong> NPI × H (onde H é kg/unidade)</li>
                    </ul>
                    <p><strong>Perda:</strong> Aumenta a quantidade final em % para compensar desperdícios.</p>
                    <hr>
                    <h5><i class="fas fa-map-marker-alt"></i> Origem da Medição</h5>
                    <p><strong>Desenho/Planta:</strong> Medição extraída de desenhos técnicos.</p>
                    <p><strong>Campo:</strong> Medição realizada fisicamente no local da obra.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Alternar campos conforme origem
    document.querySelectorAll('input[name="origem"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const camposDesenho = document.getElementById('campos_desenho');
            const camposCampo = document.getElementById('campos_campo');
            if (this.value === 'desenho') {
                camposDesenho.style.display = 'block';
                camposCampo.style.display = 'none';
            } else {
                camposDesenho.style.display = 'none';
                camposCampo.style.display = 'block';
            }
        });
    });
    
    // Cálculo em tempo real
    const npiInput = document.getElementById('npi');
    const comprimentoInput = document.getElementById('comprimento');
    const larguraInput = document.getElementById('largura');
    const alturaInput = document.getElementById('altura');
    const perdaInput = document.getElementById('perda');
    const resultadoSpan = document.getElementById('calculo-elementar');
    
    function calcular() {
        const npi = parseFloat(npiInput.value) || 0;
        const comprimento = parseFloat(comprimentoInput.value) || 0;
        const largura = parseFloat(larguraInput.value) || 0;
        const altura = parseFloat(alturaInput.value) || 0;
        const perda = parseFloat(perdaInput.value) || 0;
        
        const componente = @json($componente);
        
        if (!componente && document.getElementById('componente_id')) {
            const select = document.getElementById('componente_id');
            if (select.value) {
                // Se tiver componente selecionado, recarregar a página com o componente
                window.location.href = '{{ route('medicoes.create', $projeto) }}?componente_id=' + select.value;
                return;
            }
            resultadoSpan.innerHTML = 'Selecione um componente para ver o cálculo...';
            return;
        }
        
        if (!componente) return;
        
        let elementar = 0;
        let formulaDesc = '';
        
        switch(componente.formula_calculo) {
            case 'volume':
                elementar = npi * comprimento * largura * altura;
                formulaDesc = `${npi} × ${comprimento} × ${largura} × ${altura}`;
                break;
            case 'area':
                elementar = npi * comprimento * largura;
                formulaDesc = `${npi} × ${comprimento} × ${largura}`;
                break;
            case 'area_parede':
                elementar = npi * comprimento * altura;
                formulaDesc = `${npi} × ${comprimento} × ${altura}`;
                break;
            case 'area_lateral':
                elementar = npi * largura * altura;
                formulaDesc = `${npi} × ${largura} × ${altura}`;
                break;
            case 'comprimento':
                elementar = npi * comprimento;
                formulaDesc = `${npi} × ${comprimento}`;
                break;
            case 'largura':
                elementar = npi * largura;
                formulaDesc = `${npi} × ${largura}`;
                break;
            case 'altura':
                elementar = npi * altura;
                formulaDesc = `${npi} × ${altura}`;
                break;
            case 'valor_fixo':
                elementar = npi * (altura > 0 ? altura : 1);
                formulaDesc = `${npi} × ${altura > 0 ? altura : 'valor padrão'}`;
                break;
            default:
                elementar = 0;
        }
        
        const quantidade = elementar * (1 + perda / 100);
        
        resultadoSpan.innerHTML = `
            <strong>Elementar:</strong> ${formulaDesc} = ${elementar.toFixed(2)} ${componente.unidade}<br>
            <strong>+ Perda (${perda}%):</strong> ${elementar.toFixed(2)} × ${(1 + perda/100).toFixed(2)} = <strong class="text-success">${quantidade.toFixed(2)} ${componente.unidade}</strong>
        `;
    }
    
    // Adicionar event listeners
    if (npiInput) npiInput.addEventListener('input', calcular);
    if (comprimentoInput) comprimentoInput.addEventListener('input', calcular);
    if (larguraInput) larguraInput.addEventListener('input', calcular);
    if (alturaInput) alturaInput.addEventListener('input', calcular);
    if (perdaInput) perdaInput.addEventListener('input', calcular);
    
    // Adicionar listener para o select de componente
    const componenteSelect = document.getElementById('componente_id');
    if (componenteSelect) {
        componenteSelect.addEventListener('change', function() {
            if (this.value) {
                window.location.href = '{{ route('medicoes.create', $projeto) }}?componente_id=' + this.value;
            }
        });
    }
    
    // Calcular ao carregar a página
    if (@json($componente)) {
        calcular();
    }
</script>
@endsection