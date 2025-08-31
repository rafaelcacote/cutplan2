
@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('servicos.index') }}" class="btn-link">Serviços</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-briefcase fa-lg me-2"></i>
                        Visualizar Serviço
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('servicos.edit', $servico) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('servicos.index') }}" class="btn btn-outline-secondary">
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
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <span class="avatar avatar-xl bg-primary-lt"><i class="fa-solid fa-briefcase fa-2x text-primary"></i></span>
                            </div>
                            <h3 class="m-0 mb-1">{{ $servico->nome }}</h3>
                            <div class="text-muted">ID: {{ $servico->id }}</div>
                            <div class="mt-3">
                                <span class="badge bg-{{ $servico->ativo ? 'green' : 'red' }}-lt">{{ $servico->ativo ? 'Ativo' : 'Inativo' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Informações do Sistema
                            </h3>
                        </div>
                        <div class="card-body">
                            <div><strong>Criado em:</strong> {{ $servico->created_at->format('d/m/Y H:i') }}</div>
                            <div><strong>Atualizado em:</strong> {{ $servico->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">Dados do Serviço</div>
                        <div class="card-body row">
                            <div class="col-lg-8 mb-3">
                                <label class="form-label">Nome</label>
                                <div class="form-control-plaintext">{{ $servico->nome }}</div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Ativo</label>
                                <div class="form-control-plaintext">{{ $servico->ativo ? 'Sim' : 'Não' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Seção de Itens do Serviço -->
                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="card-title">
                                    <i class="fa-solid fa-list me-2"></i>
                                    Itens do Serviço
                                </h3>
                                <span class="badge bg-blue-lt ms-2">{{ $itens->total() }} itens</span>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal-adicionar-item">
                                <i class="fa-solid fa-plus me-2"></i>
                                Adicionar Item
                            </button>
                        </div>
                        
                        <!-- Filtro de Pesquisa -->
                        @if($itens->total() > 5)
                            <div class="card-body border-bottom">
                                <form method="GET" action="{{ route('servicos.show', $servico) }}" class="row g-3">
                                    <div class="col-md-8">
                                        <label for="search" class="form-label">Buscar item</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-search"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search" name="search" 
                                                   value="{{ request('search') }}" 
                                                   placeholder="Pesquisar por descrição do item...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-outline-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Buscar
                                            </button>
                                            @if(request('search'))
                                                <a href="{{ route('servicos.show', $servico) }}" class="btn btn-outline-secondary">
                                                    <i class="fa-solid fa-times me-1"></i>
                                                    Limpar
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        
                        @if($itens->count() > 0)
                            <div class="card-header">
                                <h3 class="card-title">Lista de Itens</h3>
                                <div class="card-actions">
                                    <span class="text-muted">{{ $itens->total() }} item(ns) encontrado(s)</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th width="50">ID</th>
                                            <th>Descrição do Item</th>
                                            <th width="120">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itens-table-body">
                                        @foreach($itens as $item)
                                            <tr id="item-row-{{ $item->id }}">
                                                <td>{{ $item->id }}</td>
                                                <td>
                                                    <div class="item-descricao">{{ $item->descricao_item }}</div>
                                                    <div class="item-edit-form" style="display: none;">
                                                        <textarea class="form-control form-control-sm" rows="2">{{ $item->descricao_item }}</textarea>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-list item-actions">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                                onclick="editarItem({{ $item->id }})" title="Editar">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                                onclick="excluirItem({{ $item->id }}, '{{ addslashes($item->descricao_item) }}')" title="Excluir">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="btn-list item-edit-actions" style="display: none;">
                                                        <button type="button" class="btn btn-success btn-sm" 
                                                                onclick="salvarItem({{ $item->id }})" title="Salvar">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                                onclick="cancelarEdicao({{ $item->id }})" title="Cancelar">
                                                            <i class="fa-solid fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Paginação -->
                            @if($itens instanceof \Illuminate\Pagination\LengthAwarePaginator && $itens->hasPages())
                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-center">
                                        <ul class="pagination">
                                            {{-- Previous Page Link --}}
                                            <li class="page-item{{ $itens->onFirstPage() ? ' disabled' : '' }}">
                                                <a class="page-link" href="{{ $itens->previousPageUrl() ?? '#' }}" tabindex="-1"
                                                    aria-disabled="{{ $itens->onFirstPage() ? 'true' : 'false' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                        <path d="M15 6l-6 6l6 6"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                            {{-- Pagination Elements --}}
                                            @foreach ($itens->links()->elements[0] as $page => $url)
                                                @if ($url)
                                                    <li class="page-item{{ $page == $itens->currentPage() ? ' active' : '' }}">
                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled"><span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                            {{-- Next Page Link --}}
                                            <li class="page-item{{ $itens->hasMorePages() ? '' : ' disabled' }}">
                                                <a class="page-link" href="{{ $itens->nextPageUrl() ?? '#' }}"
                                                    aria-disabled="{{ $itens->hasMorePages() ? 'false' : 'true' }}">
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
                        @else
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th width="50">ID</th>
                                            <th>Descrição do Item</th>
                                            <th width="120">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="3" class="text-center py-4">
                                                @if(request('search'))
                                                    <div class="empty">
                                                        <div class="empty-icon">
                                                            <i class="fa-solid fa-search fa-3x text-muted mb-3"></i>
                                                        </div>
                                                        <p class="empty-title">Nenhum item encontrado</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Não foram encontrados itens que correspondam ao termo "{{ request('search') }}".
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('servicos.show', $servico) }}" class="btn btn-outline-primary">
                                                                <i class="fa-solid fa-times me-2"></i>
                                                                Limpar Filtro
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="empty">
                                                        <div class="empty-icon">
                                                            <i class="fa-solid fa-inbox fa-3x text-muted mb-3"></i>
                                                        </div>
                                                        <p class="empty-title">Nenhum item cadastrado</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Este serviço ainda não possui itens cadastrados.
                                                        </p>
                                                        <div class="empty-action">
                                                            <button type="button" class="btn btn-primary" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#modal-adicionar-item">
                                                                <i class="fa-solid fa-plus me-2"></i>
                                                                Adicionar primeiro item
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar Item -->
<div class="modal modal-blur fade" id="modal-adicionar-item" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-adicionar-item">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-plus me-2"></i>
                        Adicionar Item ao Serviço
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Serviço:</label>
                        <div class="form-control-plaintext fw-bold">{{ $servico->nome }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal-descricao-item" class="form-label required">Descrição do Item</label>
                        <textarea name="descricao_item" id="modal-descricao-item" class="form-control" required rows="3" placeholder="Digite a descrição do item..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check me-2"></i>
                        Adicionar Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal modal-blur fade" id="modal-excluir-item" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o item?</p>
                <div class="alert alert-warning">
                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                    <strong id="item-descricao-excluir"></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-confirmar-exclusao">
                    <i class="fa-solid fa-trash me-2"></i>
                    Excluir
                </button>
            </div>
        </div>
    </div>
</div>

@include('components.toast')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips (com verificação se Bootstrap está disponível)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    const servicoId = {{ $servico->id }};
    
    // Função para fechar modal
    function fecharModal(modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
    }
    
    // Event listeners para fechar modais
    document.querySelectorAll('.btn-close, [data-bs-dismiss="modal"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) fecharModal(modal);
        });
    });
    
    // Auto-submit do formulário de busca ao digitar (com delay)
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let timeoutId;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 800); // Aguarda 800ms após parar de digitar
        });
    }
    
    // Adicionar novo item
    document.getElementById('form-adicionar-item').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const descricaoItem = document.getElementById('modal-descricao-item').value.trim();
        
        if (!descricaoItem) {
            showToast('Erro', 'A descrição do item é obrigatória.', 'error');
            return;
        }
        
        // Verificar se já existe um item com esta descrição (verificação do lado cliente)
        const existingItems = Array.from(document.querySelectorAll('.item-descricao')).map(el => el.textContent.trim().toLowerCase());
        if (existingItems.includes(descricaoItem.toLowerCase())) {
            showToast('Erro', 'Já existe um item com esta descrição neste serviço.', 'error');
            return;
        }
        
        // Desabilitar botão durante o envio
        const btnSubmit = this.querySelector('button[type="submit"]');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Adicionando...';
        
        fetch('{{ route("itens-servico.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                descricao_item: descricaoItem,
                servico_id: parseInt(servicoId)
            })
        })
        .then(response => {
            console.log('Debug - Response status:', response.status);
            console.log('Debug - Response headers:', response.headers);
            if (!response.ok) {
                if (response.status === 422) {
                    // Erro de validação
                    return response.json().then(data => {
                        const errors = data.errors || {};
                        const firstError = Object.values(errors)[0];
                        throw new Error(firstError ? firstError[0] : 'Erro de validação');
                    });
                }
                throw new Error('Erro na requisição: ' + response.status);
            }
            return response.text().then(text => {
                console.log('Debug - Raw response:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Debug - Erro ao fazer parse do JSON:', e);
                    console.log('Debug - Resposta recebida não é JSON válido:', text.substring(0, 200));
                    throw new Error('Resposta não é JSON válido');
                }
            });
        })
        .then(data => {
            if (data.success) {
                showToast('Sucesso!', 'Item adicionado com sucesso!', 'success');
                
                // Recarregar a página mantendo os parâmetros de busca atuais
                const currentUrl = new URL(window.location);
                window.location.href = currentUrl.href;
            } else {
                showToast('Erro', data.message || 'Erro ao adicionar item.', 'error');
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            showToast('Erro', 'Erro ao adicionar item: ' + error.message, 'error');
        })
        .finally(() => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="fa-solid fa-check me-2"></i>Adicionar Item';
        });
    });
});

// Função para fechar modal (global)
function fecharModal(modal) {
    modal.style.display = 'none';
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.remove();
}

// Funções para edição inline
function editarItem(itemId) {
    const row = document.getElementById(`item-row-${itemId}`);
    const descricaoDiv = row.querySelector('.item-descricao');
    const editForm = row.querySelector('.item-edit-form');
    const actions = row.querySelector('.item-actions');
    const editActions = row.querySelector('.item-edit-actions');
    
    descricaoDiv.style.display = 'none';
    editForm.style.display = 'block';
    actions.style.display = 'none';
    editActions.style.display = 'flex';
    
    // Focar no textarea
    editForm.querySelector('textarea').focus();
}

function cancelarEdicao(itemId) {
    const row = document.getElementById(`item-row-${itemId}`);
    const descricaoDiv = row.querySelector('.item-descricao');
    const editForm = row.querySelector('.item-edit-form');
    const actions = row.querySelector('.item-actions');
    const editActions = row.querySelector('.item-edit-actions');
    
    descricaoDiv.style.display = 'block';
    editForm.style.display = 'none';
    actions.style.display = 'flex';
    editActions.style.display = 'none';
    
    // Restaurar valor original
    const textarea = editForm.querySelector('textarea');
    textarea.value = descricaoDiv.textContent;
}

