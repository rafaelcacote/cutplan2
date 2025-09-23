@extends('layouts.guest')

@section('title', 'Orçamento #' . str_pad($orcamento->id, 4, '0', STR_PAD_LEFT))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h1 class="h3 mb-1">📋 Orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <!-- <p class="mb-0"> {{ config('app.name') }}</p> -->
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="p-3">
                                <small class="text-muted d-block">Data</small>
                                <strong>{{ $orcamento->created_at->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-{{ $orcamento->status === 'sent' ? 'success' : ($orcamento->status === 'awaiting' ? 'warning' : ($orcamento->status === 'draft' ? 'secondary' : 'secondary')) }} text-white">
                                    {{ $orcamento->status_label }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <small class="text-muted d-block">Validade</small>
                                <strong>
                                    @if($orcamento->validade)
                                        {{ $orcamento->validade->format('d/m/Y') }}
                                    @else
                                        30 dias
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block">Total</small>
                                <strong class="text-success h5">R$ {{ number_format($orcamento->total, 2, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cliente -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Dados do Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nome:</strong> {{ $orcamento->cliente->nome }}</p>
                            @if($orcamento->cliente->email)
                                <p><strong>Email:</strong> {{ $orcamento->cliente->email }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($orcamento->cliente->telefone)
                                <p><strong>Telefone:</strong> {{ $orcamento->cliente->telefone }}</p>
                            @endif
                            @if($orcamento->cliente->cpf_cnpj)
                                <p><strong>CPF/CNPJ:</strong> {{ $orcamento->cliente->cpf_cnpj }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projeto -->
            @if($orcamento->projetos->isNotEmpty())
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-project-diagram me-2"></i>Projeto</h5>
                </div>
                <div class="card-body">
                    @php $projeto = $orcamento->projetos->first(); @endphp
                    <h6>{{ $projeto->nome }}</h6>
                    @if($projeto->observacoes)
                        <p class="text-muted">{{ $projeto->observacoes }}</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Itens do Orçamento -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Itens do Orçamento</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Serviço</th>
                                    <th>Itens</th>
                                    <th class="text-end">Valor Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Agrupar itens por serviço
                                    $itensAgrupados = [];
                                    foreach ($orcamento->itens as $item) {
                                        if ($item->item_servico_id && strpos($item->descricao, ' - ') !== false) {
                                            // Item de serviço
                                            $partes = explode(' - ', $item->descricao, 2);
                                            $nomeServico = $partes[0];
                                            $nomeItem = $partes[1];

                                            if (!isset($itensAgrupados[$nomeServico])) {
                                                $itensAgrupados[$nomeServico] = [
                                                    'itens' => [],
                                                    'valor_total' => 0,
                                                ];
                                            }

                                            $itemTexto = $nomeItem;
                                            if ($item->quantidade > 1) {
                                                $itemTexto .= ' (Qtd: ' . number_format($item->quantidade, 0, ',', '.') . ')';
                                            }
                                            if ($item->observacao) {
                                                $itemTexto .= ' - ' . $item->observacao;
                                            }

                                            $itensAgrupados[$nomeServico]['itens'][] = $itemTexto;
                                            $itensAgrupados[$nomeServico]['valor_total'] += $item->quantidade * $item->preco_unitario;
                                        } else {
                                            // Item manual
                                            $nomeServico = 'Outros Serviços';
                                            if (!isset($itensAgrupados[$nomeServico])) {
                                                $itensAgrupados[$nomeServico] = [
                                                    'itens' => [],
                                                    'valor_total' => 0,
                                                ];
                                            }

                                            $itemTexto = $item->descricao;
                                            if ($item->quantidade > 1) {
                                                $itemTexto .= ' (Qtd: ' . number_format($item->quantidade, 0, ',', '.') . ')';
                                            }
                                            if ($item->observacao) {
                                                $itemTexto .= ' - ' . $item->observacao;
                                            }

                                            $itensAgrupados[$nomeServico]['itens'][] = $itemTexto;
                                            $itensAgrupados[$nomeServico]['valor_total'] += $item->quantidade * $item->preco_unitario;
                                        }
                                    }
                                @endphp

                                @forelse($itensAgrupados as $nomeServico => $dadosServico)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $nomeServico }}</strong>
                                    </td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($dadosServico['itens'] as $item)
                                                <li class="mb-1">• {{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">R$ {{ number_format($dadosServico['valor_total'], 2, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Nenhum item encontrado
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Totais -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @if($orcamento->observacoes)
                                <h6>Observações:</h6>
                                <p class="text-muted">{{ $orcamento->observacoes }}</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="text-end">R$ {{ number_format($orcamento->subtotal, 2, ',', '.') }}</td>
                                </tr>
                                @if($orcamento->desconto > 0)
                                <tr class="text-danger">
                                    <td>Desconto:</td>
                                    <td class="text-end">- R$ {{ number_format($orcamento->desconto, 2, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr class="table-success">
                                    <td><strong>Total:</strong></td>
                                    <td class="text-end"><strong>R$ {{ number_format($orcamento->total, 2, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="mb-3">Gostou do orçamento?</h6>
                    <p class="text-muted mb-4">Entre em contato conosco para aprovação ou esclarecimentos</p>
                    
                    <div class="d-flex justify-content-center flex-wrap gap-2">
                        <a href="{{ route('orcamentos.pdf', $orcamento->id) }}" 
                           class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-download me-2"></i>Download PDF
                        </a>
                        
                        @if($orcamento->cliente->telefone)
                            @php
                                $telefone = preg_replace('/[^0-9]/', '', $orcamento->cliente->telefone);
                                $mensagem = "Olá! Vi o orçamento #" . str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) . " no valor de R$ " . number_format($orcamento->total, 2, ',', '.') . ". Gostaria de mais informações.";
                                $whatsappUrl = "https://wa.me/55{$telefone}?text=" . urlencode($mensagem);
                            @endphp
                            <a href="{{ $whatsappUrl }}" class="btn btn-success" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <strong>{{ config('app.name') }}</strong><br>
                    Este orçamento foi gerado automaticamente em {{ now()->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
}

@media print {
    .btn, .card-header .badge {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }
}
</style>
@endsection