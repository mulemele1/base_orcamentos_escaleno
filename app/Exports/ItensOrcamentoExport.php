<?php

namespace App\Exports;

use App\Models\ItemOrcamento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItensOrcamentoExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $categoria_id;

    public function __construct($categoria_id)
    {
        $this->categoria_id = $categoria_id;
    }

    /**
    * @return Collection
    */
    public function collection()
    {
        return ItemOrcamento::where('categoria_obra_id', $this->categoria_id)
            ->with('categoria')
            ->orderBy('item')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Item',
            'Descrição',
            'Unidade',
            'NPI',
            'Comprimento',
            'Largura',
            'Altura',
            'Elementar',
            'Parcial',
            'Perdas',
            'Quantidade Proposta',
            'Custo Fornecimento',
            'Custo Mão Obra',
            'Preço Unitário',
            'Total',
            'Comentários'
        ];
    }

    public function map($item): array
    {
        return [
            $item->item,
            $item->descricao,
            $item->unidade,
            $item->npi ?? '-',
            $item->comprimento ?? '-',
            $item->largura ?? '-',
            $item->altura ?? '-',
            $item->elementar ? number_format($item->elementar, 2, ',', '.') : '-',
            $item->parcial ? number_format($item->parcial, 2, ',', '.') : '-',
            $item->perdas != 1 ? $item->perdas : '-',
            number_format($item->quantidade_proposta, 2, ',', '.'),
            $item->custo_fornecimento ? 'MT ' . number_format($item->custo_fornecimento, 2, ',', '.') : '-',
            $item->custo_mao_obra ? 'MT ' . number_format($item->custo_mao_obra, 2, ',', '.') : '-',
            'MT ' . number_format($item->preco_unitario, 2, ',', '.'),
            'MT ' . number_format($item->total, 2, ',', '.'),
            $item->comentarios ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para o cabeçalho
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 
                  'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '90caf9']]],
        ];
    }
}