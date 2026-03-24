@extends('adminlte::page')

@section('content_header')
    <h1><i class="fas fa-plus-circle mr-2"></i>Novo Projeto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('projetos.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome do Projeto *</label>
                            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cliente">Cliente *</label>
                            <input type="text" name="cliente" id="cliente" class="form-control @error('cliente') is-invalid @enderror" value="{{ old('cliente') }}" required>
                            @error('cliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="localizacao">Localização *</label>
                            <input type="text" name="localizacao" id="localizacao" class="form-control @error('localizacao') is-invalid @enderror" value="{{ old('localizacao') }}" required>
                            @error('localizacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_inicio">Data de Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{ old('data_inicio') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_fim">Data de Fim</label>
                            <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ old('data_fim') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="template_id">Usar Template</label>
                            <select name="template_id" id="template_id" class="form-control">
                                <option value="">-- Nenhum template --</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                        {{ $template->nome }} ({{ $template->tipo_projeto }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Escolha um template para criar automaticamente a estrutura do orçamento</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="iva">IVA (%)</label>
                            <input type="number" name="iva" id="iva" class="form-control" step="0.01" value="{{ old('iva', 16) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="contingencia">Contingência (%)</label>
                            <input type="number" name="contingencia" id="contingencia" class="form-control" step="0.01" value="{{ old('contingencia', 8) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Criar Projeto</button>
                    <a href="{{ route('projetos.index') }}" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop