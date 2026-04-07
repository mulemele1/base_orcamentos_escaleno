{{-- resources/views/medicoes/partials/componente-item.blade.php --}}
<div class="componente-item {{ $medicao ? 'componente-medido' : '' }}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center">
                @if($medicao)
                    <i class="fas fa-check-circle text-success mr-2"></i>
                @else
                    <i class="fas fa-cube text-secondary mr-2"></i>
                @endif
                <strong>{{ $componente->nome }}</strong>
                <span class="badge badge-light ml-2">
                    {{ $componente->unidade }}
                </span>
                @if($componente->formula_calculo)
                    <span class="badge badge-info ml-2">
                        <i class="fas fa-calculator"></i> 
                        @switch($componente->formula_calculo)
                            @case('volume')
                                C×L×H
                                @break
                            @case('area')
                                C×L
                                @break
                            @case('area_parede')
                                C×H
                                @break
                            @case('area_lateral')
                                L×H
                                @break
                            @case('comprimento')
                                C
                                @break
                            @case('valor_fixo')
                                Fixo
                                @break
                            @default
                                {{ $componente->formula_calculo }}
                        @endswitch
                    </span>
                @endif
                @if($componente->perda_padrao > 0)
                    <span class="badge badge-warning ml-2">
                        <i class="fas fa-percent"></i> Perda: {{ $componente->perda_padrao }}%
                    </span>
                @endif
            </div>
            @if($medicao)
                <div class="small text-muted mt-1">
                    <i class="fas fa-chart-line"></i> 
                    {{ $medicao->npi }} × 
                    @if($medicao->comprimento) {{ $medicao->comprimento }}m @endif
                    @if($medicao->largura) × {{ $medicao->largura }}m @endif
                    @if($medicao->altura) × {{ $medicao->altura }}m @endif
                    = <strong class="text-success">{{ number_format($medicao->quantidade, 2) }} {{ $componente->unidade }}</strong>
                    @if($medicao->perda > 0)
                        <span class="text-warning">(+{{ $medicao->perda }}% perda)</span>
                    @endif
                    <br>
                    <i class="fas fa-map-marker-alt"></i> Origem: {{ $medicao->origem == 'desenho' ? 'Desenho' : 'Campo' }}
                    @if($medicao->prancha)
                        | Prancha: {{ $medicao->prancha }}
                    @endif
                    @if($medicao->data_medicao)
                        | Data: {{ \Carbon\Carbon::parse($medicao->data_medicao)->format('d/m/Y') }}
                    @endif
                    @if($medicao->observacoes)
                        <br><i class="fas fa-comment"></i> {{ Str::limit($medicao->observacoes, 50) }}
                    @endif
                </div>
            @else
                <div class="small text-muted mt-1">
                    <i class="fas fa-info-circle"></i> Aguardando medição
                </div>
            @endif
        </div>
        <div class="ml-3">
            @if($medicao)
                <a href="{{ route('medicoes.edit', [$projeto, $medicao]) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <form action="{{ route('medicoes.destroy', [$projeto, $medicao]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remover esta medição?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('medicoes.create', $projeto) }}?componente_id={{ $componente->id }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Medir
                </a>
            @endif
        </div>
    </div>
</div>