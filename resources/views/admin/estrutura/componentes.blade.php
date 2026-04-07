{{-- resources/views/admin/estrutura/componentes.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
{{-- Botão Voltar --}}
<div class="mb-3">
    @if($grupo)
        <a href="{{ route('admin.estrutura.grupos', $grupo->actividade_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Grupos
        </a>
    @elseif($actividade)
        <a href="{{ route('admin.estrutura.actividades', $actividade->capitulo_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Actividades
        </a>
    @else
        <a href="{{ route('admin.estrutura.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    @endif
</div>

{{-- Card de componentes --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cube"></i> Componentes
            @if($grupo)
                <small class="text-muted">do grupo: <strong>{{ $grupo->nome }}</strong></small>
            @elseif($actividade)
                <small class="text-muted">da actividade: <strong>{{ $actividade->nome }}</strong></small>
            @endif
        </h3>
        <div class="card-tools">
            @if($grupo)
                <a href="{{ route('admin.estrutura.componente.create', ['grupo_id' => $grupo->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Novo Componente
                </a>
            @elseif($actividade)
                <a href="{{ route('admin.estrutura.componente.create', ['actividade_id' => $actividade->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Novo Componente
                </a>
            @else
                <a href="{{ route('admin.estrutura.componente.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Novo Componente
                </a>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th style="width: 50px">Ordem</th>
                        <th>Nome</th>
                        <th>Localização</th>
                        <th>Unidade</th>
                        <th>Fórmula</th>
                        <th>Perda Padrão</th>
                        <th style="width: 80px">Medições</th>
                        <th style="width: 100px">Ações</th>
                    </thead>
                <tbody>
                    @forelse($componentes as $componente)
                    60d
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $componente->ordem }}</span>
                        </td>
                        <td>
                            <strong>{{ $componente->nome }}</strong>
                            @if($componente->valor_padrao)
                                <br><small class="text-muted">Valor padrão: {{ $componente->valor_padrao }}</small>
                            @endif
                        </td>
                        <td>
                            @if($componente->grupo)
                                <span class="badge badge-warning">{{ $componente->grupo->nome }}</span>
                                <br><small class="text-muted">{{ $componente->grupo->actividade->capitulo->modulo->nome }}</small>
                            @else
                                <span class="badge badge-info">{{ Str::limit($componente->actividade->nome, 35) }}</span>
                                <br><small class="text-muted">{{ $componente->actividade->capitulo->modulo->nome }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $componente->unidade }}</span>
                        </td>
                        <td class="text-center">
                            @php
                                $formulas = [
                                    'volume' => ['label' => 'Volume', 'icon' => 'fa-cube', 'desc' => 'C × L × H'],
                                    'area' => ['label' => 'Área', 'icon' => 'fa-square', 'desc' => 'C × L'],
                                    'area_parede' => ['label' => 'Área Parede', 'icon' => 'fa-layer-group', 'desc' => 'C × H'],
                                    'area_lateral' => ['label' => 'Área Lateral', 'icon' => 'fa-chart-line', 'desc' => 'L × H'],
                                    'comprimento' => ['label' => 'Comprimento', 'icon' => 'fa-ruler', 'desc' => 'C'],
                                    'largura' => ['label' => 'Largura', 'icon' => 'fa-ruler-horizontal', 'desc' => 'L'],
                                    'altura' => ['label' => 'Altura', 'icon' => 'fa-ruler-vertical', 'desc' => 'H'],
                                    'valor_fixo' => ['label' => 'Valor Fixo', 'icon' => 'fa-hashtag', 'desc' => 'NPI × H'],
                                ];
                                $formula = $formulas[$componente->formula_calculo] ?? ['label' => $componente->formula_calculo, 'icon' => 'fa-calculator', 'desc' => ''];
                            @endphp
                            <span class="badge badge-info" title="{{ $formula['desc'] }}">
                                <i class="fas {{ $formula['icon'] }}"></i> {{ $formula['label'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $componente->perda_padrao > 0 ? 'badge-warning' : 'badge-secondary' }}">
                                {{ $componente->perda_padrao }}%
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $componente->medicoes()->count() > 0 ? 'badge-primary' : 'badge-secondary' }}">
                                {{ $componente->medicoes()->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.estrutura.componente.edit', $componente->id) }}" class="btn btn-warning" title="Editar componente">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($componente->medicoes()->count() == 0)
                                    <form action="{{ route('admin.estrutura.componente.destroy', $componente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este componente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Excluir componente">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-danger" disabled title="Não pode excluir, possui medições">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-cube fa-4x mb-3 text-muted"></i>
                            <p class="mb-2">Nenhum componente cadastrado.</p>
                            @if($grupo)
                                <a href="{{ route('admin.estrutura.componente.create', ['grupo_id' => $grupo->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Criar primeiro componente
                                </a>
                            @elseif($actividade)
                                <a href="{{ route('admin.estrutura.componente.create', ['actividade_id' => $actividade->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Criar primeiro componente
                                </a>
                            @else
                                <a href="{{ route('admin.estrutura.componente.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Criar primeiro componente
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($componentes->count() > 0)
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Total de componentes: <strong>{{ $componentes->count() }}</strong>
                    @if($componentes->sum(function($c) { return $c->medicoes()->count(); }) > 0)
                        | Total de medições: <strong>{{ $componentes->sum(function($c) { return $c->medicoes()->count(); }) }}</strong>
                    @endif
                </small>
            </div>
            <div class="col-md-6 text-right">
                <small class="text-muted">
                    <i class="fas fa-calculator"></i> 
                    Fórmulas: <strong>Volume</strong> (C×L×H) | <strong>Área</strong> (C×L) | <strong>Área Parede</strong> (C×H) | <strong>Fixo</strong> (NPI×H)
                </small>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection