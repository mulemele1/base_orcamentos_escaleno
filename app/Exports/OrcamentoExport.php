<?php

namespace App\Exports;

use App\Models\Orcamento;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class OrcamentoExport implements FromView
{
    protected $orcamento;

    public function __construct(Orcamento $orcamento)
    {
        $this->orcamento = $orcamento;
    }

    public function view(): View
    {
        return view('exports.orcamento', [
            'orcamento' => $this->orcamento
        ]);
    }
}