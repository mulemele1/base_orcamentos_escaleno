{{-- resources/views/admin/estrutura/index.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tree"></i> Árvore Hierárquica Completa
        </h3>
    </div>
    <div class="card-body">
        <div class="tree-view">
            @foreach($modulos as $modulo)
                <div class="modulo mb-3">
                    <div class="modulo-header bg-primary text-white p-2 rounded" style="cursor: pointer;" onclick="toggleModulo(this)">
                        <i class="fas fa-folder-open mr-2"></i>
                        <strong>{{ $modulo->ordem }}. {{ $modulo->nome }}</strong>
                        <span class="badge badge-light float-right">{{ $modulo->capitulos->count() }} capítulos</span>
                    </div>
                    <div class="modulo-content ml-4 mt-2" style="display: block;">
                        @foreach($modulo->capitulos as $capitulo)
                            <div class="capitulo mb-2">
                                <div class="capitulo-header bg-secondary text-white p-2 rounded" style="cursor: pointer;" onclick="toggleCapitulo(this)">
                                    <i class="fas fa-book mr-2"></i>
                                    <strong>{{ $modulo->ordem }}.{{ $capitulo->ordem }} - {{ $capitulo->nome }}</strong>
                                    <span class="badge badge-light float-right">{{ $capitulo->actividades->count() }} actividades</span>
                                </div>
                                <div class="capitulo-content ml-4 mt-2" style="display: block;">
                                    @foreach($capitulo->actividades as $actividade)
                                        <div class="actividade mb-2">
                                            <div class="actividade-header bg-info text-white p-2 rounded" style="cursor: pointer;" onclick="toggleActividade(this)">
                                                <i class="fas fa-tasks mr-2"></i>
                                                <strong>{{ $modulo->ordem }}.{{ $capitulo->ordem }}.{{ $actividade->ordem }} - {{ Str::limit($actividade->nome, 80) }}</strong>
                                                <span class="badge badge-light float-right">
                                                    {{ $actividade->componentes->count() + $actividade->grupos->sum(fn($g) => $g->componentes->count()) }} componentes
                                                </span>
                                            </div>
                                            <div class="actividade-content ml-4 mt-2" style="display: block;">
                                                
                                                @if($actividade->grupos->isNotEmpty())
                                                    @foreach($actividade->grupos as $grupo)
                                                        <div class="grupo mb-2">
                                                            <div class="grupo-header bg-warning p-2 rounded" style="cursor: pointer;" onclick="toggleGrupo(this)">
                                                                <i class="fas fa-layer-group mr-2"></i>
                                                                <strong>{{ $modulo->ordem }}.{{ $capitulo->ordem }}.{{ $actividade->ordem }}.{{ $grupo->ordem }} - {{ $grupo->nome }}</strong>
                                                                <span class="badge badge-dark float-right">{{ $grupo->componentes->count() }} componentes</span>
                                                            </div>
                                                            <div class="grupo-content ml-4 mt-2" style="display: block;">
                                                                @foreach($grupo->componentes as $componente)
                                                                    <div class="componente p-2 mb-1 border rounded">
                                                                        <div class="d-flex justify-content-between">
                                                                            <div>
                                                                                <i class="fas fa-cube text-success mr-2"></i>
                                                                                <strong>{{ $componente->nome }}</strong>
                                                                                <span class="badge badge-secondary ml-2">{{ $componente->unidade }}</span>
                                                                                <span class="badge badge-info ml-1">{{ $componente->formula_calculo }}</span>
                                                                                @if($componente->perda_padrao > 0)
                                                                                    <span class="badge badge-warning ml-1">Perda: {{ $componente->perda_padrao }}%</span>
                                                                                @endif
                                                                            </div>
                                                                            <div>
                                                                                <a href="{{ route('admin.estrutura.componente.edit', $componente->id) }}" class="btn btn-sm btn-primary">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                
                                                @foreach($actividade->componentes as $componente)
                                                    <div class="componente p-2 mb-1 border rounded">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <i class="fas fa-cube text-success mr-2"></i>
                                                                <strong>{{ $componente->nome }}</strong>
                                                                <span class="badge badge-secondary ml-2">{{ $componente->unidade }}</span>
                                                                <span class="badge badge-info ml-1">{{ $componente->formula_calculo }}</span>
                                                                @if($componente->perda_padrao > 0)
                                                                    <span class="badge badge-warning ml-1">Perda: {{ $componente->perda_padrao }}%</span>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('admin.estrutura.componente.edit', $componente->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </div>
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
            @endforeach
        </div>
    </div>
</div>
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

@section('css')
<style>
    .tree-view {
        max-height: 80vh;
        overflow-y: auto;
    }
    .modulo-header, .capitulo-header, .actividade-header, .grupo-header {
        transition: all 0.2s;
        cursor: pointer;
    }
    .modulo-header:hover, .capitulo-header:hover, .actividade-header:hover, .grupo-header:hover {
        filter: brightness(0.95);
    }
    .componente {
        background-color: #f8f9fa;
        transition: all 0.2s;
    }
    .componente:hover {
        background-color: #e9ecef;
    }
</style>
@endsection