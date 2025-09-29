@extends('layouts.app')

@section('content')
    @include('components.toast')
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
                            Novo Orçamento
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
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
                <form method="POST" action="{{ route('orcamentos.store') }}" id="form-orcamento">
                    @csrf

                    <!-- Etapa 1: Dados Básicos -->
                    <div class="card mb-3" id="etapa-dados">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span class="badge bg-primary text-white me-2">1</span>
                                Dados Básicos do Orçamento
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Cliente</label>
                                        <div class="position-relative">
                                            <input type="text"
                                                class="form-control @error('cliente_id') is-invalid @enderror"
                                                id="cliente-search" placeholder="Digite para buscar um cliente..."
                                                autocomplete="off">
                                            <input type="hidden" name="cliente_id" id="cliente_id" required>

                                            <!-- Dropdown de resultados -->
                                            <div id="cliente-dropdown" class="dropdown-menu w-100"
                                                style="display: none; max-height: 200px; overflow-y: auto;">
                                                <div class="dropdown-item text-muted">Digite para buscar...</div>
                                            </div>
                                        </div>
                                        @error('cliente_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Validade</label>
                                        <input type="date" class="form-control @error('validade') is-invalid @enderror"
                                            name="validade" value="{{ old('validade') }}" min="{{ date('Y-m-d') }}">
                                        @error('validade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Desconto (R$)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number"
                                                class="form-control @error('desconto') is-invalid @enderror" name="desconto"
                                                value="{{ old('desconto', '0.00') }}" step="0.01" min="0"
                                                id="desconto">
                                            @error('desconto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Observações</label>
                                        <textarea class="form-control @error('observacoes') is-invalid @enderror" name="observacoes" rows="3"
                                            placeholder="Observações gerais sobre o orçamento...">{{ old('observacoes') }}</textarea>
                                        @error('observacoes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="btn-continuar" disabled>
                                    Continuar para Itens <i class="fa-solid fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etapa 2: Itens do Orçamento -->
                    <div class="card mb-3" id="etapa-itens" style="display: none;">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <span class="badge bg-primary text-white me-2">2</span>
                                    Itens do Orçamento
                                </h3>
                                <div class="btn-list">
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        id="btn-adicionar-servico">
                                        <i class="fa-solid fa-plus me-2"></i> Adicionar Serviço
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        id="btn-adicionar-item-manual">
                                        <i class="fa-solid fa-edit me-2"></i> Item Manual
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="container-itens">
                                <!-- Itens serão adicionados aqui dinamicamente -->
                            </div>

                            <div class="alert alert-info" id="alert-sem-itens">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Clique em "Adicionar Serviço" para incluir itens de serviços pré-cadastrados ou "Item
                                Manual" para criar um item personalizado.
                            </div>

                            <!-- Resumo do Orçamento -->
                            <div class="row mt-4" id="resumo-orcamento" style="display: none;">
                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">
                                                <i class="fa-solid fa-calculator me-2"></i>
                                                Resumo do Orçamento
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-3 col-6">
                                                    <div class="text-center">
                                                        <div class="text-muted">Subtotal</div>
                                                        <div class="h4" id="valor-subtotal">R$ 0,00</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-6">
                                                    <div class="text-center">
                                                        <div class="text-muted">Desconto</div>
                                                        <div class="h4 text-danger" id="valor-desconto">R$ 0,00</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-6">
                                                    <div class="text-center">
                                                        <div class="text-muted">Total de Itens</div>
                                                        <div class="h4" id="total-itens">0</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-6">
                                                    <div class="text-center">
                                                        <div class="text-muted">Total Final</div>
                                                        <div class="h2 text-success" id="valor-total">R$ 0,00</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-outline-secondary" id="btn-voltar">
                                    <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                                </button>
                                <button type="submit" class="btn btn-success" id="btn-salvar" disabled>
                                    <i class="fa-solid fa-save me-2"></i> Salvar Orçamento
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Serviço -->
    <div class="modal modal-blur fade" id="modal-servico" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-cogs me-2"></i>
                        Adicionar Serviço
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Etapa 1: Seleção do Serviço -->
                    <div id="etapa-selecao-servico">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Selecione o Serviço</label>
                                <select class="form-select" id="select-servico">
                                    <option value="">Carregando serviços...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Etapa 2: Adicionar Itens do Serviço -->
                    <div id="etapa-itens-servico" style="display: none;">
                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Adicionar Itens do Serviço</h6>
                            <span class="badge bg-blue text-white fs-5 fw-bold" id="nome-servico-selecionado" ></span>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Selecionar Item</label>
                                <select class="form-select" id="select-item-servico">
                                    <option value="">Escolha um item...</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantidade</label>
                                <input type="number" class="form-control" id="input-quantidade-item" value="1"
                                    step="0.01" min="0.01">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Observações</label>
                                <input type="text" class="form-control" id="input-observacoes-item"
                                    placeholder="Observações...">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-primary w-100" id="btn-adicionar-item-individual">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Lista de itens adicionados -->
                        <div id="itens-adicionados-container" style="display: none;">
                            <h6 class="mb-2">Itens Adicionados:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th width="100px">Qtd</th>
                                            <th>Observações</th>
                                            <th width="60px">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-itens-adicionados">
                                    </tbody>
                                </table>
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                <strong>Itens adicionados:</strong> <span id="contador-itens-servico">0</span> item(ns)
                                <br>
                                <small>Defina o valor total do serviço abaixo para finalizar</small>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Valor Total do Serviço</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="text" class="form-control money-mask" id="valor-total-servico"
                                            placeholder="0,00" data-mask="currency">
                                    </div>
                                    <small class="text-muted">Este será o valor total do serviço completo</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-finalizar-servico" disabled>
                        <i class="fa-solid fa-check me-2"></i>
                        Finalizar e Adicionar ao Orçamento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Item Manual -->
    <div class="modal modal-blur fade" id="modal-item-manual" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-edit me-2"></i>
                        Adicionar Item Manual
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Descrição</label>
                        <input type="text" class="form-control" id="manual-descricao" placeholder="Descrição do item"
                            maxlength="255">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label required">Quantidade</label>
                                <input type="number" class="form-control" id="manual-quantidade" value="1"
                                    step="0.01" min="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Unidade</label>
                                <select class="form-select" id="manual-unidade">
                                    <option value="">Sem unidade</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Preço Unitário</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control money-mask" id="manual-preco" placeholder="0,00" data-mask="currency">
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <strong>Total:</strong> <span id="manual-total">R$ 0,00</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-adicionar-item-manual">
                        <i class="fa-solid fa-plus me-2"></i>
                        Adicionar Item
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // CSS adicional para modais e busca de cliente
        const modalCSS = `
            .modal {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1055;
                width: 100%;
                height: 100%;
                overflow-x: hidden;
                overflow-y: auto;
                outline: 0;
                display: none;
            }
            .modal.show {
                display: block !important;
            }
            .modal-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1050;
                width: 100vw;
                height: 100vh;
                background-color: #000;
                opacity: 0.5;
            }
            body.modal-open {
                overflow: hidden;
            }

            /* Estilos para busca de cliente */
            #cliente-dropdown {
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
                display: none;
                min-width: 100%;
                background-color: #fff;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
            }

            #cliente-dropdown .dropdown-item {
                padding: 0.5rem 1rem;
                cursor: pointer;
                border-bottom: 1px solid #f1f3f4;
            }

            #cliente-dropdown .dropdown-item:hover {
                background-color: #f8f9fa;
            }

            #cliente-dropdown .dropdown-item.active {
                background-color: #0d6efd;
                color: white;
            }

            #cliente-dropdown .dropdown-item:last-child {
                border-bottom: none;
            }
        `;

        // Adicionar CSS ao head se não existir
        if (!document.querySelector('#modal-custom-styles')) {
            const style = document.createElement('style');
            style.id = 'modal-custom-styles';
            style.textContent = modalCSS;
            document.head.appendChild(style);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Função auxiliar para fechar modal
            function fecharModal(modalId) {
                const modalElement = document.getElementById(modalId);
                modalElement.style.display = 'none';
                modalElement.classList.remove('show');
                document.body.classList.remove('modal-open');

                // Remover backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }

            // Adicionar listeners para fechar modais com botões close
            document.addEventListener('click', function(e) {
                if (e.target.matches('[data-bs-dismiss="modal"]') || e.target.closest(
                        '[data-bs-dismiss="modal"]')) {
                    const modal = e.target.closest('.modal');
                    if (modal) {
                        fecharModal(modal.id);
                    }
                }

                // Fechar modal clicando no backdrop
                if (e.target.classList.contains('modal')) {
                    fecharModal(e.target.id);
                }
            });

            // Estado da aplicação
            let servicosData = [];
            let unidadesData = [];
            let itensOrcamento = [];
            let contadorItens = 0;
            let clientesData = @json($clientes); // Dados dos clientes do PHP

            // Elementos DOM
            const clienteSelect = document.getElementById('cliente_id');
            const clienteSearch = document.getElementById('cliente-search');
            const clienteDropdown = document.getElementById('cliente-dropdown');
            const btnContinuar = document.getElementById('btn-continuar');
            const btnVoltar = document.getElementById('btn-voltar');
            const btnSalvar = document.getElementById('btn-salvar');
            const etapaDados = document.getElementById('etapa-dados');
            const etapaItens = document.getElementById('etapa-itens');
            const containerItens = document.getElementById('container-itens');
            const alertSemItens = document.getElementById('alert-sem-itens');
            const resumoOrcamento = document.getElementById('resumo-orcamento');
            const descontoInput = document.getElementById('desconto');

            // Inicialização
            init();

            function init() {
                // Configurar busca de clientes
                setupClienteSearch();

                // Carregar dados dos selects logo no início
                carregarDadosSelect();

                // Configurar máscaras de dinheiro
                setupMoneyMasks();

                // Habilitar botão continuar quando cliente for selecionado
                clienteSelect.addEventListener('change', function() {
                    console.log('Cliente selecionado:', this.value);
                    btnContinuar.disabled = !this.value;
                    console.log('Botão continuar habilitado:', !btnContinuar.disabled);
                });

                // Navegação entre etapas
                btnContinuar.addEventListener('click', function() {
                    console.log('=== NAVEGANDO PARA ETAPA 2 ===');
                    etapaDados.style.display = 'none';
                    etapaItens.style.display = 'block';
                    console.log('Etapa de itens exibida');
                });

                btnVoltar.addEventListener('click', function() {
                    console.log('=== VOLTANDO PARA ETAPA 1 ===');
                    etapaItens.style.display = 'none';
                    etapaDados.style.display = 'block';
                });

                // Botões de adicionar itens
                document.getElementById('btn-adicionar-servico').addEventListener('click', function() {
                    const modalElement = document.getElementById('modal-servico');
                    modalElement.style.display = 'block';
                    modalElement.classList.add('show');
                    document.body.classList.add('modal-open');

                    // Criar backdrop se não existir
                    if (!document.querySelector('.modal-backdrop')) {
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                });

                document.getElementById('btn-adicionar-item-manual').addEventListener('click', function() {
                    limparModalItemManual();
                    const modalElement = document.getElementById('modal-item-manual');
                    modalElement.style.display = 'block';
                    modalElement.classList.add('show');
                    document.body.classList.add('modal-open');

                    // Criar backdrop se não existir
                    if (!document.querySelector('.modal-backdrop')) {
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                });

                // Event listeners dos modais
                setupModalServico();
                setupModalItemManual();

                // Configurar máscaras em tempo real quando os modais abrem
                document.getElementById('btn-adicionar-servico').addEventListener('click', function() {
                    setTimeout(setupMoneyMasks, 100); // Aguardar modal abrir
                });

                document.getElementById('btn-adicionar-item-manual').addEventListener('click', function() {
                    setTimeout(setupMoneyMasks, 100); // Aguardar modal abrir
                });

                // Calcular total do item manual em tempo real
                ['manual-quantidade', 'manual-preco'].forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.addEventListener('input', calcularTotalManual);
                        element.addEventListener('blur', calcularTotalManual);
                    }
                });

                // Recalcular quando desconto muda
                descontoInput.addEventListener('input', atualizarResumo);
            }

            function setupClienteSearch() {
                let selectedIndex = -1;

                // Configurar valor inicial se houver old() do Laravel
                @if (old('cliente_id'))
                    const oldClienteId = {{ old('cliente_id') }};
                    const oldCliente = clientesData.find(c => c.id == oldClienteId);
                    if (oldCliente) {
                        clienteSearch.value = oldCliente.nome + (oldCliente.documento ?
                            ` - ${oldCliente.documento}` : '');
                        clienteSelect.value = oldCliente.id;
                        btnContinuar.disabled = false;
                    }
                @endif

                // Evento de digitação no campo de busca
                clienteSearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    selectedIndex = -1;

                    if (searchTerm.length === 0) {
                        clienteDropdown.style.display = 'none';
                        clienteSelect.value = '';
                        btnContinuar.disabled = true;
                        return;
                    }

                    // Filtrar clientes
                    const filteredClientes = clientesData.filter(cliente => {
                        const nome = cliente.nome.toLowerCase();
                        const documento = cliente.documento ? cliente.documento.toLowerCase() : '';
                        return nome.includes(searchTerm) || documento.includes(searchTerm);
                    });

                    // Mostrar resultados
                    mostrarResultadosClientes(filteredClientes);
                });

                // Navegação com teclado
                clienteSearch.addEventListener('keydown', function(e) {
                    const items = clienteDropdown.querySelectorAll('.dropdown-item:not(.text-muted)');

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
                            items[selectedIndex].click();
                        }
                    } else if (e.key === 'Escape') {
                        clienteDropdown.style.display = 'none';
                        selectedIndex = -1;
                    }
                });

                // Fechar dropdown ao clicar fora
                document.addEventListener('click', function(e) {
                    if (!clienteSearch.contains(e.target) && !clienteDropdown.contains(e.target)) {
                        clienteDropdown.style.display = 'none';
                        selectedIndex = -1;
                    }
                });

                function mostrarResultadosClientes(clientes) {
                    clienteDropdown.innerHTML = '';

                    if (clientes.length === 0) {
                        clienteDropdown.innerHTML =
                            '<div class="dropdown-item text-muted">Nenhum cliente encontrado</div>';
                    } else {
                        clientes.forEach((cliente, index) => {
                            const item = document.createElement('div');
                            item.className = 'dropdown-item';
                            item.innerHTML = `
                                <div>
                                    <strong>${cliente.nome}</strong>
                                    ${cliente.documento ? `<br><small class="text-muted">${cliente.documento}</small>` : ''}
                                </div>
                            `;

                            item.addEventListener('click', function() {
                                selecionarCliente(cliente);
                            });

                            clienteDropdown.appendChild(item);
                        });
                    }

                    clienteDropdown.style.display = 'block';
                }

                function updateSelection(items) {
                    items.forEach((item, index) => {
                        if (index === selectedIndex) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
                }

                function selecionarCliente(cliente) {
                    clienteSearch.value = cliente.nome + (cliente.documento ? ` - ${cliente.documento}` : '');
                    clienteSelect.value = cliente.id;
                    clienteDropdown.style.display = 'none';
                    selectedIndex = -1;

                    // Disparar evento change
                    const event = new Event('change');
                    clienteSelect.dispatchEvent(event);

                    console.log('Cliente selecionado via busca:', cliente);
                }
            }

            // Configurar máscaras de dinheiro
            function setupMoneyMasks() {
                // Aplicar máscara nos campos de valor
                const moneyFields = document.querySelectorAll('.money-mask');
                moneyFields.forEach(field => {
                    // Máscara para entrada
                    field.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        value = (value / 100).toFixed(2);
                        value = value.replace('.', ',');
                        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        e.target.value = value;
                    });

                    // Converter para número quando sair do campo
                    field.addEventListener('blur', function(e) {
                        const value = parseCurrencyToFloat(e.target.value);
                        if (e.target.id === 'manual-preco') {
                            calcularTotalManual();
                        }
                    });
                });
            }

            // Converter valor com máscara para float
            function parseCurrencyToFloat(value) {
                if (!value || value === '') return 0;
                // Remove pontos e substitui vírgula por ponto
                return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
            }

            // Formatar número para moeda brasileira
            function formatCurrency(value) {
                return new Intl.NumberFormat('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(value);
            }

            // Escapar HTML para evitar problemas com caracteres especiais
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            async function carregarDadosSelect() {
                try {
                    // Carregar serviços
                    const responseServicos = await fetch('{{ route('orcamentos.get-servicos') }}');
                    servicosData = await responseServicos.json();

                    // Carregar unidades
                    const responseUnidades = await fetch('{{ route('orcamentos.get-unidades') }}');
                    unidadesData = await responseUnidades.json();

                    popularSelectServicos();
                    popularSelectUnidades();
                } catch (error) {
                    console.error('Erro ao carregar dados:', error);
                    showToast('Erro', 'Não foi possível carregar os dados necessários.', 'error');
                }
            }

            function popularSelectServicos() {
                const select = document.getElementById('select-servico');
                select.innerHTML = '<option value="">Selecione um serviço</option>';

                servicosData.forEach(servico => {
                    const option = document.createElement('option');
                    option.value = servico.id;
                    option.textContent = servico.nome;
                    select.appendChild(option);
                });
            }

            function popularSelectUnidades() {
                const selects = [document.getElementById('manual-unidade')];

                selects.forEach(select => {
                    select.innerHTML = '<option value="">Sem unidade</option>';
                    unidadesData.forEach(unidade => {
                        const option = document.createElement('option');
                        option.value = unidade.id;
                        option.textContent =
                            `${unidade.nome}${unidade.codigo ? ' (' + unidade.codigo + ')' : ''}`;
                        select.appendChild(option);
                    });
                });
            }

            function setupModalServico() {
                const selectServico = document.getElementById('select-servico');
                const etapaItensServico = document.getElementById('etapa-itens-servico');
                const nomeServicoSelecionado = document.getElementById('nome-servico-selecionado');
                const selectItemServico = document.getElementById('select-item-servico');
                const inputQuantidade = document.getElementById('input-quantidade-item');
                const inputObservacoes = document.getElementById('input-observacoes-item');
                const btnAdicionarItem = document.getElementById('btn-adicionar-item-individual');
                const btnFinalizarServico = document.getElementById('btn-finalizar-servico');
                const itensAdicionadosContainer = document.getElementById('itens-adicionados-container');
                const tbodyItensAdicionados = document.getElementById('tbody-itens-adicionados');
                const contadorItensServico = document.getElementById('contador-itens-servico');
                const valorTotalServico = document.getElementById('valor-total-servico');

                let servicoAtual = null;
                let itensServicoDisponiveis = [];
                let itensAdicionados = [];

                // Evento de mudança do select de serviço
                selectServico.addEventListener('change', async function() {
                    if (!this.value) {
                        etapaItensServico.style.display = 'none';
                        btnFinalizarServico.disabled = true;
                        servicoAtual = null;
                        return;
                    }

                    try {
                        // Buscar dados do serviço
                        const responseServico = await fetch(
                            `{{ url('orcamentos/servicos') }}/${this.value}`);
                        const servico = await responseServico.json();

                        // Buscar itens do serviço
                        const responseItens = await fetch(
                            `{{ url('orcamentos/servicos') }}/${this.value}/itens`);
                        const itensServico = await responseItens.json();

                        servicoAtual = servico;
                        itensServicoDisponiveis = itensServico;

                        // Atualizar interface
                        nomeServicoSelecionado.textContent = servico.nome;
                        carregarSelectItens(itensServico);
                        etapaItensServico.style.display = 'block';

                    } catch (error) {
                        console.error('Erro ao carregar serviço:', error);
                        showToast('Erro', 'Não foi possível carregar os dados do serviço.', 'error');
                    }
                });

                function carregarSelectItens(itensServico) {
                    selectItemServico.innerHTML = '<option value="">Escolha um item...</option>';

                    if (itensServico.length === 0) {
                        selectItemServico.innerHTML = '<option value="">Nenhum item disponível</option>';
                        return;
                    }

                    itensServico.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.descricao_item;
                        selectItemServico.appendChild(option);
                    });
                }

                // Adicionar item individual
                btnAdicionarItem.addEventListener('click', function() {
                    const itemId = selectItemServico.value;
                    const quantidade = parseFloat(inputQuantidade.value);
                    const observacoes = inputObservacoes.value.trim();

                    if (!itemId) {
                        showToast('Aviso', 'Selecione um item para adicionar.', 'warning');
                        return;
                    }

                    if (!quantidade || quantidade <= 0) {
                        showToast('Aviso', 'Informe uma quantidade válida.', 'warning');
                        return;
                    }

                    // Buscar dados do item
                    const itemSelecionado = itensServicoDisponiveis.find(item => item.id == itemId);
                    if (!itemSelecionado) {
                        showToast('Erro', 'Item não encontrado.', 'error');
                        return;
                    }

                    // Verificar se o item já foi adicionado
                    const itemJaAdicionado = itensAdicionados.find(item => item.item_id == itemId);
                    if (itemJaAdicionado) {
                        showToast('Aviso', 'Este item já foi adicionado ao serviço.', 'warning');
                        return;
                    }

                    // Adicionar à lista
                    const novoItem = {
                        item_id: itemId,
                        descricao: itemSelecionado.descricao_item,
                        quantidade: quantidade,
                        observacao: observacoes
                    };

                    itensAdicionados.push(novoItem);
                    atualizarTabelaItens();
                    limparFormularioItem();
                    verificarBotaoFinalizar();

                    showToast('Sucesso', 'Item adicionado com sucesso!', 'success');
                });

                function atualizarTabelaItens() {
                    tbodyItensAdicionados.innerHTML = '';

                    if (itensAdicionados.length === 0) {
                        itensAdicionadosContainer.style.display = 'none';
                        contadorItensServico.textContent = '0';
                        return;
                    }

                    itensAdicionadosContainer.style.display = 'block';
                    contadorItensServico.textContent = itensAdicionados.length;

                    itensAdicionados.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><strong>${item.descricao}</strong></td>
                            <td>${item.quantidade}</td>
                            <td>${item.observacao || '-'}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerItemAdicionado(${index})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        `;
                        tbodyItensAdicionados.appendChild(row);
                    });
                }

                function limparFormularioItem() {
                    selectItemServico.value = '';
                    inputQuantidade.value = '1';
                    inputObservacoes.value = '';
                }

                function verificarBotaoFinalizar() {
                    const temItens = itensAdicionados.length > 0;
                    const temValor = parseFloat(valorTotalServico.value) > 0;
                    btnFinalizarServico.disabled = !(temItens && temValor);
                }

                // Evento para verificar botão quando o valor total mudar
                valorTotalServico.addEventListener('input', verificarBotaoFinalizar);

                // Função global para remover item (chamada pelo botão)
                window.removerItemAdicionado = function(index) {
                    itensAdicionados.splice(index, 1);
                    atualizarTabelaItens();
                    verificarBotaoFinalizar();
                    showToast('Sucesso', 'Item removido com sucesso!', 'success');
                };

                // Finalizar serviço
                btnFinalizarServico.addEventListener('click', function() {
                    const valorTotal = parseCurrencyToFloat(valorTotalServico.value);

                    if (itensAdicionados.length === 0) {
                        showToast('Aviso', 'Adicione pelo menos um item antes de finalizar.', 'warning');
                        return;
                    }

                    // Verificar se há um serviço selecionado
                    if (!servicoAtual) {
                        showToast('Aviso', 'Selecione um serviço antes de adicionar.', 'warning');
                        return;
                    }

                    if (!valorTotal || valorTotal <= 0) {
                        showToast('Aviso', 'Informe o valor total do serviço.', 'warning');
                        return;
                    }

                    // Calcular preço unitário distribuído entre todos os itens
                    const totalQuantidade = itensAdicionados.reduce((sum, item) => sum + parseFloat(item
                        .quantidade), 0);
                    const precoUnitarioDistribuido = valorTotal / totalQuantidade;

                    // Adicionar cada item ao orçamento com o valor distribuído
                    itensAdicionados.forEach((item, index) => {
                        const precoItem = precoUnitarioDistribuido;
                        const totalItem = precoItem * parseFloat(item.quantidade);

                        adicionarItem({
                            descricao: `${servicoAtual.nome} - ${item.descricao}`,
                            quantidade: item.quantidade,
                            unidade_id: null,
                            unidade_nome: '',
                            preco_unitario: precoItem,
                            item_servico_id: item.item_id,
                            total: totalItem,
                            observacao: item.observacao
                        });
                    });

                    // Resetar modal
                    resetarModalServico();
                    fecharModal('modal-servico');

                    showToast('Sucesso',
                        `Serviço "${servicoAtual.nome}" adicionado com ${itensAdicionados.length} item(ns) no valor de R$ ${valorTotal.toFixed(2)}!`,
                        'success'
                    );
                });

                function resetarModalServico() {
                    selectServico.value = '';
                    etapaItensServico.style.display = 'none';
                    servicoAtual = null;
                    itensServicoDisponiveis = [];
                    itensAdicionados = [];
                    limparFormularioItem();
                    itensAdicionadosContainer.style.display = 'none';
                    tbodyItensAdicionados.innerHTML = '';
                    contadorItensServico.textContent = '0';
                    valorTotalServico.value = '';
                    btnFinalizarServico.disabled = true;
                }

                // Resetar quando o modal for fechado
                document.getElementById('modal-servico').addEventListener('click', function(e) {
                    if (e.target === this || e.target.classList.contains('btn-close')) {
                        resetarModalServico();
                    }
                });
            }

            function setupModalItemManual() {
                const btnAdicionarItemManual = document.querySelector('#modal-item-manual .btn-primary');

                btnAdicionarItemManual.addEventListener('click', function() {
                    const descricao = document.getElementById('manual-descricao').value.trim();
                    const quantidade = parseFloat(document.getElementById('manual-quantidade').value);
                    const unidadeId = document.getElementById('manual-unidade').value;
                    const unidadeNome = document.getElementById('manual-unidade').selectedOptions[0]
                        .textContent;
                    const preco = parseCurrencyToFloat(document.getElementById('manual-preco').value);

                    if (!descricao || !quantidade || !preco) {
                        showToast('Erro', 'Preencha todos os campos obrigatórios.', 'error');
                        return;
                    }

                    adicionarItem({
                        descricao: descricao,
                        quantidade: quantidade,
                        unidade_id: unidadeId || null,
                        unidade_nome: unidadeId ? unidadeNome : '',
                        preco_unitario: preco,
                        item_servico_id: null,
                        total: quantidade * preco,
                        observacao: null // Item manual não tem observações por enquanto
                    });

                    fecharModal('modal-item-manual');
                    limparModalItemManual();
                    showToast('Sucesso', 'Item adicionado ao orçamento!', 'success');
                });
            }

            function limparModalItemManual() {
                document.getElementById('manual-descricao').value = '';
                document.getElementById('manual-quantidade').value = '1';
                document.getElementById('manual-unidade').value = '';
                document.getElementById('manual-preco').value = '0,00';
                document.getElementById('manual-total').textContent = 'R$ 0,00';
            }

            function calcularTotalManual() {
                const quantidade = parseFloat(document.getElementById('manual-quantidade').value) || 0;
                const preco = parseCurrencyToFloat(document.getElementById('manual-preco').value) || 0;
                const total = quantidade * preco;
                document.getElementById('manual-total').textContent = formatarMoeda(total);
            }

            function adicionarItem(item) {
                contadorItens++;
                item.id = contadorItens;
                itensOrcamento.push(item);

                console.log('=== ITEM ADICIONADO ===');
                console.log('Item:', item);
                console.log('Total de itens agora:', itensOrcamento.length);

                renderizarItens();
                atualizarResumo();
            }

            function removerItem(id) {
                itensOrcamento = itensOrcamento.filter(item => item.id !== id);
                renderizarItens();
                atualizarResumo();
            }

            function renderizarItens() {
                console.log('=== RENDERIZANDO ITENS ===');
                console.log('Quantidade de itens:', itensOrcamento.length);
                console.log('Lista de itens:', itensOrcamento);

                if (itensOrcamento.length === 0) {
                    containerItens.innerHTML = '';
                    alertSemItens.style.display = 'block';
                    resumoOrcamento.style.display = 'none';
                    btnSalvar.disabled = true;
                    console.log('Botão salvar DESABILITADO - nenhum item');
                    return;
                }

                alertSemItens.style.display = 'none';
                resumoOrcamento.style.display = 'block';
                btnSalvar.disabled = false;
                console.log('Botão salvar HABILITADO');

                // Criar tabela usando DOM ao invés de innerHTML
                const tableDiv = document.createElement('div');
                tableDiv.className = 'table-responsive';
                
                const table = document.createElement('table');
                table.className = 'table table-vcenter';
                
                // Cabeçalho
                const thead = document.createElement('thead');
                thead.innerHTML = `
                    <tr>
                        <th>Descrição</th>
                        <th width="100px">Qtd</th>
                        <th width="80px">Ações</th>
                    </tr>
                `;
                table.appendChild(thead);
                
                // Corpo da tabela
                const tbody = document.createElement('tbody');
                
                itensOrcamento.forEach((item, index) => {
                    console.log(`Criando campos para item ${index}:`, item);

                    // Verificar se o item tem todas as propriedades necessárias
                    if (!item.descricao) {
                        console.error(`ERRO: Item ${index} não tem descrição:`, item);
                    }
                    if (!item.quantidade) {
                        console.error(`ERRO: Item ${index} não tem quantidade:`, item);
                    }
                    if (!item.preco_unitario && item.preco_unitario !== 0) {
                        console.error(`ERRO: Item ${index} não tem preço unitário:`, item);
                    }

                    // Criar linha da tabela
                    const tr = document.createElement('tr');
                    
                    // Célula da descrição com inputs hidden
                    const tdDescricao = document.createElement('td');
                    
                    // Formatar descrição com serviço em negrito se for item de serviço
                    let descricaoFormatada = item.descricao;
                    if (item.item_servico_id && item.descricao.includes(' - ')) {
                        const partes = item.descricao.split(' - ');
                        const nomeServico = partes[0];
                        const nomeItem = partes.slice(1).join(' - ');
                        descricaoFormatada = `<strong>${nomeServico}</strong> - ${nomeItem}`;
                    }
                    
                    const descricaoDiv = document.createElement('div');
                    descricaoDiv.className = 'font-weight-medium';
                    descricaoDiv.innerHTML = descricaoFormatada;
                    
                    const tipoDiv = document.createElement('small');
                    tipoDiv.className = 'text-muted';
                    tipoDiv.textContent = item.item_servico_id ? 'Item de serviço' : 'Item manual';
                    
                    // Criar inputs hidden
                    const inputs = [
                        { name: `itens[${index}][descricao]`, value: item.descricao },
                        { name: `itens[${index}][observacao]`, value: item.observacao || '' },
                        { name: `itens[${index}][quantidade]`, value: item.quantidade },
                        { name: `itens[${index}][unidade_id]`, value: item.unidade_id || '' },
                        { name: `itens[${index}][preco_unitario]`, value: item.preco_unitario },
                        { name: `itens[${index}][item_servico_id]`, value: item.item_servico_id || '' }
                    ];
                    
                    inputs.forEach(inputData => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = inputData.name;
                        input.value = inputData.value;
                        tdDescricao.appendChild(input);
                        console.log(`Input criado: ${inputData.name} = ${inputData.value}`);
                    });
                    
                    tdDescricao.appendChild(descricaoDiv);
                    tdDescricao.appendChild(tipoDiv);
                    
                    // Célula da quantidade
                    const tdQuantidade = document.createElement('td');
                    tdQuantidade.textContent = item.quantidade;
                    
                    // Célula de ações
                    const tdAcoes = document.createElement('td');
                    const btnRemover = document.createElement('button');
                    btnRemover.type = 'button';
                    btnRemover.className = 'btn btn-outline-danger btn-sm';
                    btnRemover.title = 'Remover';
                    btnRemover.onclick = () => removerItem(item.id);
                    btnRemover.innerHTML = '<i class="fa-solid fa-trash"></i>';
                    tdAcoes.appendChild(btnRemover);
                    
                    // Adicionar células à linha
                    tr.appendChild(tdDescricao);
                    tr.appendChild(tdQuantidade);
                    tr.appendChild(tdAcoes);
                    
                    // Adicionar linha ao tbody
                    tbody.appendChild(tr);
                });
                
                table.appendChild(tbody);
                tableDiv.appendChild(table);
                
                // Limpar container e adicionar nova tabela
                containerItens.innerHTML = '';
                containerItens.appendChild(tableDiv);
                
                console.log('Tabela de itens renderizada com sucesso');
            }

            function atualizarResumo() {
                const subtotal = itensOrcamento.reduce((sum, item) => sum + item.total, 0);
                const desconto = parseFloat(descontoInput.value) || 0;
                const total = subtotal - desconto;
                const totalItens = itensOrcamento.length;

                document.getElementById('valor-subtotal').textContent = formatarMoeda(subtotal);
                document.getElementById('valor-desconto').textContent = formatarMoeda(desconto);
                document.getElementById('valor-total').textContent = formatarMoeda(total);
                document.getElementById('total-itens').textContent = totalItens;
            }

            function formatarMoeda(valor) {
                return `R$ ${valor.toFixed(2).replace('.', ',')}`;
            }

            // Função global para remoção de itens
            window.removerItem = removerItem;

            // Debug: Capturar submit do formulário
            const form = document.getElementById('form-orcamento');
            form.addEventListener('submit', function(e) {
                try {
                    console.log('=== EVENTO SUBMIT DISPARADO ===');
                    console.log('Itens do orçamento:', itensOrcamento);
                    console.log('Quantidade de itens:', itensOrcamento.length);

                    // Verificar se há itens
                    if (itensOrcamento.length === 0) {
                        e.preventDefault();
                        console.log('SUBMIT CANCELADO - Nenhum item encontrado');
                        showToast('Aviso', 'Adicione pelo menos um item ao orçamento antes de salvar.',
                            'warning');
                        return false;
                    }

                    // Verificar se todos os campos obrigatórios estão preenchidos
                    const clienteId = document.getElementById('cliente_id').value;
                    if (!clienteId) {
                        e.preventDefault();
                        console.log('SUBMIT CANCELADO - Cliente não selecionado');
                        showToast('Erro', 'Selecione um cliente antes de salvar.', 'error');
                        return false;
                    }

                    console.log('Cliente ID:', clienteId);
                    console.log('Formulário será enviado...');
                    console.log('URL de destino:', this.action);
                    console.log('Método:', this.method);

                    // Vamos logar os dados que serão enviados
                    const formData = new FormData(this);
                    console.log('=== DADOS DO FORMULÁRIO ===');

                    // Agrupar dados por tipo para melhor visualização
                    const dadosOrganizados = {
                        cliente_id: formData.get('cliente_id'),
                        validade: formData.get('validade'),
                        desconto: formData.get('desconto'),
                        observacoes: formData.get('observacoes'),
                        itens: []
                    };

                    // Extrair itens
                    for (let [key, value] of formData.entries()) {
                        if (key.startsWith('itens[')) {
                            const match = key.match(/itens\[(\d+)\]\[(\w+)\]/);
                            if (match) {
                                const index = parseInt(match[1]);
                                const campo = match[2];

                                if (!dadosOrganizados.itens[index]) {
                                    dadosOrganizados.itens[index] = {};
                                }
                                dadosOrganizados.itens[index][campo] = value;
                            }
                        }
                    }

                    console.log('Dados organizados:', dadosOrganizados);

                    // Verificar se há problemas nos itens
                    dadosOrganizados.itens.forEach((item, index) => {
                        if (!item.descricao) {
                            console.error(`ERRO: Item ${index} sem descrição`);
                        }
                        if (!item.quantidade || parseFloat(item.quantidade) <= 0) {
                            console.error(`ERRO: Item ${index} com quantidade inválida:`, item
                                .quantidade);
                        }
                        if (!item.preco_unitario || parseFloat(item.preco_unitario) < 0.01) {
                            console.error(`ERRO: Item ${index} com preço unitário inválido:`, item
                                .preco_unitario);
                        }
                    });

                    // Verificar se há pelo menos um item nos dados do formulário
                    let hasItems = false;
                    for (let [key, value] of formData.entries()) {
                        if (key.startsWith('itens[')) {
                            hasItems = true;
                            break;
                        }
                    }

                    if (!hasItems) {
                        e.preventDefault();
                        console.log('SUBMIT CANCELADO - Nenhum campo de item encontrado no FormData');
                        showToast('Erro',
                            'Erro interno: itens não foram adicionados ao formulário. Tente novamente.',
                            'error');
                        return false;
                    }

                    console.log('✅ Formulário válido - enviando dados...');

                } catch (error) {
                    console.error('ERRO NO SUBMIT:', error);
                    e.preventDefault();
                    showToast('Erro', 'Erro inesperado: ' + error.message, 'error');
                    return false;
                }
            });

            // Toast notification function
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
        });
    </script>
@endsection
