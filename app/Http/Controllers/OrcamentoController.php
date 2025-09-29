<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\ItemOrcamento;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\ItemServico;
use App\Models\Unidade;
use App\Http\Requests\StoreOrcamentoRequest;
use App\Http\Requests\UpdateOrcamentoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class OrcamentoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $query = Orcamento::with(['cliente', 'user', 'projetos']);

        // Filtros
        if ($request->filled('search_cliente')) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search_cliente . '%');
            });
        }

        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }

        if ($request->filled('search_data_inicio')) {
            $query->whereDate('created_at', '>=', $request->search_data_inicio);
        }

        if ($request->filled('search_data_fim')) {
            $query->whereDate('created_at', '<=', $request->search_data_fim);
        }

        $orcamentos = $query->orderBy('created_at', 'desc')->paginate($perPage);
        $orcamentos->appends($request->query());

        return view('orcamentos.index', compact('orcamentos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('orcamentos.create', compact('clientes'));
    }

    public function store(StoreOrcamentoRequest $request)
    {
        try {
            \Log::info('=== INÍCIO DO STORE ===');
            \Log::info('Request data completo:', $request->all());
            \Log::info('Dados de itens recebidos:', $request->input('itens', []));

            $validated = $request->validated();

            // Log para debug
            \Log::info('Dados validados para criar orçamento:', $validated);
            \Log::info('Itens validados:', $validated['itens'] ?? []);

            // Verificar se realmente tem itens
            if (empty($validated['itens'])) {
                \Log::error('ERRO: Nenhum item foi enviado no request!');
                return back()->withInput()->with('error', 'Erro: Nenhum item foi enviado. Adicione pelo menos um item ao orçamento.');
            }

            // Criar orçamento
            $orcamento = Orcamento::create([
                'cliente_id' => $validated['cliente_id'],
                'status' => 'draft',
                'validade' => $validated['validade'] ?? null,
                'desconto' => $validated['desconto'] ?? 0,
                'user_id' => auth()->id(),
                'observacoes' => $validated['observacoes'] ?? null,
            ]);

            \Log::info('Orçamento criado com sucesso:', ['id' => $orcamento->id]);

            // Criar itens
            foreach ($validated['itens'] as $index => $itemData) {
                \Log::info("Criando item {$index}:", $itemData);


                $item = ItemOrcamento::create([
                    'orcamento_id' => $orcamento->id,
                    'descricao' => $itemData['descricao'],
                    'observacao' => $itemData['observacao'] ?? null,
                    'quantidade' => $itemData['quantidade'],
                    'unidade_id' => $itemData['unidade_id'] ?? null,
                    'preco_unitario' => $itemData['preco_unitario'],
                    'item_servico_id' => $itemData['item_servico_id'] ?? null,
                ]);
                \Log::info("Item {$index} criado com sucesso:", ['item_id' => $item->id, 'descricao' => $item->descricao]);
            }

            // Recalcular totais do orçamento
            $orcamento->recalcularTotais();
            \Log::info('Totais recalculados:', ['subtotal' => $orcamento->subtotal, 'total' => $orcamento->total]);

            // Atualizar status para 'awaiting'
            $orcamento->update(['status' => 'awaiting']);

            \Log::info('=== ORÇAMENTO SALVO COM SUCESSO ===');
            return redirect()->route('orcamentos.actions', $orcamento->id)->with('success', 'Orçamento criado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return back()->withErrors($e->errors())->withInput()->with('error', 'Erro de validação nos dados do orçamento.');

        } catch (\Exception $e) {
            \Log::error('Erro ao criar orçamento:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()->withInput()->with('error', 'Erro ao criar orçamento: ' . $e->getMessage());
        }
    }

    public function show(Orcamento $orcamento)
    {
        $orcamento->load(['cliente.endereco', 'itens.unidade', 'itens.itemServico', 'user']);
        return view('orcamentos.show', compact('orcamento'));
    }

    public function edit(Orcamento $orcamento)
    {
        // Verificar se o orçamento pode ser editado
        if ($orcamento->status === 'approved') {
            return redirect()->route('orcamentos.show', $orcamento)
                ->with('error', 'Orçamentos aprovados não podem ser editados.');
        }

        $orcamento->load(['itens.unidade', 'itens.itemServico']);
        $clientes = Cliente::orderBy('nome')->get();
        $servicos = Servico::where('ativo', true)->orderBy('nome')->get();
        $unidades = Unidade::orderBy('nome')->get();

        return view('orcamentos.edit', compact('orcamento', 'clientes', 'servicos', 'unidades'));
    }

    public function update(UpdateOrcamentoRequest $request, Orcamento $orcamento)
    {
        // Verificar se o orçamento pode ser editado
        if ($orcamento->status === 'approved') {
            return redirect()->route('orcamentos.show', $orcamento)
                ->with('error', 'Orçamentos aprovados não podem ser editados.');
        }

        $validated = $request->validated();

        // Atualizar orçamento
        $orcamento->update([
            'cliente_id' => $validated['cliente_id'],
            'status' => $validated['status'],
            'validade' => $validated['validade'] ?? null,
            'desconto' => $validated['desconto'] ?? 0,
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        // Remover itens existentes
        $orcamento->itens()->delete();

        // Criar novos itens
        foreach ($validated['itens'] as $itemData) {
            ItemOrcamento::create([
                'orcamento_id' => $orcamento->id,
                'descricao' => $itemData['descricao'],
                'observacao' => $itemData['observacao'] ?? null,
                'quantidade' => $itemData['quantidade'],
                'unidade_id' => $itemData['unidade_id'] ?? null,
                'preco_unitario' => $itemData['preco_unitario'],
                'item_servico_id' => $itemData['item_servico_id'] ?? null,
            ]);
        }

        return redirect()->route('orcamentos.index')->with('success', 'Orçamento atualizado com sucesso!');
    }

    public function destroy(Orcamento $orcamento)
    {
        // Verificar se o orçamento pode ser excluído
        if (!$orcamento->podeSerExcluido()) {
            return redirect()->route('orcamentos.index')
                ->with('error', 'Este orçamento não pode ser excluído. Apenas orçamentos com status "Rascunho", "Rejeitado" ou "Expirado" podem ser excluídos.');
        }

        $orcamento->delete();
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento excluído com sucesso!');
    }

    // API Methods para AJAX
    public function getServicos(): JsonResponse
    {
        $servicos = Servico::where('ativo', true)
            ->orderBy('nome')
            ->get(['id', 'nome']);

        return response()->json($servicos);
    }

    public function getItensServico(Servico $servico): JsonResponse
    {
        $itens = ItemServico::where('servico_id', $servico->id)
            ->get(['id', 'descricao_item', 'servico_id']);
        return response()->json($itens);
    }

    public function getServico($id): JsonResponse
    {
        $servico = Servico::findOrFail($id);
        return response()->json($servico);
    }

    public function getUnidades(): JsonResponse
    {
        $unidades = Unidade::orderBy('nome')->get(['id', 'nome', 'codigo']);
        return response()->json($unidades);
    }

    public function updateStatus(Request $request, Orcamento $orcamento): JsonResponse
    {
        // Verificar se o orçamento pode ter status alterado
        if ($orcamento->status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'O status de orçamentos aprovados não pode ser alterado.'
            ], 422);
        }

        $request->validate([
            'status' => 'required|in:draft,awaiting,sent,approved,rejected,expired'
        ]);

        $orcamento->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'status' => $orcamento->status,
            'status_label' => $orcamento->status_label,
            'status_badge' => $orcamento->status_badge
        ]);
    }

    public function generatePdf(Orcamento $orcamento)
    {
        // Carregar relacionamentos necessários
        $orcamento->load(['cliente', 'itens.unidade', 'user']);

        // Criar instância do mPDF
        $mpdf = new Mpdf([
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 9,
            'margin_footer' => 9
        ]);

        // Gerar HTML do orçamento
        $html = view('orcamentos.pdf', compact('orcamento'))->render();

        // Escrever HTML no PDF
        $mpdf->WriteHTML($html);

        // Nome do arquivo
        $filename = 'orcamento_' . str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) . '.pdf';

        // Retornar o PDF
        return response($mpdf->Output($filename, 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    /**
     * Página de ações pós-criação do orçamento
     */
    public function actions($id)
    {
        $orcamento = Orcamento::with(['cliente', 'itens.unidade'])->findOrFail($id);
        return view('orcamentos.actions', compact('orcamento'));
    }

    /**
     * Enviar orçamento por email
     */
    public function sendEmail(Request $request, $id)
    {
        $orcamento = Orcamento::with(['cliente', 'itens.unidade'])->findOrFail($id);
        
        $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string|max:1000'
        ]);

        try {
            // Gerar PDF
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
            $html = view('orcamentos.pdf', compact('orcamento'))->render();
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', 'S');

            // Enviar email
            \Mail::send('emails.orcamento', [
                'orcamento' => $orcamento,
                'customMessage' => $request->message
            ], function ($message) use ($orcamento, $request, $pdfContent) {
                $message->to($request->email)
                    ->subject("Orçamento #{$orcamento->id} - " . config('app.name'))
                    ->attachData($pdfContent, "orcamento_{$orcamento->id}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
            });

            // Atualizar status
            $orcamento->update(['status' => 'sent']);

            return back()->with('success', 'Orçamento enviado por email com sucesso!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao enviar email: ' . $e->getMessage());
        }
    }

    /**
     * Enviar orçamento via WhatsApp
     */
    public function sendWhatsApp($id)
    {
        $orcamento = Orcamento::with(['cliente'])->findOrFail($id);
        $cliente = $orcamento->cliente;
        if (!$cliente) {
            return back()->with('error', 'Orçamento não possui cliente vinculado.');
        }
        $telefone = preg_replace('/\D/', '', $cliente->telefone ?? '');
        if (empty($telefone)) {
            return back()->with('error', 'Cliente não possui telefone cadastrado.');
        }
        // Criar mensagem
        $nomeCliente = $cliente->nome ?? 'Cliente';
        $message = "Olá {$nomeCliente}!\n\n";
        $message .= "Segue o orçamento #{$orcamento->id} solicitado.\n";
        $message .= "Total: R$ " . number_format($orcamento->total, 2, ',', '.') . "\n\n";
        $message .= "Você pode visualizar o orçamento completo em:\n";
        $message .= route('orcamentos.public', $orcamento->uuid);
        // URL do WhatsApp
        $whatsappUrl = "https://wa.me/55{$telefone}?text=" . urlencode($message);
        // Atualizar status
        $orcamento->update(['status' => 'sent']);
        return redirect($whatsappUrl);
    }

    /**
     * Visualização pública do orçamento (sem autenticação)
     */
    public function publicView($uuid)
    {
        $orcamento = Orcamento::with(['cliente', 'itens.unidade', 'itens.itemServico', 'user', 'projetos'])
            ->where('uuid', $uuid)
            ->firstOrFail();
            
        return view('orcamentos.public', compact('orcamento'));
    }
}
