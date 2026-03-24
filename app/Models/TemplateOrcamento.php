<?php
// app/Models/TemplateOrcamento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TemplateOrcamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'tipo_projeto', 'descricao', 'configuracoes', 'estrutura', 'publico', 'user_id'
    ];

    protected $casts = [
        'configuracoes' => 'array',
        'estrutura' => 'array',
        'publico' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Criar um orçamento a partir do template
     */
    public function criarOrcamento(Projeto $projeto, $dados = [])
    {
        DB::beginTransaction();
        try {
            // Criar orçamento
            $orcamento = new Orcamento();
            $orcamento->projeto_id = $projeto->id;
            $orcamento->codigo = Orcamento::gerarCodigo();
            $orcamento->versao = 1;
            $orcamento->nome_projeto = $projeto->nome;
            $orcamento->cliente = $projeto->cliente;
            $orcamento->localizacao = $projeto->localizacao;
            $orcamento->data_emissao = now();
            $orcamento->status = 'rascunho';
            
            // Usar configurações do template ou do projeto
            $configuracoes = $this->configuracoes ?: [];
            $orcamento->iva_percentual = $configuracoes['iva'] ?? $dados['iva_percentual'] ?? 16;
            $orcamento->contingencia_percentual = $configuracoes['contingencia'] ?? $dados['contingencia_percentual'] ?? 8;
            
            $orcamento->user_id = auth()->id();
            $orcamento->subtotal = 0;
            $orcamento->valor_iva = 0;
            $orcamento->valor_contingencia = 0;
            $orcamento->grand_total = 0;
            $orcamento->save();

            // Criar atividades a partir da estrutura do template
            if ($this->estrutura && isset($this->estrutura['atividades'])) {
                foreach ($this->estrutura['atividades'] as $atividadeData) {
                    // Buscar ou criar atividade
                    $atividade = Atividade::firstOrCreate(
                        [
                            'codigo' => $atividadeData['codigo'],
                            'categoria_obra_id' => $atividadeData['categoria_obra_id']
                        ],
                        [
                            'nome' => $atividadeData['nome'],
                            'unidade' => $atividadeData['unidade'],
                            'npi' => $atividadeData['npi'],
                            'ordem' => $atividadeData['ordem']
                        ]
                    );
                    
                    // Vincular ao orçamento
                    $orcamento->orcamentoAtividades()->create([
                        'atividade_id' => $atividade->id,
                        'categoria_obra_id' => $atividade->categoria_obra_id,
                        'subtotal' => 0,
                    ]);
                    
                    // Criar subatividades
                    if (isset($atividadeData['subatividades'])) {
                        foreach ($atividadeData['subatividades'] as $subData) {
                            $subatividade = Subatividade::firstOrCreate(
                                [
                                    'codigo' => $subData['codigo'],
                                    'atividade_id' => $atividade->id
                                ],
                                [
                                    'nome' => $subData['nome'],
                                    'unidade' => $subData['unidade'],
                                    'npi' => $subData['npi'],
                                    'comprimento' => $subData['comprimento'] ?? null,
                                    'largura' => $subData['largura'] ?? null,
                                    'altura' => $subData['altura'] ?? null,
                                    'perda_percentual' => $subData['perda_percentual'] ?? 0,
                                    'quantidade_proposta' => $subData['quantidade_proposta'] ?? 0,
                                    'descricao' => $subData['descricao'] ?? null,
                                ]
                            );
                            
                            // Criar composições de custo
                            if (isset($subData['composicoes'])) {
                                foreach ($subData['composicoes'] as $compData) {
                                    ComposicaoCusto::create([
                                        'subatividade_id' => $subatividade->id,
                                        'material_id' => $compData['material_id'] ?? null,
                                        'quantidade' => $compData['quantidade'],
                                        'unidade' => $compData['unidade'],
                                        'custo_unitario' => $compData['custo_unitario'] ?? null,
                                        'tipo' => $compData['tipo'] ?? 'material',
                                        'mao_obra_percentual' => $compData['mao_obra_percentual'] ?? 0,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();
            return $orcamento;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Salvar a estrutura atual do orçamento como template
     */
    public static function salvarDoOrcamento(Orcamento $orcamento, $nome, $descricao = null, $publico = false, $tipo_projeto = null)
    {
        $estrutura = [
            'atividades' => []
        ];
        
        foreach ($orcamento->orcamentoAtividades as $oa) {
            $atividade = $oa->atividade;
            $atividadeData = [
                'codigo' => $atividade->codigo,
                'nome' => $atividade->nome,
                'unidade' => $atividade->unidade,
                'npi' => $atividade->npi,
                'ordem' => $atividade->ordem,
                'categoria_obra_id' => $atividade->categoria_obra_id,
                'subatividades' => []
            ];
            
            foreach ($atividade->subatividades as $sub) {
                $subData = [
                    'codigo' => $sub->codigo,
                    'nome' => $sub->nome,
                    'unidade' => $sub->unidade,
                    'npi' => $sub->npi,
                    'comprimento' => $sub->comprimento,
                    'largura' => $sub->largura,
                    'altura' => $sub->altura,
                    'perda_percentual' => $sub->perda_percentual,
                    'quantidade_proposta' => $sub->quantidade_proposta,
                    'descricao' => $sub->descricao,
                    'composicoes' => []
                ];
                
                foreach ($sub->composicaoCustos as $comp) {
                    $subData['composicoes'][] = [
                        'material_id' => $comp->material_id,
                        'quantidade' => $comp->quantidade,
                        'unidade' => $comp->unidade,
                        'custo_unitario' => $comp->custo_unitario,
                        'tipo' => $comp->tipo,
                        'mao_obra_percentual' => $comp->mao_obra_percentual,
                    ];
                }
                
                $atividadeData['subatividades'][] = $subData;
            }
            
            $estrutura['atividades'][] = $atividadeData;
        }
        
        return self::create([
            'nome' => $nome,
            'descricao' => $descricao,
            'tipo_projeto' => $tipo_projeto,
            'configuracoes' => [
                'iva' => $orcamento->iva_percentual,
                'contingencia' => $orcamento->contingencia_percentual,
            ],
            'estrutura' => $estrutura,
            'publico' => $publico,
            'user_id' => auth()->id(),
        ]);
    }
}