function salvarItem(itemId) {
    const row = document.getElementById(`item-row-${itemId}`);
    const textarea = row.querySelector('.item-edit-form textarea');
    const novaDescricao = textarea.value.trim();
    
    if (!novaDescricao) {
        showToast('Erro', 'A descrição do item é obrigatória.', 'error');
        return;
    }
    
    // Verificar se já existe um item com esta descrição (excluindo o item atual)
    const existingItems = Array.from(document.querySelectorAll('.item-descricao'))
        .filter(el => el.closest('tr').id !== `item-row-${itemId}`)
        .map(el => el.textContent.trim().toLowerCase());
    
    if (existingItems.includes(novaDescricao.toLowerCase())) {
        showToast('Erro', 'Já existe um item com esta descrição neste serviço.', 'error');
        return;
    }
    
    // Desabilitar botões durante a edição
    const btnSalvar = row.querySelector('.item-edit-actions .btn-success');
    btnSalvar.disabled = true;
    btnSalvar.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
    
    fetch(`/itens-servico/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            descricao_item: novaDescricao,
            servico_id: {{ $servico->id }}
        })
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 422) {
                // Erro de validação
                return response.json().then(data => {
                    const errors = data.errors || {};
                    const firstError = Object.values(errors)[0];
                    throw new Error(firstError ? firstError[0] : 'Erro de validação');
                });
            }
            throw new Error('Erro na requisição: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Atualizar a descrição na interface
            const descricaoDiv = row.querySelector('.item-descricao');
            descricaoDiv.textContent = novaDescricao;
            
            cancelarEdicao(itemId);
            showToast('Sucesso!', 'Item atualizado com sucesso!', 'success');
        } else {
            showToast('Erro', data.message || 'Erro ao atualizar item.', 'error');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        showToast('Erro', 'Erro ao atualizar item.', 'error');
    })
    .finally(() => {
        btnSalvar.disabled = false;
        btnSalvar.innerHTML = '<i class="fa-solid fa-check"></i>';
    });
}

let itemIdParaExcluir = null;

function excluirItem(itemId, descricao) {
    itemIdParaExcluir = itemId;
    document.getElementById('item-descricao-excluir').textContent = descricao;
    
    // Abrir modal usando método nativo
    const modal = document.getElementById('modal-excluir-item');
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.classList.add('modal-open');
    
    // Criar backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    document.body.appendChild(backdrop);
}

document.getElementById('btn-confirmar-exclusao').addEventListener('click', function() {
    if (!itemIdParaExcluir) return;
    
    const btnConfirmar = this;
    btnConfirmar.disabled = true;
    btnConfirmar.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Excluindo...';
    
    fetch(`/itens-servico/${itemIdParaExcluir}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Remover a linha da tabela
            const row = document.getElementById(`item-row-${itemIdParaExcluir}`);
            row.remove();
            
            // Fechar modal usando método nativo
            const modal = document.getElementById('modal-excluir-item');
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            
            showToast('Sucesso!', 'Item excluído com sucesso!', 'success');
            
            // Verificar se não há mais itens na página atual e recarregar se necessário
            const tbody = document.getElementById('itens-table-body');
            if (tbody.children.length === 0) {
                // Se não há mais itens na página, recarregar para atualizar a paginação
                const currentUrl = new URL(window.location);
                window.location.href = currentUrl.href;
            }
        } else {
            showToast('Erro', data.message || 'Erro ao excluir item.', 'error');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        showToast('Erro', 'Erro ao excluir item.', 'error');
    })
    .finally(() => {
        btnConfirmar.disabled = false;
        btnConfirmar.innerHTML = '<i class="fa-solid fa-trash me-2"></i>Excluir';
        itemIdParaExcluir = null;
    });
});
</script>

@endsection
