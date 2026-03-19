@extends('adminlte::page')

@section('title', 'Configurações do Sistema')

@section('content_header')
    <h1><i class="fas fa-cog mr-2"></i>Configurações do Sistema</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Parâmetros Gerais</h3>
            </div>
            <form action="{{ route('configuracoes.update') }}" method="POST">
                @csrf
                <div class="card-body">
                    @foreach($grupos as $grupo)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary">{{ ucfirst($grupo) }}</h4>
                                <hr>
                            </div>
                            @foreach($configuracoes->where('grupo', $grupo) as $config)
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>{{ $config->nome }}:</label>
                                        @if($config->tipo == 'text')
                                            <input type="text" name="{{ $config->chave }}" 
                                                   value="{{ $config->valor }}" 
                                                   class="form-control">
                                        @elseif($config->tipo == 'number')
                                            <input type="number" name="{{ $config->chave }}" 
                                                   value="{{ $config->valor }}" 
                                                   class="form-control" step="0.01">
                                        @elseif($config->tipo == 'textarea')
                                            <textarea name="{{ $config->chave }}" 
                                                      class="form-control" rows="3">{{ $config->valor }}</textarea>
                                        @elseif($config->tipo == 'boolean')
                                            <select name="{{ $config->chave }}" class="form-control">
                                                <option value="1" {{ $config->valor == '1' ? 'selected' : '' }}>Sim</option>
                                                <option value="0" {{ $config->valor == '0' ? 'selected' : '' }}>Não</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar Configurações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop