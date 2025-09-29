<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Attributes\AsCommand;
use PhpOffice\PhpWord\PhpWord;

#[AsCommand(name: 'contratos:make-template', description: 'Gera um template DOCX de contrato do cliente com placeholders padrão')]
class MakeContratoTemplate extends Command
{
    protected $signature = 'contratos:make-template {--force : Overwrite if exists}';

    public function handle()
    {
        $targetDir = resource_path('templates/contratos');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $target = $targetDir . DIRECTORY_SEPARATOR . 'contrato_cliente.docx';
        if (file_exists($target) && !$this->option('force')) {
            $this->warn('Arquivo já existe: ' . $target . ' (use --force para sobrescrever)');
            return self::SUCCESS;
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addTitle('Contrato de Prestação de Serviços', 1);
        $section->addText('Projeto: ${PROJETO_NOME} (${PROJETO_CODIGO})');
        $section->addText('Data: ${PROJETO_DATA}');
        $section->addTextBreak(1);

        $section->addText('Dados do Contratante (Cliente)', ['bold' => true]);
        $section->addText('Nome: ${CLIENTE_NOME}');
        $section->addText('Documento: ${CLIENTE_DOCUMENTO}');
        $section->addText('E-mail: ${CLIENTE_EMAIL}');
        $section->addText('Telefone: ${CLIENTE_TELEFONE}');
        $section->addText('Endereço: ${CLIENTE_ENDERECO}');
        $section->addTextBreak(1);

        $section->addText('Itens do Projeto', ['bold' => true]);
        $table = $section->addTable(['alignment' => 'left', 'borderSize' => 6, 'cellMargin' => 80]);
        $table->addRow();
        $table->addCell(6000)->addText('Descrição');
        $table->addCell(1200)->addText('Qtd');
        $table->addCell(1200)->addText('Un');
        $table->addCell(1800)->addText('Preço Orcado');
        $table->addCell(1800)->addText('Preço Real');

        // Linha modelo para cloneRow (TemplateProcessor vai duplicar quando for usar)
        $table->addRow();
        $table->addCell(6000)->addText('${ITEM_DESCRICAO}');
        $table->addCell(1200)->addText('${ITEM_QTD}');
        $table->addCell(1200)->addText('${ITEM_UNIDADE}');
        $table->addCell(1800)->addText('${ITEM_PRECO_ORCADO}');
        $table->addCell(1800)->addText('${ITEM_PRECO_REAL}');

        $section->addTextBreak(1);
        $section->addText('Condições Gerais', ['bold' => true]);
        $section->addText('Inclua aqui suas cláusulas padrão (prazos, garantias, pagamentos, foro, etc.).');

        $phpWord->save($target, 'Word2007');
        $this->info('Template gerado em: ' . $target);
        return self::SUCCESS;
    }
}
