@extends('adminlte::page')

@section('title', 'Template: ' . $template->nome)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-copy mr-2"></i>Template: {{ $template->nome }}</h1>
        <div>
            @if($template->user_id == auth()->id() || auth()->user()->is_admin)
                <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endif
            <a href="{{ route('templates.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Informações do Template</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="150">Nome:</th>
                            <td>{{ $template->nome }}</td>
                        </tr>
                        <tr>
                            <th>Tipo:</th>
                            <td>
                                @if($template->tipo_projeto)
                                    <span class="badge bg-info">{{ $template->tipo_projeto }}</span>
                                @else
                                    <span class="badge bg-secondary">Geral</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Descrição:</th>
                            <td>{{ $template->descricao ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Criado por:</th>
                            <td>{{ $template->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Público:</th>
                            <td>
                                @if($template->publico)
                                    <span class="badge bg-success"><i class="fas fa-globe"></i> Sim</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-lock"></i> Não</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Configurações:</th>
                            <td>
                                IVA: {{ $template->configuracoes['iva'] ?? 16 }}%<br>
                                Contingência: {{ $template->configuracoes['contingencia'] ?? 8 }}%
                            </td>
                        </tr>
                        <tr>
                            <th>Criado em:</th>
                            <td>{{ $template->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Resumo da Estrutura</h3>
                </div>
                <div class="card-body">
                    @php
                        $totalAtividades = count($template->estrutura['atividades'] ?? []);
                        $totalSubatividades = 0;
                        $totalComposicoes = 0;
                        
                        if(isset($template->estrutura['atividades'])) {
                            foreach($template->estrutura['atividades'] as $atividade) {
                                $totalSubatividades += count($atividade['subatividades'] ?? []);
                                foreach($atividade['subatividades'] ?? [] as $sub) {
                                    $totalComposicoes += count($sub['composicoes'] ?? []);
                                }
                            }
                        }
                    @endphp
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-tasks"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Atividades</span>
                                    <span class="info-box-number">{{ $totalAtividades }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-list-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Subatividades</span>
                                    <span class="info-box-number">{{ $totalSubatividades }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-cubes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Materiais</span>
                                    <span class="info-box-number">{{ $totalComposicoes }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estrutura do Template</h3>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="accordionTemplate">
                        @if(isset($template->estrutura['atividades']))
                            @foreach($template->estrutura['atividades'] as $index => $atividade)
                                <div class="card">
                                    <div class="card-header" id="heading{{ $index }}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                                                <i class="fas fa-tasks mr-2"></i>
                                                <strong>{{ $atividade['codigo'] }}</strong> - {{ $atividade['nome'] }}
                                                <span class="badge bg-info float-right">{{ count($atividade['subatividades'] ?? []) }} subatividades</span>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-parent="#accordionTemplate">
                                        <div class="card-body p-0">
                                            <table class="table table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th width="80">Código</th>
                                                        <th>Subatividade</th>
                                                        <th width="100">Unidade</th>
                                                        <th width="100">Quantidade</th>
                                                        <th width="120">Materiais</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($atividade['subatividades'] ?? [] as $sub)
                                                        <tr>
                                                            <td><span class="badge bg-secondary">{{ $sub['codigo'] }}</span></td>
                                                            <td>{{ $sub['nome'] }}</td>
                                                            <td>{{ $sub['unidade'] }}</td>
                                                            <td>{{ number_format($sub['quantidade_proposta'], 2, ',', '.') }}</td>
                                                            <td>
                                                                <span class="badge bg-success">{{ count($sub['composicoes'] ?? []) }} materiais</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop