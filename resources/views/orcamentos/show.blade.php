@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            <a href="{{ route('orcamentos.index') }}" class="btn-link">Orçamentos</a>
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-file-invoice-dollar fa-lg me-2"></i>
                            Orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            @if ($orcamento->status !== 'approved')
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" 
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-exchange-alt me-2"></i>
                                        Alterar Status
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item {{ $orcamento->status == 'draft' ? 'active' : '' }}" 
                                           href="javascript:void(0)" onclick="alterarStatus('draft')">
                                            <span class="badge bg-secondary text-white me-2"></span>
                                            Rascunho
                                        </a>
                                        <a class="dropdown-item {{ $orcamento->status == 'sent' ? 'active' : '' }}" 
                                           href="javascript:void(0)" onclick="alterarStatus('sent')">
                                            <span class="badge bg-primary text-white me-2"></span>
                                            Enviado
                                        </a>
                                        <a class="dropdown-item {{ $orcamento->status == 'approved' ? 'active' : '' }}" 
                                           href="javascript:void(0)" onclick="alterarStatus('approved')">
                                            <span class="badge bg-success text-white me-2"></span>
                                            Aprovado
                                        </a>
                                        <a class="dropdown-item {{ $orcamento->status == 'rejected' ? 'active' : '' }}" 
                                           href="javascript:void(0)" onclick="alterarStatus('rejected')">
                                            <span class="badge bg-danger text-white me-2"></span>
                                            Rejeitado
                                        </a>
                                        <a class="dropdown-item {{ $orcamento->status == 'expired' ? 'active' : '' }}" 
                                           href="javascript:void(0)" onclick="alterarStatus('expired')">
                                            <span class="badge bg-warning text-dark me-2"></span>
                                            Expirado
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ route('orcamentos.edit', $orcamento) }}" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-pen me-2"></i> Editar
                                </a>
                            @else
                                <div class="d-flex align-items-center me-2">
                                    <span class="badge bg-success fs-6 me-2">
                                        <i class="fa-solid fa-check me-1"></i> {{ $orcamento->status_label }}
                                    </span>
                                    <small class="text-muted">Orçamento protegido contra alterações</small>
                                </div>
                            @endif
                            <a href="{{ route('orcamentos.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row">
                    <!-- Coluna Esquerda -->
                    <div class="col-lg-4">
                        <!-- Card do Cliente -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa-solid fa-user me-2"></i>
                                    Cliente
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar avatar-lg me-3" style="background-color: #206bc4;">
                                        {{ substr($orcamento->cliente->nome, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-medium">{{ $orcamento->cliente->nome }}</div>
                                        @if($orcamento->cliente->documento)
                                            <div class="text-muted">{{ $orcamento->cliente->documento }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($orcamento->cliente->email)
                                    <div class="mb-2">
                                        <label class="form-label">E-mail</label>
                                        <div class="form-control-plaintext">
                                            <i class="fa-solid fa-envelope me-2 text-muted"></i>
                                            {{ $orcamento->cliente->email }}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($orcamento->cliente->telefone)
                                    <div class="mb-2">
                                        <label class="form-label">Telefone</label>
                                        <div class="form-control-plaintext">
                                            <i class="fa-solid fa-phone me-2 text-muted"></i>
                                            {{ $orcamento->cliente->telefone }}
                                        </div>
                                    </div>
                                @endif

                                @if($orcamento->cliente->endereco)
                                    <div class="mb-2">
                                        <label class="form-label">Endereço</label>
                                        <div class="form-control-plaintext">
                                            <i class="fa-solid fa-map-marker-alt me-2 text-muted"></i>
                                            {{ $orcamento->cliente->endereco->endereco }}, {{ $orcamento->cliente->endereco->numero }}
                                            @if($orcamento->cliente->endereco->complemento)
                                                - {{ $orcamento->cliente->endereco->complemento }}
                                            @endif
                                            <br>
                                            <small class="text-muted">
                                                {{ $orcamento->cliente->endereco->bairro }}, 
                                                {{ $orcamento->cliente->endereco->municipio->nome ?? 'Município não informado' }} - 
                                                {{ $orcamento->cliente->endereco->estado->uf ?? 'UF não informada' }}
                                                @if($orcamento->cliente->endereco->cep)
                                                    <br>CEP: {{ $orcamento->cliente->endereco->cep }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card de Informações do Sistema -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa-solid fa-info-circle me-2"></i>
                                    Informações do Sistema
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <label class="form-label">Status</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge {{ $orcamento->status_badge }}" id="badge-status">
                                            {{ $orcamento->status_label }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <label class="form-label">Criado por</label>
                                    <div class="form-control-plaintext">
                                        <i class="fa-solid fa-user me-2 text-muted"></i>
                                        {{ $orcamento->user->name }}
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <label class="form-label">Data de Criação</label>
                                    <div class="form-control-plaintext">
                                        <i class="fa-solid fa-calendar me-2 text-muted"></i>
                                        {{ $orcamento->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                
                                @if($orcamento->updated_at != $orcamento->created_at)
                                    <div class="mb-2">
                                        <label class="form-label">Última Atualização</label>
                                        <div class="form-control-plaintext">
                                            <i class="fa-solid fa-clock me-2 text-muted"></i>
                                            {{ $orcamento->updated_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                @endif

                                @if($orcamento->validade)
                                    <div class="mb-2">
                                        <label class="form-label">Validade</label>
                                        <div class="form-control-plaintext">
                                            <i class="fa-solid fa-calendar-times me-2 text-muted"></i>
                                            <span class="{{ $orcamento->validade < now() ? 'text-danger' : '' }}">
                                                {{ $orcamento->validade->format('d/m/Y') }}
                                                @if($orcamento->validade < now())
                                                    <small>(Expirado)</small>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Direita -->
                    <div class="col-lg-8">
                        <!-- Card dos Itens -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa-solid fa-list me-2"></i>
                                    Itens do Orçamento
                                </h3>
                                <div class="card-subtitle">{{ $orcamento->itens->count() }} item(s)</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Descrição</th>
                                            <th width="200px">Observações</th>
                                            <th width="100px" class="text-center">Qtd</th>
                                            <th width="100px" class="text-center">Unidade</th>
                                            <!-- <th width="120px" class="text-end">Preço Unit.</th>
                                            <th width="120px" class="text-end">Total</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orcamento->itens as $item)
                                            <tr>
                                                <td>
                                                    <div class="font-weight-medium">{{ $item->descricao }}</div>
                                                    @if($item->itemServico)
                                                        <small class="text-muted">
                                                            <i class="fa-solid fa-cog me-1"></i>
                                                            Item de serviço: {{ $item->itemServico->servico->nome }}
                                                        </small>
                                                    @else
                                                        <small class="text-muted">
                                                            <i class="fa-solid fa-edit me-1"></i>
                                                            Item manual
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->observacao)
                                                        <span class="text-muted">{{ $item->observacao }}</span>
                                                    @else
                                                        <span class="text-muted fst-italic">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($item->quantidade, 2, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->unidade ? $item->unidade->codigo : '-' }}
                                                </td>
                                                <!-- <td class="text-end">
                                                    R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                                                </td>
                                                <td class="text-end font-weight-bold">
                                                    R$ {{ number_format($item->total, 2, ',', '.') }}
                                                </td> -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Card do Resumo Financeiro -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa-solid fa-calculator me-2"></i>
                                    Resumo Financeiro
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Subtotal</label>
                                            <div class="form-control-plaintext h4">
                                                R$ {{ number_format($orcamento->subtotal, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Desconto</label>
                                            <div class="form-control-plaintext h4 text-danger">
                                                R$ {{ number_format($orcamento->desconto, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Total Final</label>
                                            <div class="form-control-plaintext h2 text-success">
                                                R$ {{ number_format($orcamento->total, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($orcamento->observacoes)
                                    <hr>
                                    <div class="mb-3">
                                        <label class="form-label">Observações</label>
                                        <div class="form-control-plaintext">
                                            {{ $orcamento->observacoes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function alterarStatus(novoStatus) {
            if (confirm('Tem certeza que deseja alterar o status do orçamento?')) {
                fetch(`{{ route('orcamentos.update-status', $orcamento) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: novoStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Atualizar badge
                        const badge = document.getElementById('badge-status');
                        badge.className = `badge ${data.status_badge}`;
                        badge.textContent = data.status_label;

                        // Atualizar dropdown
                        document.querySelectorAll('.dropdown-item').forEach(item => {
                            item.classList.remove('active');
                        });
                        event.target.classList.add('active');

                        // Mostrar notificação
                        showToast('Sucesso', data.message, 'success');
                    } else {
                        showToast('Erro', 'Não foi possível alterar o status.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showToast('Erro', 'Não foi possível alterar o status.', 'error');
                });
            }
        }

        function showToast(title, message, type = 'info') {
            const toastHtml = `
                <div class="alert alert-${type === 'error' ? 'danger' : type} alert-dismissible position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <div class="d-flex">
                        <div>
                            <i class="fa-solid fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                            <strong>${title}</strong> ${message}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            `;
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = toastHtml;
            const toast = tempDiv.firstElementChild;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        }
    </script>
@endsection
