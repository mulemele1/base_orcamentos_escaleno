@extends('adminlte::page')

@section('title', 'Templates de Orçamento')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-copy mr-2"></i>Templates de Orçamento</h1>
        <a href="{{ route('templates.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Template
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Templates</h3>
            <div class="card-tools">
                <form method="GET" action="{{ route('templates.index') }}" class="form-inline">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar template..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Criado por</th>
                        <th>Público</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </thead>
                <tbody>
                    @forelse($templates as $template)
                      2d
                           <td><strong>{{ $template->nome }}</strong>2d
                           <td>
                              @if($template->tipo_projeto)
                                  <span class="badge bg-info">{{ $template->tipo_projeto }}</span>
                              @else
                                  <span class="badge bg-secondary">Geral</span>
                              @endif
                           </td>
                           <td>{{ Str::limit($template->descricao, 50) }}</td>
                           <td>{{ $template->user->name ?? '-' }}</td>
                           <td>
                              @if($template->publico)
                                  <span class="badge bg-success"><i class="fas fa-globe"></i> Público</span>
                              @else
                                  <span class="badge bg-secondary"><i class="fas fa-lock"></i> Privado</span>
                              @endif
                           </td>
                           <td>{{ $template->created_at->format('d/m/Y') }}</td>
                           <td>
                              <div class="btn-group">
                                  <a href="{{ route('templates.show', $template->id) }}" class="btn btn-sm btn-info" title="Visualizar">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  @if($template->user_id == auth()->id() || auth()->user()->is_admin)
                                      <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                          <i class="fas fa-edit"></i>
                                      </a>
                                      <button type="button" class="btn btn-sm btn-danger" onclick="excluirTemplate({{ $template->id }})" title="Excluir">
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  @endif
                                  <button type="button" class="btn btn-sm btn-success" onclick="aplicarTemplate({{ $template->id }}, '{{ addslashes($template->nome) }}')" title="Aplicar a Projeto">
                                      <i class="fas fa-copy"></i>
                                  </button>
                              </div>
                           </td>
                       </tr>
                    @empty
                       <tr>
                          <td colspan="7" class="text-center py-4">
                              <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                              <p>Nenhum template cadastrado.</p>
                              <a href="{{ route('templates.create') }}" class="btn btn-primary">Criar primeiro template</a>
                           </td>
                       </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $templates->links() }}
        </div>
    </div>

    <!-- Modal para Aplicar Template -->
    <div class="modal fade" id="modalAplicarTemplate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-copy"></i> Aplicar Template</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formAplicarTemplate" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Aplicar template: <strong id="templateNome"></strong></p>
                        <div class="form-group">
                            <label for="projeto_id">Selecione o Projeto *</label>
                            <select name="projeto_id" id="projeto_id" class="form-control" required>
                                <option value="">-- Selecione um projeto --</option>
                                @foreach($projetos ?? [] as $projeto)
                                    <option value="{{ $projeto->id }}">{{ $projeto->nome }} ({{ $projeto->cliente }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            O template criará um novo orçamento para o projeto selecionado.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aplicar Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
function excluirTemplate(id) {
    if (confirm('Tem certeza que deseja excluir este template?')) {
        fetch('/templates/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => {
            if (response.ok) location.reload();
            else alert('Erro ao excluir');
        });
    }
}

function aplicarTemplate(id, nome) {
    document.getElementById('templateNome').innerText = nome;
    const form = document.getElementById('formAplicarTemplate');
    form.action = '/templates/' + id + '/aplicar';
    $('#modalAplicarTemplate').modal('show');
}
</script>
@endsection