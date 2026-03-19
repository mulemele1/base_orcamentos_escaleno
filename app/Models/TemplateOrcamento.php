<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TemplateOrcamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'descricao', 'tipo_projeto', 'estrutura', 'user_id', 'publico'
    ];

    protected $casts = [
        'estrutura' => 'array',
        'publico' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projetos()
    {
        return $this->hasMany(Projeto::class, 'template_id');
    }

    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class, 'template_id');
    }

    /**
     * Aplicar template a um novo projeto
     */
    public function aplicarAoProjeto(Projeto $projeto, $dados = [])
    {
        DB::beginTransaction();
        try {
            // Criar orçamento
            $orcamento = new Orcamento();
            $orcamento->projeto_id = $projeto->id;
            $orcamento->template_id = $this->id;
            $orcamento->codigo = Orcamento::gerarCodigo();
            $orcamento->nome_projeto = $projeto->nome;
            $orcamento->cliente = $projeto->cliente;
            $orcamento->localizacao = $projeto->localizacao;
            $orcamento->data_emissao = now();
            $orcamento->versao = 1;
            $orcamento->status = 'rascunho';
            $orcamento->iva_percentual = $dados['iva_percentual'] ?? 16;
            $orcamento->contingencia_percentual = $dados['contingencia_percentual'] ?? 8;
            $orcamento->user_id = auth()->id();
            $orcamento->save();

            // Recriar estrutura do template
            $this->recriarEstrutura($orcamento);

            DB::commit();
            return $orcamento;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function recriarEstrutura($orcamento)
    {
        if (!$this->estrutura) return;

        foreach ($this->estrutura['categorias'] ?? [] as $categoriaData) {
            $categoria = CategoriaObra::firstOrCreate(
                ['codigo' => $categoriaData['codigo']],
                ['nome' => $categoriaData['nome'], 'ordem' => $categoriaData['ordem']]
            );

            foreach ($categoriaData['atividades'] ?? [] as $atividadeData) {
                $atividade = Atividade::create([
                    'codigo' => $atividadeData['codigo'],
                    'nome' => $atividadeData['nome'],
                    'unidade' => $atividadeData['unidade'],
                    'npi' => $atividadeData['npi'],
                    'categoria_obra_id' => $categoria->id,
                    'ordem' => $atividadeData['ordem'],
                ]);

                foreach ($atividadeData['subatividades'] ?? [] as $subData) {
                    $subatividade = Subatividade::create([
                        'codigo' => $subData['codigo'],
                        'nome' => $subData['nome'],
                        'unidade' => $subData['unidade'],
                        'npi' => $subData['npi'],
                        'comprimento' => $subData['comprimento'] ?? null,
                        'largura' => $subData['largura'] ?? null,
                        'altura' => $subData['altura'] ?? null,
                        'perda_percentual' => $subData['perda_percentual'] ?? 0,
                        'descricao' => $subData['descricao'] ?? null,
                        'atividade_id' => $atividade->id,
                        'ordem' => $subData['ordem'],
                    ]);

                    foreach ($subData['composicao'] ?? [] as $compData) {
                        $material = Material::where('codigo', $compData['material_codigo'])->first();
                        
                        if ($material) {
                            ComposicaoCusto::create([
                                'subatividade_id' => $subatividade->id,
                                'material_id' => $material->id,
                                'quantidade' => $compData['quantidade'],
                                'unidade' => $compData['unidade'],
                                'tipo' => $compData['tipo'] ?? 'material',
                                'mao_obra_percentual' => $compData['mao_obra_percentual'] ?? 50,
                            ]);
                        }
                    }
                }

                OrcamentoAtividade::create([
                    'orcamento_id' => $orcamento->id,
                    'atividade_id' => $atividade->id,
                    'categoria_obra_id' => $categoria->id,
                ]);
            }
        }
    }
}