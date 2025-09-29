@extends('layouts.app')

@section('content')
    @include('components.toast')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            <i class="fa-solid fa-file-invoice-dollar fa-lg me-2"></i>
                            Orçamentos
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('orcamentos.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-plus me-2"></i> Novo Orçamento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <!-- Filtros -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa-solid fa-filter me-2"></i>
                            Filtros de Pesquisa
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('orcamentos.index') }}">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Cliente</label>
                                        <input type="text" class="form-control" name="search_cliente"
                                            value="{{ request('search_cliente') }}" placeholder="Nome do cliente">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="search_status">
                                            <option value="">Todos</option>
                                            <option value="draft"
                                                {{ request('search_status') == 'draft' ? 'selected' : '' }}>Rascunho
                                            </option>
                                            <option value="sent"
                                                {{ request('search_status') == 'sent' ? 'selected' : '' }}>Enviado</option>
                                            <option value="approved"
                                                {{ request('search_status') == 'approved' ? 'selected' : '' }}>Aprovado
                                            </option>
                                            <option value="rejected"
                                                {{ request('search_status') == 'rejected' ? 'selected' : '' }}>Rejeitado
                                            </option>
                                            <option value="expired"
                                                {{ request('search_status') == 'expired' ? 'selected' : '' }}>Expirado
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label">Data Início</label>
                                        <input type="date" class="form-control" name="search_data_inicio"
                                            value="{{ request('search_data_inicio') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label">Data Fim</label>
                                        <input type="date" class="form-control" name="search_data_fim"
                                            value="{{ request('search_data_fim') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="btn-list d-flex">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-2"></i> Pesquisar
                                            </button>
                                            <a href="{{ route('orcamentos.index') }}" class="btn btn-outline-secondary">
                                                <i class="fa-solid fa-eraser me-2"></i> Limpar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de Orçamentos -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Orçamentos</h3> 
                        <div class="card-subtitle">{{ $orcamentos->total() }} orçamento(s) encontrado(s)</div>
                    </div>

                    <!-- Legenda de Status -->
                    <div class="card-body pt-3 pb-2">
                        <div class="alert alert-info border-0"
                            style="background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%); border-left: 4px solid #007bff !important;">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-tags me-2 text-primary"></i>
                                <strong class="text-primary">Legenda dos Status:</strong>
                            </div>
                            <div class="row text-sm">
                                <div class="col-md-2 col-6 mb-1">
                                    <span class="badge bg-secondary text-white me-1">Rascunho</span>
                                    <small class="text-muted d-block">Em elaboração</small>
                                </div>
                                <div class="col-md-2 col-6 mb-1">
                                    <span class="badge bg-primary text-white me-1">Enviado</span>
                                    <small class="text-muted d-block">Aguardando resposta</small>
                                </div>
                                <div class="col-md-2 col-6 mb-1">
                                    <span class="badge bg-success text-white me-1">Aprovado</span>
                                    <small class="text-muted d-block">Cliente aceitou</small>
                                </div>
                                <div class="col-md-2 col-6 mb-1">
                                    <span class="badge bg-danger text-white me-1">Rejeitado</span>
                                    <small class="text-muted d-block">Cliente recusou</small>
                                </div>
                                <div class="col-md-2 col-6 mb-1">
                                    <span class="badge bg-warning text-dark me-1">Expirado</span>
                                    <small class="text-muted d-block">Prazo vencido</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @forelse($orcamentos as $orcamento)
                        @if ($loop->first)
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Validade</th>
                                            <th>Projeto</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        @endif
                        <tr>
                            <td class="text-muted">
                                #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <div class="d-flex py-1 align-items-center">
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">{{ $orcamento->cliente?->nome ?? 'Cliente não encontrado' }}</div>
                                        <div class="text-muted">{{ $orcamento->cliente?->email ?? 'Sem email' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown position-relative">
                                    <button class="btn btn-sm dropdown-toggle p-1 border-0 {{ $orcamento->status_badge }}" 
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="min-width: 90px;">
                                        {{ $orcamento->status_label }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item {{ $orcamento->status === 'draft' ? 'active' : '' }}" 
                                               href="#" onclick="event.preventDefault(); updateStatus({{ $orcamento->id }}, 'draft')">
                                                <span class="badge bg-secondary text-white me-2">Rascunho</span>
                                                Em elaboração
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ $orcamento->status === 'awaiting' ? 'active' : '' }}" 
                                               href="#" onclick="event.preventDefault(); updateStatus({{ $orcamento->id }}, 'awaiting')">
                                                <span class="badge bg-warning text-dark me-2">Aguardando</span>
                                                Pronto para envio
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ $orcamento->status === 'sent' ? 'active' : '' }}" 
                                               href="#" onclick="event.preventDefault(); updateStatus({{ $orcamento->id }}, 'sent')">
                                                <span class="badge bg-primary text-white me-2">Enviado</span>
                                                Aguardando resposta
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ $orcamento->status === 'approved' ? 'active' : '' }}" 
                                               href="#" onclick="event.preventDefault(); updateStatus({{ $orcamento->id }}, 'approved')">
                                                <span class="badge bg-success text-white me-2">Aprovado</span>
                                                Cliente aceitou
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ $orcamento->status === 'rejected' ? 'active' : '' }}" 
                                               href="#" onclick="event.preventDefault(); updateStatus({{ $orcamento->id }}, 'rejected')">
                                                <span class="badge bg-danger text-white me-2">Rejeitado</span>
                                                Cliente recusou
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ $orcamento->status === 'expired' ? 'active' : '' }}" 
                                               href="#" onclick="event.preventDefault(); updateStatus({{ $orcamento->id }}, 'expired')">
                                                <span class="badge bg-warning text-dark me-2">Expirado</span>
                                                Prazo vencido
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-end">
                                <strong>R$ {{ number_format($orcamento->total, 2, ',', '.') }}</strong>
                                @if ($orcamento->desconto > 0)
                                    <br><small class="text-muted">Desc: R$
                                        {{ number_format($orcamento->desconto, 2, ',', '.') }}</small>
                                @endif
                            </td>
                            <td>
                                @if ($orcamento->validade)
                                    <span class="{{ $orcamento->validade < now() ? 'text-danger' : 'text-muted' }}">
                                        {{ $orcamento->validade->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($orcamento->status == 'approved')
                                    @if ($orcamento->temProjetoCriado())
                                        <a href="{{ route('projetos.show', $orcamento->getPrimeiroProjeto()) }}"
                                            class="badge bg-green text-white text-decoration-none" 
                                            title="Clique para visualizar o projeto">
                                            <i class="fa-solid fa-diagram-project me-1"></i>
                                            Projeto Criado
                                        </a>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            Aguardando Projeto
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-list flex-nowrap justify-content-end">
                                    <a href="{{ route('orcamentos.show', $orcamento) }}"
                                        class="btn btn-outline-primary btn-sm" title="Visualizar Detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if ($orcamento->status !== 'approved')
                                        <a href="{{ route('orcamentos.edit', $orcamento) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Editar Orçamento">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @else
                                        <span class="btn btn-outline-secondary btn-sm disabled" title="Orçamentos aprovados não podem ser editados">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                    @endif
                                    {{-- Botão para enviar orçamento por email --}}
                                    @if (in_array($orcamento->status, ['draft', 'sent', 'approved', 'rejected']))
                                        <button type="button" class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#modal-enviar-{{ $orcamento->id }}"
                                                title="Enviar Orçamento por Email">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    @endif
                                    @if ($orcamento->status == 'approved')
                                        @if ($orcamento->temProjetoCriado())
                                            {{-- Botão para visualizar projeto existente --}}
                                            <a href="{{ route('projetos.show', $orcamento->getPrimeiroProjeto()) }}"
                                                class="btn btn-outline-success btn-sm" title="Visualizar Projeto Criado">
                                                <i class="fa-solid fa-eye me-1"></i>
                                                <span class="d-none d-lg-inline">Ver Projeto</span>
                                            </a>
                                        @else
                                            {{-- Botão para criar novo projeto --}}
                                            <a href="{{ route('projetos.create', ['orcamento_id' => $orcamento->id]) }}"
                                                class="btn btn-success btn-sm" title="Criar Novo Projeto">
                                                <i class="fa-solid fa-plus me-1"></i>
                                                <span class="d-none d-lg-inline">Criar Projeto</span>
                                            </a>
                                        @endif
                                    @endif
                                    <a href="{{ route('orcamentos.pdf', $orcamento) }}"
                                        class="btn btn-info btn-sm pdf-btn" title="📄 Baixar PDF do Orçamento"
                                        target="_blank"
                                        style="background: linear-gradient(45deg, #007bff, #0056b3); border: none; color: white; font-weight: 500; box-shadow: 0 2px 4px rgba(0,123,255,0.3); transition: all 0.3s ease;">
                                        <i class="fa-solid fa-file-pdf me-1"></i>

                                    </a>
                                    @if ($orcamento->podeSerExcluido())
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modal-excluir-{{ $orcamento->id }}" title="Excluir">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-danger btn-sm" disabled 
                                            title="Orçamento não pode ser excluído neste status">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @if ($loop->last)
                            </tbody>
                            </table>
                </div>
                @endif
            @empty
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-img">
                            <i class="fa-solid fa-file-lines fa-3x text-muted mb-2"></i>

                        </div>
                        <p class="empty-title">Nenhum orçamento encontrado</p>
                        <p class="empty-subtitle text-muted">
                            Não há orçamentos cadastrados ou que correspondam aos filtros aplicados.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('orcamentos.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-plus me-2"></i>
                                Criar primeiro orçamento
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse

                @if ($orcamentos instanceof \Illuminate\Pagination\LengthAwarePaginator && $orcamentos->hasPages())
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                <li class="page-item{{ $orcamentos->onFirstPage() ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $orcamentos->previousPageUrl() ?? '#' }}" tabindex="-1"
                                        aria-disabled="{{ $orcamentos->onFirstPage() ? 'true' : 'false' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                                {{-- Pagination Elements --}}
                                @foreach ($orcamentos->links()->elements[0] as $page => $url)
                                    @if ($url)
                                        <li class="page-item{{ $page == $orcamentos->currentPage() ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @endif
                                @endforeach
                                {{-- Next Page Link --}}
                                <li class="page-item{{ $orcamentos->hasMorePages() ? '' : ' disabled' }}">
                                    <a class="page-link" href="{{ $orcamentos->nextPageUrl() ?? '#' }}"
                                        aria-disabled="{{ $orcamentos->hasMorePages() ? 'false' : 'true' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

    <!-- Modais de Exclusão -->
    @foreach ($orcamentos as $orcamento)
        @if ($orcamento->podeSerExcluido())
            <div class="modal modal-blur fade" id="modal-excluir-{{ $orcamento->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                        <h3>Tem certeza?</h3>
                        <div class="text-muted">
                            Você realmente deseja excluir o orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}
                            de <strong>{{ $orcamento->cliente?->nome ?? 'Cliente não encontrado' }}</strong>?
                            <br>Esta ação não pode ser desfeita.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn w-100" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>
                                </div>
                                <div class="col">
                                    <form method="POST" action="{{ route('orcamentos.destroy', $orcamento) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    <!-- Modais de Envio de Email -->
    @foreach ($orcamentos as $orcamento)
        @if (in_array($orcamento->status, ['draft', 'sent', 'approved', 'rejected']))
            <div class="modal modal-blur fade" id="modal-enviar-{{ $orcamento->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fa-solid fa-paper-plane me-2"></i>
                                Enviar Orçamento por Email
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('orcamentos.send-email', $orcamento) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <div class="avatar avatar-lg bg-warning text-white mb-3 mx-auto">
                                        <i class="fa-solid fa-envelope fa-lg"></i>
                                    </div>
                                    <h4>Orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}</h4>
                                    <p class="text-muted">{{ $orcamento->cliente?->nome ?? 'Cliente não encontrado' }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Email do Destinatário</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="{{ $orcamento->cliente?->email ?? '' }}" 
                                           placeholder="Digite o email do cliente" required>
                                    <small class="form-hint">Email principal do cliente carregado automaticamente</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Mensagem Personalizada (Opcional)</label>
                                    <textarea class="form-control" name="message" rows="4" 
                                              placeholder="Digite uma mensagem personalizada (opcional)">Prezado(a) {{ $orcamento->cliente?->nome ?? 'Cliente' }},

Segue em anexo o orçamento solicitado.

Qualquer dúvida, estamos à disposição.

Atenciosamente,
{{ auth()->user()->name ?? 'Equipe' }}</textarea>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fa-solid fa-info-circle me-2"></i>
                                    <strong>Informações:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>O PDF do orçamento será anexado automaticamente</li>
                                        <li>O status será alterado para "Enviado" após o envio</li>
                                        <li>O email será enviado com o assunto padrão do sistema</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa-solid fa-paper-plane me-2"></i>Enviar Email
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- Modal de Confirmação de Mudança de Status -->
    <div class="modal modal-blur fade" id="modal-status-change" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-exchange-alt me-2"></i>
                        Alterar Status do Orçamento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="avatar avatar-lg bg-primary text-white mb-3 mx-auto">
                            <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
                        </div>
                        <h4 id="modal-orcamento-title">Orçamento #0001</h4>
                        <p class="text-muted" id="modal-cliente-nome">Cliente</p>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card bg-secondary text-white">
                                <div class="card-body text-center py-3">
                                    <small class="d-block opacity-75">Status Atual</small>
                                    <span id="modal-status-atual" class="badge bg-white text-dark">Rascunho</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center py-3">
                                    <small class="d-block opacity-75">Novo Status</small>
                                    <span id="modal-status-novo" class="badge bg-white text-dark">Enviado</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        <span id="modal-status-descricao">Esta ação irá alterar o status do orçamento.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times me-2"></i>
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="modal-confirmar-status">
                        <i class="fa-solid fa-check me-2"></i>
                        Confirmar Alteração
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('Sucesso!', {!! json_encode(session('success')) !!}, 'success');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('Erro!', {!! json_encode(session('error')) !!}, 'error');
            });
        </script>
    @endif

    <script>
        // Debug: verificar dependências
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Bootstrap disponível:', typeof bootstrap !== 'undefined');
            console.log('jQuery disponível:', typeof $ !== 'undefined');
            console.log('showToast disponível:', typeof showToast !== 'undefined');
            
            // Inicializar dropdowns sem Bootstrap ou jQuery
            console.log('Inicializando dropdowns com JavaScript vanilla...');
            
            // Implementação manual de dropdown
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const dropdown = this.closest('.dropdown');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    
                    // Fechar outros dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(function(otherMenu) {
                        if (otherMenu !== menu) {
                            otherMenu.style.display = 'none';
                            otherMenu.removeAttribute('data-show');
                        }
                    });
                    
                    // Toggle este dropdown usando atributo data para controle de estado
                    const isOpen = menu.hasAttribute('data-show');
                    if (isOpen) {
                        menu.style.display = 'none';
                        menu.removeAttribute('data-show');
                    } else {
                        menu.style.display = 'block';
                        menu.setAttribute('data-show', 'true');
                    }
                });
            });
            
            // Fechar dropdown ao clicar fora
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.style.display = 'none';
                        menu.removeAttribute('data-show');
                    });
                }
            });
            
            console.log('Dropdowns inicializados:', dropdownToggles.length);
            
            // Event listeners para fechar modal
            const modal = document.getElementById('modal-status-change');
            if (modal) {
                // Fechar ao clicar no backdrop
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
                
                // Fechar ao clicar no botão cancelar
                const btnCancel = modal.querySelector('.btn-secondary');
                if (btnCancel) {
                    btnCancel.addEventListener('click', closeModal);
                }
                
                // Fechar ao pressionar ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && modal.style.display === 'block') {
                        closeModal();
                    }
                });
            }
            
            console.log('Event listeners do modal configurados');
        });
        
        // Função para fechar modal usando JavaScript vanilla
        function closeModal() {
            const modal = document.getElementById('modal-status-change');
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
            
            // Remover backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            
            // Garantir que todos os dropdowns sejam fechados
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.style.display = 'none';
                menu.removeAttribute('data-show');
            });
        }

        // Variáveis globais para o modal de status
        let currentOrcamentoId = null;
        let currentNewStatus = null;
        let currentDropdownButton = null;

        // Configurações de status
        const statusConfig = {
            'draft': {
                label: 'Rascunho',
                badge: 'bg-secondary text-white',
                description: 'O orçamento retornará ao estado de elaboração.'
            },
            'awaiting': {
                label: 'Aguardando',
                badge: 'bg-warning text-dark',
                description: 'O orçamento está pronto e aguardando envio ao cliente.'
            },
            'sent': {
                label: 'Enviado',
                badge: 'bg-primary text-white',
                description: 'O orçamento será marcado como enviado ao cliente.'
            },
            'approved': {
                label: 'Aprovado',
                badge: 'bg-success text-white',
                description: 'O orçamento será marcado como aprovado pelo cliente.'
            },
            'rejected': {
                label: 'Rejeitado',
                badge: 'bg-danger text-white',
                description: 'O orçamento será marcado como rejeitado pelo cliente.'
            },
            'expired': {
                label: 'Expirado',
                badge: 'bg-warning text-dark',
                description: 'O orçamento será marcado como expirado.'
            }
        };

        // Função para atualizar status do orçamento
        function updateStatus(orcamentoId, newStatus) {
            // Salvar informações para o modal
            currentOrcamentoId = orcamentoId;
            currentNewStatus = newStatus;
            currentDropdownButton = event.target.closest('.dropdown').querySelector('.dropdown-toggle');

            // Obter informações do orçamento da linha da tabela
            const row = event.target.closest('tr');
            const orcamentoNumber = row.querySelector('td:first-child').textContent.trim();
            const clienteNome = row.querySelector('.font-weight-medium').textContent.trim();
            const currentStatusElement = currentDropdownButton;
            const currentStatus = currentStatusElement.textContent.trim();

            // Atualizar conteúdo do modal
            document.getElementById('modal-orcamento-title').textContent = orcamentoNumber;
            document.getElementById('modal-cliente-nome').textContent = clienteNome;
            
            // Status atual
            const modalStatusAtual = document.getElementById('modal-status-atual');
            modalStatusAtual.textContent = currentStatus;
            modalStatusAtual.className = 'badge ' + currentDropdownButton.className.split(' ').filter(c => c.startsWith('bg-')).join(' ');

            // Novo status
            const modalStatusNovo = document.getElementById('modal-status-novo');
            modalStatusNovo.textContent = statusConfig[newStatus].label;
            modalStatusNovo.className = 'badge ' + statusConfig[newStatus].badge;

            // Descrição
            document.getElementById('modal-status-descricao').textContent = statusConfig[newStatus].description;

            // Fechar todos os dropdowns antes de abrir o modal
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.style.display = 'none';
                menu.removeAttribute('data-show');
            });

            // Mostrar modal usando JavaScript vanilla
            const modal = document.getElementById('modal-status-change');
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');
            
            // Criar backdrop se não existir
            let backdrop = document.querySelector('.modal-backdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
        }

        // Confirmar mudança de status
        document.getElementById('modal-confirmar-status').addEventListener('click', function() {
            const button = this;
            const originalText = button.innerHTML;
            
            // Mostrar loading no botão do modal
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Alterando...';
            button.disabled = true;

            // Mostrar loading no dropdown também
            const originalDropdownText = currentDropdownButton.innerHTML;
            currentDropdownButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Atualizando...';
            currentDropdownButton.disabled = true;

            // Enviar requisição AJAX
            fetch(`/orcamentos/${currentOrcamentoId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: currentNewStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fechar modal usando JavaScript vanilla
                    const modal = document.getElementById('modal-status-change');
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    
                    // Remover backdrop
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    
                    // Mostrar toast de sucesso
                    if (typeof showToast === 'function') {
                        showToast('Sucesso!', 'Status alterado com sucesso!', 'success');
                    } else {
                        alert('Status alterado com sucesso!');
                    }
                    
                    // Atualizar a interface após um pequeno delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Erro ao atualizar status');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                
                // Fechar modal
                closeModal();
                
                // Mostrar erro
                if (typeof showToast === 'function') {
                    showToast('Erro!', error.message || 'Erro ao atualizar status', 'error');
                } else {
                    alert('Erro: ' + (error.message || 'Erro ao atualizar status'));
                }
                
                // Restaurar botões
                button.innerHTML = originalText;
                button.disabled = false;
                currentDropdownButton.innerHTML = originalDropdownText;
                currentDropdownButton.disabled = false;
            });
        });
    </script>

    <style>
        /* Melhorias para o botão PDF */
        .pdf-btn:hover {
            background: linear-gradient(45deg, #0056b3, #004085) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4) !important;
        }

        .pdf-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3) !important;
        }

        .pdf-btn i {
            animation: pulse-pdf 2s infinite;
        }

        @keyframes pulse-pdf {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Tooltip customizado para PDF */
        .pdf-btn[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 5px;
        }

        /* Melhorar aparência geral dos botões de ação */
        .btn-list .btn {
            margin-right: 3px;
            border-radius: 6px;
        }

        .btn-list .btn:last-child {
            margin-right: 0;
        }

        /* Responsividade - esconder texto PDF em telas pequenas */
        @media (max-width: 991px) {
            .pdf-btn .d-none.d-lg-inline {
                display: none !important;
            }
        }

        /* Estilos para dropdown de status */
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            min-width: 250px;
            z-index: 1050;
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-toggle::after {
            content: '';
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        
        .dropdown-toggle.bg-secondary,
        .dropdown-toggle.bg-primary,
        .dropdown-toggle.bg-success,
        .dropdown-toggle.bg-danger,
        .dropdown-toggle.bg-warning {
            color: white !important;
        }

        .dropdown-toggle.bg-warning {
            color: #000 !important;
        }

        .dropdown-item {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.active {
            background-color: #e9ecef;
            color: #495057;
        }

        .dropdown-item .badge {
            font-size: 0.7rem;
            min-width: 60px;
            display: inline-block;
            text-align: center;
        }

        /* Animação suave para mudança de status */
        .dropdown-toggle {
            transition: all 0.3s ease;
        }

        .dropdown-toggle:disabled {
            opacity: 0.7;
        }

        /* Estilos para o modal de status */
        #modal-status-change .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
        }

        #modal-status-change .modal-header .btn-close {
            filter: invert(1);
        }

        #modal-status-change .avatar {
            background: rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        /* Fix para posicionamento dos dropdowns */
        .table .dropdown {
            position: relative;
        }
        
        .table .dropdown-menu {
            position: absolute;
            z-index: 1050;
            min-width: 200px;
            right: 0;
            left: auto;
        }
        
        .table .dropdown-menu.dropdown-menu-end {
            right: 0;
            left: auto;
            transform: none !important;
        }
        
        /* Garantir que o dropdown apareça acima da tabela */
        .table-responsive {
            overflow: visible;
        }
        
        .card .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
        }
        
        /* Fix específico para Bootstrap dropdowns */
        .dropdown-menu[data-bs-popper] {
            right: 0 !important;
            left: auto !important;
        }

        #modal-status-change .card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #modal-status-change .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        #modal-status-change .badge {
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        #modal-status-change .alert {
            border-left: 4px solid #17a2b8;
            border-radius: 8px;
            background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
        }

        /* Animação para o modal */
        #modal-status-change.fade .modal-dialog {
            transform: translate(0, -50px);
            transition: transform 0.3s ease-out;
        }

        #modal-status-change.show .modal-dialog {
            transform: translate(0, 0);
        }

        /* Efeito hover nos botões do modal */
        #modal-status-change .btn {
            transition: all 0.3s ease;
            border-radius: 25px;
            font-weight: 500;
            padding: 8px 20px;
        }

        #modal-status-change .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Estilos para a legenda */
        .alert.border-0 {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .alert .fa-solid {
            width: 16px;
            text-align: center;
        }

        /* Estilos para a legenda de status */
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            min-width: 70px;
            display: inline-block;
            text-align: center;
        }

        .text-sm small {
            font-size: 0.7rem;
            line-height: 1.2;
        }

        /* Responsividade da legenda */
        @media (max-width: 768px) {
            .alert .row .col-6 {
                margin-bottom: 8px;
            }

            .text-sm {
                font-size: 0.8rem;
            }

            .text-sm small {
                font-size: 0.65rem;
            }

            .badge {
                min-width: 60px;
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .col-md-2 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
        
        /* Estilos para o botão de enviar email */
        .btn-outline-warning:hover {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
        
        .btn-outline-warning {
            transition: all 0.3s ease;
        }
        
        /* Estilos para o modal de envio de email */
        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }
        
        .avatar.bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%) !important;
        }
        
        .alert-info {
            border-left: 4px solid #0dcaf0;
        }
    </style>
@endsection
