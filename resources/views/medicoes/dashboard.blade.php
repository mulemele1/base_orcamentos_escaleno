{{-- resources/views/medicoes/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Medição - ' . $projeto->nome)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>
                <i class="fas fa-ruler-combined text-primary mr-2"></i>
                Medição: {{ $projeto->nome }}
            </h1>
            <small class="text-muted">Registre as medições físicas do projeto</small>
        </div>
        <div>
            <a href="{{ route('projetos.show', $projeto) }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            @if($componentesMedidos == $totalComponentes && $totalComponentes > 0)
                <form action="{{ route('medicoes.finalizar', $projeto) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success" onclick="return confirm('Todas as medições foram realizadas?')">
                        <i class="fas fa-check-circle"></i> Finalizar Medição
                    </button>
                </form>
            @endif
        </div>
    </div>
    
    {{-- Progresso --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-progress"></i> Progresso da Medição
            </h3>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                             style="width: {{ $progresso }}%">
                            {{ $progresso }}%
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <span class="badge badge-primary badge-lg p-2">
                        <i class="fas fa-check-circle"></i> {{ $componentesMedidos }}/{{ $totalComponentes }} componentes medidos
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Árvore Hierárquica --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sitemap"></i> Estrutura do Projeto
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="tree-view">
                @foreach($estrutura as $modulo)
                    <div class="modulo mb-3">
                        <div class="modulo-header bg-light p-2 rounded" style="cursor: pointer;" onclick="toggleModulo(this)">
                            <i class="fas fa-folder-open text-primary mr-2"></i>
                            <strong>{{ $modulo->nome }}</strong>
                            <span class="badge badge-info float-right">
                                <i class="fas fa-chart-line"></i> 
                                {{ $modulo->capitulos->sum(function($c) { 
                                    return $c->actividades->sum(function($a) { 
                                        return $a->componentes->count() + $a->grupos->sum(function($g) { 
                                            return $g->componentes->count(); 
                                        }); 
                                    }); 
                                }) }} componentes
                            </span>
                        </div>
                        <div class="modulo-content ml-4 mt-2" style="display: block;">
                            @foreach($modulo->capitulos as $capitulo)
                                <div class="capitulo mb-2">
                                    <div class="capitulo-header text-muted" style="cursor: pointer;" onclick="toggleCapitulo(this)">
                                        <i class="fas fa-book mr-2"></i>
                                        <strong>{{ $capitulo->nome }}</strong>
                                        <span class="badge badge-secondary float-right">
                                            {{ $capitulo->actividades->sum(function($a) { 
                                                return $a->componentes->count() + $a->grupos->sum(function($g) { 
                                                    return $g->componentes->count(); 
                                                }); 
                                            }) }} itens
                                        </span>
                                    </div>
                                    <div class="capitulo-content ml-4 mt-1" style="display: block;">
                                        @foreach($capitulo->actividades as $actividade)
                                            <div class="actividade mb-2">
                                                <div class="actividade-header text-info" style="cursor: pointer;" onclick="toggleActividade(this)">
                                                    <i class="fas fa-tasks mr-2"></i>
                                                    <strong>{{ Str::limit($actividade->nome, 80) }}</strong>
                                                    <span class="badge badge-light float-right">
                                                        {{ $actividade->componentes->count() + $actividade->grupos->sum(function($g) { 
                                                            return $g->componentes->count(); 
                                                        }) }} componentes
                                                    </span>
                                                </div>
                                                <div class="actividade-content ml-4 mt-1" style="display: block;">
                                                    
                                                    @if($actividade->grupos->isNotEmpty())
                                                        @foreach($actividade->grupos as $grupo)
                                                            <div class="grupo mb-2">
                                                                <div class="grupo-header" style="cursor: pointer;" onclick="toggleGrupo(this)">
                                                                    <i class="fas fa-layer-group text-warning mr-2"></i>
                                                                    <strong>{{ $grupo->nome }}</strong>
                                                                    <span class="badge badge-secondary float-right">
                                                                        {{ $grupo->componentes->count() }} componentes
                                                                    </span>
                                                                </div>
                                                                <div class="grupo-content ml-4 mt-1" style="display: block;">
                                                                    @foreach($grupo->componentes as $componente)
                                                                        @php
                                                                            $medicao = $medicoesPorComponente->get($componente->id) ? $medicoesPorComponente->get($componente->id)->first() : null;
                                                                        @endphp
                                                                        @include('medicoes.partials.componente-item', [
                                                                            'componente' => $componente,
                                                                            'medicao' => $medicao,
                                                                            'projeto' => $projeto
                                                                        ])
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach($actividade->componentes as $componente)
                                                        @php
                                                            $medicao = $medicoesPorComponente->get($componente->id) ? $medicoesPorComponente->get($componente->id)->first() : null;
                                                        @endphp
                                                        @include('medicoes.partials.componente-item', [
                                                            'componente' => $componente,
                                                            'medicao' => $medicao,
                                                            'projeto' => $projeto
                                                        ])
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .tree-view {
        max-height: 70vh;
        overflow-y: auto;
    }
    .modulo-header, .capitulo-header, .actividade-header, .grupo-header {
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .modulo-header:hover, .capitulo-header:hover, .actividade-header:hover, .grupo-header:hover {
        background-color: #f8f9fa;
    }
    .componente-item {
        padding: 8px 12px;
        border-left: 3px solid #dee2e6;
        margin-bottom: 5px;
        transition: all 0.2s;
        background: white;
        border-radius: 4px;
    }
    .componente-item:hover {
        background-color: #fef9e6;
        border-left-color: #ffc107;
    }
    .componente-medido {
        border-left-color: #28a745;
        background-color: #e8f5e9;
    }
    .badge-lg {
        font-size: 14px;
        padding: 8px 15px;
    }
</style>
@endsection

@section('js')
<script>
    function toggleModulo(element) {
        const content = element.nextElementSibling;
        const icon = element.querySelector('.fas');
        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.classList.remove('fa-folder');
            icon.classList.add('fa-folder-open');
        } else {
            content.style.display = 'none';
            icon.classList.remove('fa-folder-open');
            icon.classList.add('fa-folder');
        }
    }
    
    function toggleCapitulo(element) {
        const content = element.nextElementSibling;
        const icon = element.querySelector('.fas');
        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.classList.remove('fa-book');
            icon.classList.add('fa-book-open');
        } else {
            content.style.display = 'none';
            icon.classList.remove('fa-book-open');
            icon.classList.add('fa-book');
        }
    }
    
    function toggleActividade(element) {
        const content = element.nextElementSibling;
        if (content.style.display === 'none') {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }
    }
    
    function toggleGrupo(element) {
        const content = element.nextElementSibling;
        if (content.style.display === 'none') {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }
    }
</script>
@endsection