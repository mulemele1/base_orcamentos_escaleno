@extends('adminlte::page')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>Editar Projeto: {{ $projeto->nome }}</h1>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('projetos.update', $projeto->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome do Projeto *</label>
                            <input type="text" name="nome" id="nome" 
                                class="form-control @error('nome') is-invalid @enderror" 
                                value="{{ old('nome', $projeto->nome) }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cliente">Cliente *</label>
                            <input type="text" name="cliente" id="cliente" 
                                class="form-control @error('cliente') is-invalid @enderror" 
                                value="{{ old('cliente', $projeto->cliente) }}" required>
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
                            <input type="text" name="localizacao" id="localizacao" 
                                class="form-control @error('localizacao') is-invalid @enderror" 
                                value="{{ old('localizacao', $projeto->localizacao) }}" required>
                            @error('localizacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_inicio">Data de Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" 
                                class="form-control" 
                                value="{{ old('data_inicio', $projeto->data_inicio ? $projeto->data_inicio->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_fim">Data de Fim</label>
                            <input type="date" name="data_fim" id="data_fim" 
                                class="form-control" 
                                value="{{ old('data_fim', $projeto->data_fim ? $projeto->data_fim->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="planeamento" {{ old('status', $projeto->status) == 'planeamento' ? 'selected' : '' }}>Em Planeamento</option>
                                <option value="em_andamento" {{ old('status', $projeto->status) == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                <option value="concluido" {{ old('status', $projeto->status) == 'concluido' ? 'selected' : '' }}>Concluído</option>
                                <option value="suspenso" {{ old('status', $projeto->status) == 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Atualizar Projeto</button>
                    <a href="{{ route('projetos.show', $projeto->id) }}" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop