@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administração</div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-briefcase icon me-2"></i>
                        Serviços
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('servicos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <i class="fa-solid fa-plus icon"></i>
                            Novo Serviço
                        </a>
                        <a href="{{ route('servicos.create') }}" class="btn btn-primary d-sm-none btn-icon">
                            <i class="fa-solid fa-plus icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @include('components.toast')
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showToast('Sucesso!', @json(session('success')), 'success');
                    });
                </script>
            @endif
            <!-- Filtros de Pesquisa -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('servicos.index') }}" class="row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fa-solid fa-briefcase"></i>
                                        </span>
                                        <input type="text" class="form-control" id="nome" name="nome" value="{{ request('nome') }}" placeholder="Pesquisar por nome...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="ativo" class="form-label">Status</label>
                                    <select class="form-select" id="ativo" name="ativo">
                                        <option value="">Todos</option>
                                        <option value="1" @if(request('ativo')==='1') selected @endif>Ativo</option>
                                        <option value="0" @if(request('ativo')==='0') selected @endif>Inativo</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="btn-group w-100" role="group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-search me-1"></i>
                                            Pesquisar
                                        </button>
                                        <a href="{{ route('servicos.index') }}" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-times me-1"></i>
                                            Limpar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Lista de Serviços -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Serviços</h3>
                    <span class="badge bg-blue-lt ms-2">{{ $servicos->total() }} registros</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Itens</th>
                                <th>Status</th>
                                <th>Criado em</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servicos as $servico)
                                <tr>
                                    <td>{{ $servico->id }}</td>
                                    <td>{{ $servico->nome }}</td>
                                    <td>
                                        @if($servico->itensServico->count() > 0)
                                            <span class="badge bg-blue-lt" 
                                                  data-bs-toggle="tooltip" 
                                                  data-bs-placement="top" 
                                                  data-bs-html="true"
                                                  title="<strong>Itens do serviço:</strong><br>@foreach($servico->itensServico->take(5) as $item)• {{ Str::limit($item->descricao_item, 30) }}<br>@endforeach@if($servico->itensServico->count() > 5)... e mais {{ $servico->itensServico->count() - 5 }} itens@endif">
                                                {{ $servico->itensServico->count() }} itens
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-lt">0 itens</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($servico->ativo)
                                            <span class="badge bg-green-lt">Ativo</span>
                                        @else
                                            <span class="badge bg-red-lt">Inativo</span>
                                        @endif
                                    </td>
                                    <td>{{ $servico->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('servicos.show', $servico) }}" class="btn btn-outline-primary btn-sm" title="Ver Detalhes e Gerenciar Itens"><i class="fa-solid fa-eye"></i></a>
                                            <button type="button" class="btn btn-outline-success btn-sm" 
                                                    title="Adicionar Item Rápido" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modal-adicionar-item"
                                                    data-servico-id="{{ $servico->id }}"
                                                    data-servico-nome="{{ $servico->nome }}">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <a href="{{ route('servicos.edit', $servico) }}" class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $servico->id }}"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                        <!-- Modal de Exclusão -->
                                        <div class="modal modal-blur fade" id="modal-excluir-{{ $servico->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirmar Exclusão</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja excluir o serviço <strong>{{ $servico->nome }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="{{ route('servicos.destroy', $servico) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <i class="fa-solid fa-box-open fa-3x text-muted mb-2"></i>
                                        <div class="mb-2">Nenhum serviço cadastrado.</div>
                                        <a href="{{ route('servicos.create') }}" class="btn btn-primary">Cadastrar o primeiro serviço</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    {{ $servicos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar Item Rápido -->
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
                    <input type="hidden" name="servico_id" id="modal-servico-id">
                    
                    <div class="mb-3">
                        <label class="form-label">Serviço:</label>
                        <div class="form-control-plaintext fw-bold" id="modal-servico-nome"></div>
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

<script>
// Script para o modal de adicionar item
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips (com verificação se Bootstrap está disponível)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    const modalAdicionarItem = document.getElementById('modal-adicionar-item');
    const modalServicoId = document.getElementById('modal-servico-id');
    const modalServicoNome = document.getElementById('modal-servico-nome');
    const modalDescricaoItem = document.getElementById('modal-descricao-item');
    
    modalAdicionarItem.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const servicoId = button.getAttribute('data-servico-id');
        const servicoNome = button.getAttribute('data-servico-nome');
        
        modalServicoId.value = servicoId;
        modalServicoNome.textContent = servicoNome;
        modalDescricaoItem.value = '';
        modalDescricaoItem.focus();
    });
    
    // Limpar modal ao fechar
    modalAdicionarItem.addEventListener('hidden.bs.modal', function (event) {
        modalServicoId.value = '';
        modalServicoNome.textContent = '';
        modalDescricaoItem.value = '';
    });
    
    // Adicionar event listeners para fechar modal
    modalAdicionarItem.querySelector('.btn-close').addEventListener('click', function() {
        fecharModal(modalAdicionarItem);
    });
    
    modalAdicionarItem.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function() {
        fecharModal(modalAdicionarItem);
    });
    
    // Função para fechar modal
    function fecharModal(modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
    }
    
    // Envio do formulário via AJAX
    document.getElementById('form-adicionar-item').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const servicoId = modalServicoId.value;
        const descricaoItem = modalDescricaoItem.value.trim();
        
        if (!descricaoItem) {
            showToast('Erro', 'A descrição do item é obrigatória.', 'error');
            return;
        }
        
        if (!servicoId) {
            showToast('Erro', 'Serviço não selecionado.', 'error');
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
                showToast('Sucesso!', 'Item adicionado com sucesso!', 'success');
                // Fechar modal usando função criada
                fecharModal(modalAdicionarItem);
                
                // Atualizar contador de itens na interface
                setTimeout(() => {
                    location.reload();
                }, 1000);
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
</script>

@endsection
