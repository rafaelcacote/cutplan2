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
                                               value="{{ request('search_cliente') }}" 
                                               placeholder="Nome do cliente">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="search_status">
                                            <option value="">Todos</option>
                                            <option value="draft" {{ request('search_status') == 'draft' ? 'selected' : '' }}>Rascunho</option>
                                            <option value="sent" {{ request('search_status') == 'sent' ? 'selected' : '' }}>Enviado</option>
                                            <option value="approved" {{ request('search_status') == 'approved' ? 'selected' : '' }}>Aprovado</option>
                                            <option value="rejected" {{ request('search_status') == 'rejected' ? 'selected' : '' }}>Rejeitado</option>
                                            <option value="expired" {{ request('search_status') == 'expired' ? 'selected' : '' }}>Expirado</option>
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
                    @forelse($orcamentos as $orcamento)
                        @if($loop->first)
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Validade</th>
                                            <th>Criado em</th>
                                            <th>Ações</th>
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
                                        <div class="font-weight-medium">{{ $orcamento->cliente->nome }}</div>
                                        <div class="text-muted">{{ $orcamento->cliente->email ?? 'Sem email' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $orcamento->status_badge }} badge-sm">
                                    {{ $orcamento->status_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <strong>R$ {{ number_format($orcamento->total, 2, ',', '.') }}</strong>
                                @if($orcamento->desconto > 0)
                                    <br><small class="text-muted">Desc: R$ {{ number_format($orcamento->desconto, 2, ',', '.') }}</small>
                                @endif
                            </td>
                            <td>
                                @if($orcamento->validade)
                                    <span class="{{ $orcamento->validade < now() ? 'text-danger' : 'text-muted' }}">
                                        {{ $orcamento->validade->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-muted">
                                {{ $orcamento->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('orcamentos.show', $orcamento) }}" 
                                       class="btn btn-outline-primary btn-sm" title="Visualizar">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('orcamentos.edit', $orcamento) }}" 
                                       class="btn btn-outline-secondary btn-sm" title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modal-excluir-{{ $orcamento->id }}" title="Excluir">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        @if($loop->last)
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

                    @if($orcamentos->hasPages())
                        <div class="card-footer">
                            {{ $orcamentos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modais de Exclusão -->
    @foreach($orcamentos as $orcamento)
        <div class="modal modal-blur fade" id="modal-excluir-{{ $orcamento->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                        <h3>Tem certeza?</h3>
                        <div class="text-muted">
                            Você realmente deseja excluir o orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }} 
                            de <strong>{{ $orcamento->cliente->nome }}</strong>?
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
                                    <form method="POST" action="{{ route('orcamentos.destroy', $orcamento) }}" class="d-inline">
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
    @endforeach

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toast simples para notificações
                const toast = document.createElement('div');
                toast.className = 'alert alert-success alert-dismissible position-fixed';
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div>
                            <i class="fa-solid fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Auto-remover após 5 segundos
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 5000);
            });
        </script>
    @endif
@endsection
