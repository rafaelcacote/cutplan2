<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;

class ContratoController extends Controller
{
    /**
     * Gera um contrato padrão do cliente para o projeto e salva como PDF.
     */
    public function gerarContratoCliente(Projeto $projeto)
    {
        $cliente = $projeto->cliente;
        $itens = $projeto->itensProjeto;

        $dir = 'contratos/projeto-' . $projeto->id;
        Storage::makeDirectory($dir);

        $numeroContrato = 'CTR-' . str_pad((string) $projeto->id, 5, '0', STR_PAD_LEFT) . '-' . now()->format('ymdHis');
        $arquivoSalvo = null;

        // 1) Tenta usar o template DOCX internalizado no sistema
        $candidates = [
            storage_path('app/templates/contratos/contrato_cliente.docx'), // prioridade para template carregado em runtime
            resource_path('templates/contratos/contrato_cliente.docx'),     // fallback para template versionado
        ];
        $docxTemplatePath = null;
        foreach ($candidates as $c) {
            if (file_exists($c)) { $docxTemplatePath = $c; break; }
        }

        if ($docxTemplatePath) {
            try {
                $tp = new TemplateProcessor($docxTemplatePath);

                // Campos do Cliente
                $tp->setValue('CLIENTE_NOME', $cliente->nome ?? '');
                $tp->setValue('CLIENTE_DOCUMENTO', $cliente->documento ?? '');
                $tp->setValue('CLIENTE_EMAIL', $cliente->email ?? '');
                $tp->setValue('CLIENTE_TELEFONE', $cliente->telefone ?? '');

                $enderecoCliente = '';
                if ($cliente->endereco) {
                    $end = $cliente->endereco;
                    $partes = array_filter([
                        $end->logradouro ? ($end->logradouro . ', ' . ($end->numero ?? '')) : null,
                        $end->bairro ?? null,
                        ($end->cidade && $end->estado) ? ($end->cidade . '/' . $end->estado) : null,
                        $end->cep ? ('CEP ' . $end->cep) : null,
                    ]);
                    $enderecoCliente = implode(' - ', $partes);
                }
                $tp->setValue('CLIENTE_ENDERECO', $enderecoCliente);

                // Campos do Projeto
                $tp->setValue('PROJETO_NOME', $projeto->nome ?? '');
                $tp->setValue('PROJETO_CODIGO', $projeto->codigo ?? '');
                $tp->setValue('PROJETO_DATA', now()->format('d/m/Y'));
                $tp->setValue('PROJETO_DATA_INICIO', $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '');
                $tp->setValue('PROJETO_DATA_ENTREGA_PREVISTA', $projeto->data_entrega_prevista ? $projeto->data_entrega_prevista->format('d/m/Y') : '');

                // Empresa (provisório)
                $tp->setValue('EMPRESA_NOME', config('app.name'));
                // Se quiser já tentar logo: coloque public/logo.png e descomente abaixo
                // if (Storage::exists('public/logo.png')) {
                //     $tp->setImageValue('EMPRESA_LOGO', [
                //         'path' => storage_path('app/public/logo.png'),
                //         'width' => 120,
                //         'height' => 40,
                //         'ratio' => true,
                //     ]);
                // }

                // Itens do projeto - usar cloneRow
                $count = max(1, $itens->count());
                $tp->cloneRow('ITEM_DESCRICAO', $count);

                if ($itens->count() > 0) {
                    $idx = 1;
                    foreach ($itens as $item) {
                        $tp->setValue("ITEM_DESCRICAO#{$idx}", $item->descricao ?? '');
                        $tp->setValue("ITEM_QTD#{$idx}", number_format((float)$item->quantidade, 3, ',', '.'));
                        $tp->setValue("ITEM_UNIDADE#{$idx}", optional($item->unidade)->sigla ?? optional($item->unidade)->nome ?? '-');
                        $tp->setValue("ITEM_PRECO_ORCADO#{$idx}", $item->preco_orcado ? ('R$ ' . number_format((float)$item->preco_orcado, 2, ',', '.')) : '-');
                        $tp->setValue("ITEM_PRECO_REAL#{$idx}", $item->preco_real ? ('R$ ' . number_format((float)$item->preco_real, 2, ',', '.')) : '-');
                        $idx++;
                    }
                } else {
                    // Linha vazia se não houver itens
                    $tp->setValue('ITEM_DESCRICAO#1', 'Sem itens cadastrados');
                    $tp->setValue('ITEM_QTD#1', '-');
                    $tp->setValue('ITEM_UNIDADE#1', '-');
                    $tp->setValue('ITEM_PRECO_ORCADO#1', '-');
                    $tp->setValue('ITEM_PRECO_REAL#1', '-');
                }

                $fileNameDocx = 'contrato_cliente_' . $projeto->id . '_' . now()->format('Ymd_His') . '.docx';
                $relativeDocx = $dir . '/' . $fileNameDocx;
                $tp->saveAs(storage_path('app/' . $relativeDocx));
                $arquivoSalvo = $relativeDocx;
            } catch (\Throwable $e) {
                // Se der erro no DOCX, seguimos para o fallback em PDF
            }
        }

        // 2) Fallback para PDF via Blade se não salvou DOCX
        if (!$arquivoSalvo) {
            $html = view('contratos.modelo_cliente', [
                'projeto' => $projeto,
                'cliente' => $cliente,
                'itens'   => $itens,
            ])->render();

            $mpdf = new Mpdf(['mode' => 'utf-8']);
            $mpdf->WriteHTML($html);

            $fileNamePdf = 'contrato_cliente_' . $projeto->id . '_' . now()->format('Ymd_His') . '.pdf';
            $relativePdf = $dir . '/' . $fileNamePdf;
            $absolutePdf = storage_path('app/' . $relativePdf);
            $mpdf->Output($absolutePdf, 'F');
            $arquivoSalvo = $relativePdf;
        }

        // Cria o registro do contrato
        $contrato = Contrato::create([
            'projeto_id' => $projeto->id,
            'numero' => $numeroContrato,
            'titulo' => 'Contrato do Cliente',
            'descricao' => 'Contrato gerado automaticamente com dados do cliente e itens do projeto.',
            'valor' => optional($projeto->orcamento)->total,
            'data_inicio' => now()->toDateString(),
            'status' => 'rascunho',
            'arquivo_path' => $arquivoSalvo,
        ]);

        return back()->with('success', 'Contrato gerado com sucesso.')->with('novo_contrato_id', $contrato->id);
    }

    /**
     * Download do arquivo do contrato.
     */
    public function download(Contrato $contrato)
    {
        $path = storage_path('app/' . $contrato->arquivo_path);
        if (!file_exists($path)) {
            abort(404, 'Arquivo do contrato não encontrado.');
        }
        return response()->download($path, basename($path));
    }
}
