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
                            <div class="font-weight-medium">' + item.descricao + '</div>
                            ' + (item.item_servico_id ? '<small class="text-muted">Item de serviço</small>' : '<small
                                class="text-muted">Item manual</small>') + '
                            <input type="hidden" name="itens[' + index + '][descricao]" value="' + item.descricao + '">
                            <input type="hidden" name="itens[' + index + '][quantidade]" value="' + item.quantidade + '">
                            <input type="hidden" name="itens[' + index + '][unidade_id]"
                                value="' + (item.unidade_id || '') + '">
                            <input type="hidden" name="itens[' + index + '][preco_unitario]"
                                value="' + item.preco_unitario + '">
                            <input type="hidden" name="itens[' + index + '][item_servico_id]"
                                value="' + (item.item_servico_id || '') + '"><i class="fa-solid fa-pen fa-lg me-2"></i>
                            Editar Orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('orcamentos.show', $orcamento) }}" class="btn btn-outline-info">
                                <i class="fa-solid fa-eye me-2"></i> Visualizar
                            </a>
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
                <form method="POST" action="{{ route('orcamentos.update', $orcamento) }}" id="form-orcamento">
                    @csrf
                    @method('PUT')

                    <!-- Dados Básicos -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Dados Básicos do Orçamento
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Cliente</label>
                                        <select class="form-select @error('cliente_id') is-invalid @enderror"
                                            name="cliente_id" id="cliente_id" required>
                                            <option value="">Selecione um cliente</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}"
                                                    {{ (old('cliente_id') ?? $orcamento->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                                    {{ $cliente->nome }}
                                                    @if ($cliente->documento)
                                                        - {{ $cliente->documento }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cliente_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label required">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" name="status"
                                            required>
                                            <option value="draft"
                                                {{ (old('status') ?? $orcamento->status) == 'draft' ? 'selected' : '' }}>
                                                Rascunho</option>
                                            <option value="awaiting"
                                                {{ (old('status') ?? $orcamento->status) == 'awaiting' ? 'selected' : '' }}>
                                                Aguardando</option>
                                            <option value="sent"
                                                {{ (old('status') ?? $orcamento->status) == 'sent' ? 'selected' : '' }}>
                                                Enviado</option>
                                            <option value="approved"
                                                {{ (old('status') ?? $orcamento->status) == 'approved' ? 'selected' : '' }}>
                                                Aprovado</option>
                                            <option value="rejected"
                                                {{ (old('status') ?? $orcamento->status) == 'rejected' ? 'selected' : '' }}>
                                                Rejeitado</option>
                                            <option value="expired"
                                                {{ (old('status') ?? $orcamento->status) == 'expired' ? 'selected' : '' }}>
                                                Expirado</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Validade</label>
                                        <input type="date" class="form-control @error('validade') is-invalid @enderror"
                                            name="validade"
                                            value="{{ old('validade') ?? ($orcamento->validade ? $orcamento->validade->format('Y-m-d') : '') }}">
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
                                                value="{{ old('desconto') ?? $orcamento->desconto }}" step="0.01"
                                                min="0" id="desconto">
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
                                            placeholder="Observações gerais sobre o orçamento...">{{ old('observacoes') ?? $orcamento->observacoes }}</textarea>
                                        @error('observacoes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Itens do Orçamento -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fa-solid fa-list me-2"></i>
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
                                <!-- Itens serão carregados aqui -->
                            </div>

                            <div class="alert alert-info" id="alert-sem-itens" style="display: none;">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Clique em "Adicionar Serviço" para incluir itens de serviços pré-cadastrados ou "Item
                                Manual" para criar um item personalizado.
                            </div>

                            <!-- Resumo do Orçamento -->
                            <div class="row mt-4" id="resumo-orcamento">
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

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success" id="btn-salvar">
                                    <i class="fa-solid fa-save me-2"></i> Atualizar Orçamento
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluir os mesmos modais da view create -->
    <!-- Modal Adicionar Serviço -->
    <div class="modal modal-blur fade" id="modal-servico" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-cogs me-2"></i>
                        Adicionar Itens de Serviço
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Selecione o Serviço</label>
                        <select class="form-select" id="select-servico">
                            <option value="">Carregando serviços...</option>
                        </select>
                    </div>
                    <div id="itens-servico-container" style="display: none;">
                        <label class="form-label">Itens do Serviço</label>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width="50px">
                                            <input type="checkbox" id="select-all-itens">
                                        </th>
                                        <th>Descrição</th>
                                        <th width="120px">Quantidade</th>
                                        <th width="120px">Unidade</th>
                                        <th width="120px">Preço Unit.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-itens-servico">
                                    <!-- Itens do serviço serão carregados aqui -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-adicionar-itens-servico" disabled>
                        <i class="fa-solid fa-plus me-2"></i>
                        Adicionar Itens Selecionados
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
                            <input type="number" class="form-control" id="manual-preco" step="0.01" min="0.01">
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
        // CSS adicional para modais
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
        `;

        // Adicionar CSS ao head se não existir
        if (!document.querySelector('#modal-custom-styles')) {
            const style = document.createElement('style');
            style.id = 'modal-custom-styles';
            style.textContent = modalCSS;
            document.head.appendChild(style);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Estado da aplicação
            let servicosData = [];
            let unidadesData = [];
            let itensOrcamento = @json(
                $orcamento->itens->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'descricao' => $item->descricao,
                        'quantidade' => (float) $item->quantidade,
                        'unidade_id' => $item->unidade_id,
                        'unidade_nome' => $item->unidade
                            ? $item->unidade->nome . ($item->unidade->codigo ? ' (' . $item->unidade->codigo . ')' : '')
                            : '',
                        'preco_unitario' => (float) $item->preco_unitario,
                        'item_servico_id' => $item->item_servico_id,
                        'total' => (float) $item->total,
                    ];
                }));
            let contadorItens = Math.max(...itensOrcamento.map(i => i.id), 0);

            // Elementos DOM
            const containerItens = document.getElementById('container-itens');
            const alertSemItens = document.getElementById('alert-sem-itens');
            const resumoOrcamento = document.getElementById('resumo-orcamento');
            const descontoInput = document.getElementById('desconto');

            // Inicialização
            init();

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

            function init() {
                carregarDadosSelect();
                renderizarItens();
                atualizarResumo();
                setupEventListeners();
            }

            function setupEventListeners() {
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

                // Calcular total do item manual em tempo real
                ['manual-quantidade', 'manual-preco'].forEach(id => {
                    document.getElementById(id).addEventListener('input', calcularTotalManual);
                });

                // Recalcular quando desconto muda
                descontoInput.addEventListener('input', atualizarResumo);
            }

            // Reutilizar as mesmas funções da view create
            async function carregarDadosSelect() {
                try {
                    const responseServicos = await fetch('{{ route('orcamentos.get-servicos') }}');
                    servicosData = await responseServicos.json();

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
                        option.textContent = unidade.nome + (unidade.codigo ? ' (' + unidade
                            .codigo + ')' : '');
                        select.appendChild(option);
                    });
                });
            }

            // Aqui você incluiria todas as outras funções da view create
            // (setupModalServico, setupModalItemManual, adicionarItem, etc.)
            // Por brevidade, vou incluir apenas as principais

            function renderizarItens() {
                if (itensOrcamento.length === 0) {
                    containerItens.innerHTML = '';
                    alertSemItens.style.display = 'block';
                    resumoOrcamento.style.display = 'none';
                    return;
                }

                alertSemItens.style.display = 'none';
                resumoOrcamento.style.display = 'block';

                let html = '<div class="table-responsive"><table class="table table-vcenter">';
                html += `
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th width="100px">Qtd</th>
                            <th width="100px">Unidade</th>
                            <th width="120px">Preço Unit.</th>
                            <th width="120px">Total</th>
                            <th width="80px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                `;

                itensOrcamento.forEach((item, index) => {
                    html +=
                        '<tr>' +
                        '<td>' +
                        '<div class="font-weight-medium">' + item.descricao + '</div>' +
                        (item.item_servico_id ? '<small class="text-muted">Item de serviço</small>' :
                            '<small class="text-muted">Item manual</small>') +
                        '<input type="hidden" name="itens[' + index + '][descricao]" value="' + item
                        .descricao + '">' +
                        '<input type="hidden" name="itens[' + index + '][quantidade]" value="' + item
                        .quantidade + '">' +
                        '<input type="hidden" name="itens[' + index + '][unidade_id]" value="' + (item
                            .unidade_id || '') + '">' +
                        '<input type="hidden" name="itens[' + index + '][preco_unitario]" value="' + item
                        .preco_unitario + '">' +
                        '<input type="hidden" name="itens[' + index + '][item_servico_id]" value="' + (item
                            .item_servico_id || '') + '">' +
                        '</td>' +
                        '<td>' + item.quantidade + '</td>' +
                        '<td>' + (item.unidade_nome || '-') + '</td>' +
                        '<td>R$ ' + item.preco_unitario.toFixed(2).replace('.', ',') + '</td>' +
                        '<td class="font-weight-bold">R$ ' + item.total.toFixed(2).replace('.', ',') +
                        '</td>' +
                        '<td>' +
                        '<button type="button" class="btn btn-outline-danger btn-sm" ' +
                        'onclick="removerItem(' + item.id + ')" title="Remover">' +
                        '<i class="fa-solid fa-trash"></i>' +
                        '</button>' +
                        '</td>' +
                        '</tr>';
                });

                html += '</tbody></table></div>';
                containerItens.innerHTML = html;
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

            function removerItem(id) {
                itensOrcamento = itensOrcamento.filter(item => item.id !== id);
                renderizarItens();
                atualizarResumo();
            }

            function formatarMoeda(valor) {
                return 'R$ ' + valor.toFixed(2).replace('.', ',');
            }

            // Incluir aqui as outras funções necessárias...
            // setupModalServico, setupModalItemManual, etc.

            function setupModalServico() {
                const selectServico = document.getElementById('select-servico');
                const containerItensServico = document.getElementById('itens-servico-container');
                const tbodyItensServico = document.getElementById('tbody-itens-servico');
                const btnAdicionarItensServico = document.getElementById('btn-adicionar-itens-servico');
                const selectAllItens = document.getElementById('select-all-itens');

                selectServico.addEventListener('change', async function() {
                    if (!this.value) {
                        containerItensServico.style.display = 'none';
                        btnAdicionarItensServico.disabled = true;
                        return;
                    }

                    try {
                        const response = await fetch('{{ url('orcamentos/servicos') }}' + '/' + this
                            .value + '/itens');
                        const itensServico = await response.json();

                        tbodyItensServico.innerHTML = '';

                        if (itensServico.length === 0) {
                            tbodyItensServico.innerHTML = `
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Nenhum item encontrado para este serviço
                                    </td>
                                </tr>
                            `;
                            containerItensServico.style.display = 'block';
                            return;
                        }

                        itensServico.forEach(item => {
                            const row = document.createElement('tr');
                            const unidadesOptions = unidadesData.map(u =>
                                '<option value="' + u.id + '">' + u.nome + (u.codigo ?
                                    ' (' + u.codigo + ')' : '') + '</option>'
                            ).join('');

                            row.innerHTML =
                                '<td>' +
                                '<input type="checkbox" class="item-servico-check" data-item-id="' +
                                item.id + '">' +
                                '</td>' +
                                '<td>' + item.descricao_item + '</td>' +
                                '<td>' +
                                '<input type="number" class="form-control form-control-sm" ' +
                                'value="1" step="0.01" min="0.01" ' +
                                'data-field="quantidade" data-item-id="' + item.id + '">' +
                                '</td>' +
                                '<td>' +
                                '<select class="form-select form-select-sm" data-field="unidade" data-item-id="' +
                                item.id + '">' +
                                '<option value="">Sem unidade</option>' +
                                unidadesOptions +
                                '</select>' +
                                '</td>' +
                                '<td>' +
                                '<div class="input-group input-group-sm">' +
                                '<span class="input-group-text">R$</span>' +
                                '<input type="number" class="form-control" ' +
                                'step="0.01" min="0.01" value="10.00"' +
                                'data-field="preco" data-item-id="' + item.id + '">' +
                                '</div>' +
                                '</td>';
                            tbodyItensServico.appendChild(row);
                        });

                        containerItensServico.style.display = 'block';
                        setupCheckboxesServico();
                    } catch (error) {
                        console.error('Erro ao carregar itens do serviço:', error);
                        showToast('Erro', 'Não foi possível carregar os itens do serviço.', 'error');
                    }
                });

                function setupCheckboxesServico() {
                    const checkboxes = document.querySelectorAll('.item-servico-check');

                    selectAllItens.addEventListener('change', function() {
                        checkboxes.forEach(cb => cb.checked = this.checked);
                        verificarSelecaoItens();
                    });

                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', verificarSelecaoItens);
                    });

                    function verificarSelecaoItens() {
                        const selecionados = document.querySelectorAll('.item-servico-check:checked').length;
                        btnAdicionarItensServico.disabled = selecionados === 0;
                    }
                }

                btnAdicionarItensServico.addEventListener('click', function() {
                    const itensSelecionados = document.querySelectorAll('.item-servico-check:checked');

                    itensSelecionados.forEach(checkbox => {
                        const itemId = checkbox.dataset.itemId;
                        const row = checkbox.closest('tr');
                        const descricao = row.cells[1].textContent;
                        const quantidade = parseFloat(row.querySelector('[data-field="quantidade"]')
                            .value);
                        const unidadeId = row.querySelector('[data-field="unidade"]').value;
                        const unidadeNome = row.querySelector(
                            '[data-field="unidade"] option:checked').textContent;
                        const preco = parseFloat(row.querySelector('[data-field="preco"]').value);

                        adicionarItem({
                            descricao: descricao,
                            quantidade: quantidade,
                            unidade_id: unidadeId || null,
                            unidade_nome: unidadeId ? unidadeNome : '',
                            preco_unitario: preco,
                            item_servico_id: itemId,
                            total: quantidade * preco
                        });
                    });

                    fecharModal('modal-servico');
                    showToast('Sucesso', itensSelecionados.length + ' item(ns) adicionado(s) ao orçamento!',
                        'success');
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
                    const preco = parseFloat(document.getElementById('manual-preco').value);

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
                        total: quantidade * preco
                    });

                    fecharModal('modal-item-manual');
                    showToast('Sucesso', 'Item adicionado ao orçamento!', 'success');
                });
            }

            function limparModalItemManual() {
                document.getElementById('manual-descricao').value = '';
                document.getElementById('manual-quantidade').value = '1';
                document.getElementById('manual-unidade').value = '';
                document.getElementById('manual-preco').value = '';
                document.getElementById('manual-total').textContent = 'R$ 0,00';
            }

            function calcularTotalManual() {
                const quantidade = parseFloat(document.getElementById('manual-quantidade').value) || 0;
                const preco = parseFloat(document.getElementById('manual-preco').value) || 0;
                const total = quantidade * preco;
                document.getElementById('manual-total').textContent = formatarMoeda(total);
            }

            function adicionarItem(item) {
                contadorItens++;
                item.id = contadorItens;
                itensOrcamento.push(item);

                renderizarItens();
                atualizarResumo();
            }

            // Função global para remoção de itens
            window.removerItem = removerItem;

            function showToast(title, message, type = 'info') {
                const iconClass = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' :
                    'info-circle';
                const alertClass = type === 'error' ? 'danger' : type;

                const toastHtml =
                    '<div class="alert alert-' + alertClass + ' alert-dismissible position-fixed" ' +
                    'style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
                    '<div class="d-flex">' +
                    '<div>' +
                    '<i class="fa-solid fa-' + iconClass + ' me-2"></i>' +
                    '<strong>' + title + '</strong> ' + message +
                    '</div>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    '</div>' +
                    '</div>';

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

            // Incluir todas as outras funções aqui...
            // setupModalServico, setupModalItemManual, etc.
        });
    </script>
@endsection
