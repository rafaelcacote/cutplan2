@extends('layouts.app')

@section('content')
<style>
    .autocomplete-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1050 !important;
        display: none;
        margin-top: 2px;
    }
    .autocomplete-item {
        padding: 12px 16px;
        cursor: pointer;
        border-bottom: 1px solid #f1f3f4;
        transition: background-color 0.2s ease;
        font-size: 14px;
    }
    .autocomplete-item:hover,
    .autocomplete-item.selected {
        background-color: #e3f2fd !important;
        color: #1976d2;
    }
    .autocomplete-item:last-child {
        border-bottom: none;
    }
    .autocomplete-container {
        position: relative;
    }
    .member-item {
        transition: all 0.2s ease;
    }
    .member-item:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="page-wrapper">
    @include('components.toast')
    @if(session('success'))
        <script>showToast('Sucesso!', @json(session('success')), 'success');</script>
    @endif
    @if(session('error'))
        <script>showToast('Atenção!', @json(session('error')), 'error');</script>
    @endif

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('equipes.index') }}" class="btn-link">Equipes</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-users fa-lg me-2"></i>
                        Gerenciar Membros da Equipe: {{ $equipe->nome }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('equipes.show', $equipe) }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-eye me-2"></i> Visualizar
                        </a>
                        <a href="{{ route('equipes.index') }}" class="btn btn-outline-secondary">
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
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Adicionar Membro</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Membro</label>
                                <div class="position-relative autocomplete-container">
                                    <input type="text" 
                                           class="form-control" 
                                           id="membro-search" 
                                           placeholder="Digite para buscar um membro..."
                                           autocomplete="off">
                                    <div id="autocomplete-dropdown" class="autocomplete-dropdown"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Função</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="funcao-input" 
                                       placeholder="Ex: Desenvolvedor, Analista..."
                                       maxlength="100">
                            </div>
                            <button type="button" 
                                    class="btn btn-primary" 
                                    id="btn-adicionar"
                                    disabled>
                                <i class="fa-solid fa-plus me-2"></i>
                                Adicionar Membro
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Membros da Equipe ({{ $equipe->membros->count() }})</h3>
                        </div>
                        <div class="card-body p-0">
                            <div id="lista-membros">
                                @if($equipe->membros->count())
                                    @foreach($equipe->membros as $membro)
                                        <div class="member-item p-3 border-bottom" data-membro-id="{{ $membro->id }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-3 bg-blue-lt">
                                                        <i class="fa-solid fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $membro->nome }}</div>
                                                        <div class="text-muted small">
                                                            {{ $membro->pivot->funcao ?: 'Membro' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm btn-remover"
                                                        data-membro-id="{{ $membro->id }}"
                                                        data-membro-nome="{{ $membro->nome }}"
                                                        title="Remover membro">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5" id="empty-state">
                                        <i class="fa-solid fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                                        <h4>Nenhum membro na equipe</h4>
                                        <p class="text-muted">Adicione membros para começar a formar sua equipe.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão de Membro -->
<div class="modal modal-blur fade" id="modalRemoverMembro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <i class="fa-solid fa-triangle-exclamation icon mb-2 text-danger icon-lg"></i>
                <h3>Tem certeza?</h3>
                <div class="text-muted">Você realmente deseja remover o membro <strong id="modal-membro-nome"></strong> desta equipe? Esta ação não pode ser desfeita.</div>
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
                            <button type="button" class="btn btn-danger w-100" id="btnConfirmarRemocao">
                                Remover
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const membrosDisponiveis = @json($membros);
    console.log('Membros disponíveis:', membrosDisponiveis); // Debug
    
    const searchInput = document.getElementById('membro-search');
    const dropdown = document.getElementById('autocomplete-dropdown');
    const funcaoInput = document.getElementById('funcao-input');
    const btnAdicionar = document.getElementById('btn-adicionar');
    const listaMembros = document.getElementById('lista-membros');
    
    if (!searchInput || !dropdown) {
        console.error('Elementos não encontrados:', { searchInput, dropdown });
        return;
    }
    
    let membroSelecionado = null;
    let selectedIndex = -1;

    // Autocomplete
    searchInput.addEventListener('input', function() {
        console.log('Input evento disparado, valor:', this.value); // Debug
        const query = this.value.toLowerCase().trim();
        dropdown.innerHTML = '';
        selectedIndex = -1;
        
        if (!query) {
            dropdown.style.display = 'none';
            membroSelecionado = null;
            btnAdicionar.disabled = true;
            return;
        }

        const filtered = membrosDisponiveis.filter(m => 
            m.nome.toLowerCase().includes(query)
        );
        
        console.log('Membros filtrados:', filtered); // Debug

        if (filtered.length > 0) {
            filtered.forEach((membro, index) => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = membro.nome;
                item.addEventListener('click', () => selecionarMembro(membro));
                dropdown.appendChild(item);
            });
            dropdown.style.display = 'block';
            console.log('Dropdown mostrado com', filtered.length, 'itens'); // Debug
        } else {
            dropdown.style.display = 'none';
            console.log('Nenhum resultado encontrado'); // Debug
        }
    });

    // Navegação por teclado
    searchInput.addEventListener('keydown', function(e) {
        const items = dropdown.querySelectorAll('.autocomplete-item');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
            updateSelection(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, -1);
            updateSelection(items);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedIndex >= 0 && items[selectedIndex]) {
                const nome = items[selectedIndex].textContent;
                const membro = membrosDisponiveis.find(m => m.nome === nome);
                selecionarMembro(membro);
            }
        } else if (e.key === 'Escape') {
            dropdown.style.display = 'none';
        }
    });

    function updateSelection(items) {
        items.forEach((item, index) => {
            item.classList.toggle('selected', index === selectedIndex);
        });
    }

    function selecionarMembro(membro) {
        membroSelecionado = membro;
        searchInput.value = membro.nome;
        dropdown.style.display = 'none';
        btnAdicionar.disabled = false;
        funcaoInput.focus();
    }

    // Enter no campo de função para adicionar membro
    funcaoInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if (membroSelecionado && !btnAdicionar.disabled) {
                btnAdicionar.click();
            }
        }
    });

    // Fechar dropdown ao clicar fora
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    // Adicionar membro
    btnAdicionar.addEventListener('click', function() {
        if (!membroSelecionado) return;

        const button = this;
        const originalText = button.innerHTML;
        
        // Desabilitar botão e mostrar loading
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adicionando...';

        fetch(`{{ route('equipes.membros.adicionar', $equipe->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                membro_id: membroSelecionado.id,
                funcao: funcaoInput.value.trim()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Sucesso!', data.success, 'success');
                adicionarMembroNaLista(membroSelecionado, funcaoInput.value.trim());
                limparFormulario();
            } else {
                showToast('Erro!', data.error || 'Erro ao adicionar membro', 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showToast('Erro!', 'Erro ao adicionar membro', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalText;
        });
    });

    function adicionarMembroNaLista(membro, funcao) {
        // Remove empty state se existir
        const emptyState = document.getElementById('empty-state');
        if (emptyState) {
            emptyState.remove();
        }

        const memberItem = document.createElement('div');
        memberItem.className = 'member-item p-3 border-bottom';
        memberItem.setAttribute('data-membro-id', membro.id);
        memberItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-3 bg-blue-lt">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <div class="fw-medium">${membro.nome}</div>
                        <div class="text-muted small">${funcao || 'Membro(a)'}</div>
                    </div>
                </div>
                <button type="button" 
                        class="btn btn-outline-danger btn-sm btn-remover"
                        data-membro-id="${membro.id}"
                        data-membro-nome="${membro.nome}"
                        title="Remover membro">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
        
        listaMembros.appendChild(memberItem);
        
        // Adicionar event listener para o novo botão
        memberItem.querySelector('.btn-remover').addEventListener('click', function() {
            const membroId = this.getAttribute('data-membro-id');
            const membroNome = this.getAttribute('data-membro-nome');
            confirmarRemocao(membroId, membroNome);
        });

        // Remove o membro da lista de disponíveis
        const index = membrosDisponiveis.findIndex(m => m.id === membro.id);
        if (index > -1) {
            membrosDisponiveis.splice(index, 1);
        }
    }

    function limparFormulario() {
        searchInput.value = '';
        funcaoInput.value = '';
        membroSelecionado = null;
        btnAdicionar.disabled = true;
        dropdown.style.display = 'none';
        
        // Voltar o foco para o campo de autocomplete
        setTimeout(() => {
            searchInput.focus();
        }, 100);
    }

    // Event listeners para botões de remover existentes
    document.querySelectorAll('.btn-remover').forEach(button => {
        button.addEventListener('click', function() {
            const membroId = this.getAttribute('data-membro-id');
            const membroNome = this.getAttribute('data-membro-nome');
            confirmarRemocao(membroId, membroNome);
        });
    });

    // Variáveis para controle do modal
    let membroIdParaRemover = null;
    let membroNomeParaRemover = '';

    function confirmarRemocao(membroId, membroNome) {
        membroIdParaRemover = membroId;
        membroNomeParaRemover = membroNome;
        // Atualiza o nome no modal
        document.getElementById('modal-membro-nome').textContent = membroNome;
        const modalElement = document.getElementById('modalRemoverMembro');
        
        // Tenta usar Bootstrap de diferentes formas possíveis
        let Modal;
        if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
            Modal = window.bootstrap.Modal;
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            Modal = bootstrap.Modal;
        } else {
            // Se ainda não encontrou, usa atributos data-bs para abrir o modal
            modalElement.classList.add('show');
            modalElement.style.display = 'block';
            modalElement.setAttribute('aria-modal', 'true');
            modalElement.setAttribute('role', 'dialog');
            modalElement.removeAttribute('aria-hidden');
            document.body.classList.add('modal-open');
            return;
        }
        
        const modal = new Modal(modalElement);
        modal.show();
    }

    // Handler para botão de confirmação do modal
    document.getElementById('btnConfirmarRemocao').addEventListener('click', function() {
        if (membroIdParaRemover) {
            removerMembro(membroIdParaRemover);
            membroIdParaRemover = null;
            membroNomeParaRemover = '';
            // Fechar modal
            const modalElement = document.getElementById('modalRemoverMembro');
            
            // Tenta usar Bootstrap de diferentes formas possíveis
            let Modal;
            if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
                Modal = window.bootstrap.Modal;
                const modal = Modal.getInstance(modalElement);
                if (modal) modal.hide();
            } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                Modal = bootstrap.Modal;
                const modal = Modal.getInstance(modalElement);
                if (modal) modal.hide();
            } else {
                // Se não conseguir usar Bootstrap JS, fecha manualmente
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                modalElement.setAttribute('aria-hidden', 'true');
                modalElement.removeAttribute('aria-modal');
                modalElement.removeAttribute('role');
                document.body.classList.remove('modal-open');
                // Remove backdrop se existir
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        }
    });

    // Remover membro
    function removerMembro(membroId) {
        fetch(`{{ url('equipes/' . $equipe->id . '/membros') }}/${membroId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Sucesso!', data.success, 'success');
                removerMembroDaLista(membroId);
            } else {
                showToast('Erro!', data.error || 'Erro ao remover membro', 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showToast('Erro!', 'Erro ao remover membro', 'error');
        });
    }

    function removerMembroDaLista(membroId) {
        const memberItem = document.querySelector(`[data-membro-id="${membroId}"]`);
        if (memberItem) {
            memberItem.remove();
            
            // Se não há mais membros, mostrar empty state
            if (listaMembros.children.length === 0) {
                listaMembros.innerHTML = `
                    <div class="text-center py-5" id="empty-state">
                        <i class="fa-solid fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4>Nenhum membro na equipe</h4>
                        <p class="text-muted">Adicione membros para começar a formar sua equipe.</p>
                    </div>
                `;
            }
        }
    }
});
</script>

@endsection
                                 