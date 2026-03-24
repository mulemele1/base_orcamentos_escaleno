@if(isset($categoria) && $categoria->id)
<div class="section-divider">
    <span class="section-divider-label"><i class="fas fa-project-diagram mr-1"></i>Projetos Vinculados</span>
    <div class="section-divider-line"></div>
</div>

<div class="card" style="background: var(--surface); border: 1px solid var(--border); border-radius: 12px; margin-bottom: 20px;">
    <div class="card-body">
        @php
            $projetosVinculados = DB::table('orcamentos')
                ->join('orcamento_atividades', 'orcamentos.id', '=', 'orcamento_atividades.orcamento_id')
                ->join('atividades', 'orcamento_atividades.atividade_id', '=', 'atividades.id')
                ->where('atividades.categoria_obra_id', $categoria->id)
                ->select('orcamentos.id', 'orcamentos.nome_projeto', 'orcamentos.codigo')
                ->distinct()
                ->get();
        @endphp

        @if($projetosVinculados->count() > 0)
            <div class="alert alert-info mb-3">
                <i class="fas fa-info-circle"></i> Esta categoria é utilizada em {{ $projetosVinculados->count() }} projeto(s):
            </div>
            <div class="row">
                @foreach($projetosVinculados as $projeto)
                <div class="col-md-4 mb-2">
                    <a href="{{ route('projetos.show', $projeto->id) }}" class="text-decoration-none">
                        <div class="card" style="background: var(--card); border: 1px solid var(--border); transition: all 0.2s;">
                            <div class="card-body py-2 px-3">
                                <i class="fas fa-building text-primary mr-2"></i>
                                <strong>{{ $projeto->nome_projeto }}</strong>
                                <br><small class="text-muted">{{ $projeto->codigo }}</small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-secondary mb-0">
                <i class="fas fa-info-circle"></i> Esta categoria ainda não foi utilizada em nenhum projeto.
            </div>
        @endif
    </div>
</div>
@endif