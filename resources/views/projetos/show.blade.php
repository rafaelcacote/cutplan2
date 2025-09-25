@extends('layouts.app')

@section('title', 'Projeto: ' . $projeto->nome)

@push('styles')
    <style>
        .project-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .status-badge-large {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .info-card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tab-content {
            background: white;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            border-bottom-color: #667eea;
            color: #667eea;
            background: none;
        }
    </style>
@endpush

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('projetos.index') }}" class="text-muted">Projetos</a>
                    </div>
                    <h2 class="page-title">
                        {{ $projeto->nome }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('projetos.edit', $projeto) }}" class="btn btn-outline-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Editar
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="12" r="1" />
                                    <circle cx="12" cy="19" r="1" />
                                    <circle cx="12" cy="5" r="1" />
                                </svg>
                                Mais
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-file-export" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v5m-5 6h7m-3 -3l3 3l-3 3" />
                                        </svg>
                                        Exportar Relatório
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <rect x="8" y="8" width="12" height="12" rx="2" />
                                            <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" />
                                        </svg>
                                        Duplicar Projeto
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#"
                                        onclick="confirmDelete({{ $projeto->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <line x1="4" y1="7" x2="20" y2="7" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        Excluir Projeto
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Header do Projeto -->
            <div class="project-header p-4 mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="mb-1">{{ $projeto->nome }}</h1>
                        <div class="text-white-50 mb-3">{{ $projeto->codigo }}</div>
                        <div class="d-flex flex-wrap gap-3">
                            <div>
                                <small class="text-white-50">Cliente</small><br>
                                <strong>{{ $projeto->cliente->nome }}</strong>
                            </div>
                            @if ($projeto->gerente)
                                <div>
                                    <small class="text-white-50">Gerente</small><br>
                                    <strong>{{ $projeto->gerente->name }}</strong>
                                </div>
                            @endif
                            @if ($projeto->equipe)
                                <div>
                                    <small class="text-white-50">Equipe</small><br>
                                    <strong>{{ $projeto->equipe->nome }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <span class="status-badge-large {{ $projeto->status_badge_class }}">
                            {{ $projeto->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Cards de Informações Resumidas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body text-center">
                            <div class="text-muted small mb-1">Data Início</div>
                            <div class="h5 mb-0">
                                {{ $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body text-center">
                            <div class="text-muted small mb-1">Entrega Prevista</div>
                            <div
                                class="h5 mb-0 {{ $projeto->data_entrega_prevista && $projeto->data_entrega_prevista < now() && $projeto->status != 'concluido' ? 'text-danger' : '' }}">
                                {{ $projeto->data_entrega_prevista ? $projeto->data_entrega_prevista->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body text-center">
                            <div class="text-muted small mb-1">Entrega Real</div>
                            <div class="h5 mb-0">
                                {{ $projeto->data_entrega_real ? $projeto->data_entrega_real->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body text-center">
                            <div class="text-muted small mb-1">Orçamento</div>
                            <div class="h5 mb-0">
                                @if ($projeto->orcamento)
                                    <a href="#" class="text-decoration-none">
                                        #{{ $projeto->orcamento->id }}
                                    </a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abas do Projeto -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs nav-tabs-alt card-header-tabs" data-bs-toggle="tabs">
                        <li class="nav-item">
                            <a href="#tab-geral" class="nav-link active" data-bs-toggle="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <rect x="4" y="4" width="16" height="16" rx="2" />
                                    <line x1="9" y1="9" x2="15" y2="9" />
                                    <line x1="9" y1="15" x2="12" y2="15" />
                                </svg>
                                Geral
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-itens" class="nav-link" data-bs-toggle="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M13 5h8"/>
                                    <path d="M13 9h5"/>
                                    <path d="M13 15h8"/>
                                    <path d="M13 19h5"/>
                                    <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                                    <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                                </svg>
                                Itens do Projeto
                                @if ($projeto->itensProjeto->count() > 0)
                                    <span class="badge bg-success ms-1">{{ $projeto->itensProjeto->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-materiais" class="nav-link" data-bs-toggle="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                    <path d="M12 12l8 -4.5" />
                                    <path d="M12 12l0 9" />
                                    <path d="M12 12l-8 -4.5" />
                                </svg>
                                Materiais (BOM)
                                @if ($projeto->materiaisProjeto->count() > 0)
                                    <span class="badge bg-primary ms-1">{{ $projeto->materiaisProjeto->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-contratos" class="nav-link" data-bs-toggle="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <line x1="9" y1="9" x2="10" y2="9" />
                                    <line x1="9" y1="13" x2="15" y2="13" />
                                    <line x1="9" y1="17" x2="15" y2="17" />
                                </svg>
                                Contratos
                                @if ($projeto->contratos->count() > 0)
                                    <span class="badge bg-info ms-1">{{ $projeto->contratos->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-etapas" class="nav-link" data-bs-toggle="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                                Etapas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-anexos" class="nav-link" data-bs-toggle="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M21.44 11.05l-9.19 9.19a6 6 0 0 1 -8.49 -8.49l9.19 -9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1 -2.83 -2.83l8.49 -8.48" />
                                </svg>
                                Anexos
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Aba Geral -->
                        <div class="tab-pane active" id="tab-geral">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="mb-3">Informações do Projeto</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">CLIENTE</label>
                                                <div class="fw-bold">{{ $projeto->cliente->nome }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">CÓDIGO</label>
                                                <div class="fw-bold">{{ $projeto->codigo }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($projeto->observacoes)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small">OBSERVAÇÕES</label>
                                            <div class="border p-3 rounded bg-light">
                                                {{ $projeto->observacoes }}
                                            </div>
                                        </div>
                                    @endif

                                    @if ($projeto->enderecoInstalacao)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small">ENDEREÇO DE INSTALAÇÃO</label>
                                            <div class="border p-3 rounded bg-light">
                                                {{ $projeto->enderecoInstalacao->logradouro }},
                                                {{ $projeto->enderecoInstalacao->numero }}<br>
                                                {{ $projeto->enderecoInstalacao->bairro }} -
                                                {{ $projeto->enderecoInstalacao->cidade }}/{{ $projeto->enderecoInstalacao->estado }}<br>
                                                CEP: {{ $projeto->enderecoInstalacao->cep }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h4 class="mb-3">Timeline</h4>
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-date">{{ $projeto->created_at->format('d/m/Y') }}</div>
                                            <div class="timeline-content">
                                                <div class="timeline-title">Projeto Criado</div>
                                                <div class="text-muted">Por
                                                    {{ $projeto->gerente ? $projeto->gerente->name : 'Sistema' }}</div>
                                            </div>
                                        </div>
                                        @if ($projeto->data_inicio)
                                            <div class="timeline-item">
                                                <div class="timeline-date">{{ $projeto->data_inicio->format('d/m/Y') }}
                                                </div>
                                                <div class="timeline-content">
                                                    <div class="timeline-title">Início do Projeto</div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($projeto->data_entrega_real)
                                            <div class="timeline-item">
                                                <div class="timeline-date">
                                                    {{ $projeto->data_entrega_real->format('d/m/Y') }}</div>
                                                <div class="timeline-content">
                                                    <div class="timeline-title">Projeto Entregue</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aba Itens do Projeto -->
                        <div class="tab-pane" id="tab-itens">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Itens do Projeto</h4>
                                @if($projeto->orcamento && $projeto->itensProjeto->count() == 0)
                                    <button class="btn btn-primary btn-sm" onclick="criarItensAutomaticamente()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <line x1="12" y1="5" x2="12" y2="19" />
                                            <line x1="5" y1="12" x2="19" y2="12" />
                                        </svg>
                                        Criar Itens do Orçamento
                                    </button>
                                @endif
                            </div>

                            @if($projeto->itensProjeto->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantidade</th>
                                                <th>Unidade</th>
                                                <th>Preço Real</th>
                                                <th>Status</th>
                                                <th>Progresso</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projeto->itensProjeto as $item)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <div class="font-weight-medium">{{ $item->descricao }}</div>
                                                            @if($item->observacao)
                                                                <div class="text-muted small mt-1">{{ $item->observacao }}</div>
                                                            @endif
                                                            @if($item->categoria || $item->familia)
                                                                <div class="mt-1">
                                                                    @if($item->categoria)
                                                                        <span class="badge bg-azure-lt">{{ $item->categoria }}</span>
                                                                    @endif
                                                                    @if($item->familia)
                                                                        <span class="badge bg-cyan-lt">{{ $item->familia }}</span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary-lt">{{ number_format($item->quantidade, 3) }}</span>
                                                    </td>
                                                    <td>
                                                        {{ $item->unidade ? $item->unidade->nome : '-' }}
                                                    </td>
                                                    <td>
                                                        @if($item->preco_real)
                                                            <span class="text-info">R$ {{ number_format($item->preco_real, 2, ',', '.') }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="{{ $item->status_badge_class }}">{{ $item->status_label }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-fill me-2" style="height: 8px;">
                                                                <div class="progress-bar" 
                                                                     role="progressbar" 
                                                                     style="width: {{ $item->percentual_concluido }}%"
                                                                     aria-valuenow="{{ $item->percentual_concluido }}" 
                                                                     aria-valuemin="0" 
                                                                     aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span class="text-muted small">{{ $item->percentual_concluido }}%</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                                    onclick="editarProgresso({{ $item->id }}, {{ $item->percentual_concluido }})">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                                    <path d="M16 5l3 3"/>
                                                                </svg>
                                                            </button>
                                                            @if($item->codigo_promob)
                                                                <button type="button" class="btn btn-sm btn-outline-info" title="Item do Promob">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                                                        <path d="M12 12l8 -4.5"/>
                                                                        <path d="M12 12l0 9"/>
                                                                        <path d="M12 12l-8 -4.5"/>
                                                                    </svg>
                                                                </button>
                                                            @endif
                                                            <a href="{{ route('projetos.itens.promob.import', $item->id) }}" class="btn btn-sm btn-outline-success" title="Importar Materiais do Promob">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                                                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                                                    <path d="M12 17v-6"/>
                                                                    <path d="m9 14l3 3l3 -3"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Resumo dos Itens -->
                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h3 class="mb-1">{{ $projeto->itensProjeto->count() }}</h3>
                                                <div class="text-muted">Total de Itens</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h3 class="mb-1">{{ $projeto->itensProjeto->where('status', 'concluido')->count() }}</h3>
                                                <div class="text-success">Concluídos</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h3 class="mb-1">{{ $projeto->itensProjeto->where('status', 'em_andamento')->count() }}</h3>
                                                <div class="text-primary">Em Andamento</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h3 class="mb-1">{{ number_format($projeto->calcularProgressoGeral(), 1) }}%</h3>
                                                <div class="text-muted">Progresso Geral</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="empty">
                                    <div class="empty-img">
                                        <img src="{{ asset('tabler/static/illustrations/undraw_checklist_re_2w7v.svg') }}" height="128" alt="">
                                    </div>
                                    <p class="empty-title">Nenhum item encontrado</p>
                                    <p class="empty-subtitle text-muted">
                                        @if($projeto->orcamento)
                                            Este projeto foi criado a partir de um orçamento. Clique no botão acima para criar os itens automaticamente.
                                        @else
                                            Este projeto não possui itens. Itens podem ser criados automaticamente quando o projeto é baseado em um orçamento.
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Aba Materiais -->
                        <div class="tab-pane" id="tab-materiais">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Materiais do Projeto (BOM)</h4>
                                <button class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <line x1="12" y1="5" x2="12" y2="19" />
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg>
                                    Adicionar Material
                                </button>
                            </div>

                            @if ($projeto->materiaisProjeto->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>Material</th>
                                                <th>Tipo</th>
                                                <th>Necessário</th>
                                                <th>Reservado</th>
                                                <th>Baixado</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projeto->materiaisProjeto as $materialProjeto)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $materialProjeto->material->nome }}</div>
                                                        <div class="text-muted small">
                                                            {{ $materialProjeto->material->codigo }}</div>
                                                    </td>
                                                    <td>{{ $materialProjeto->material->tipoMaterial->nome ?? '-' }}</td>
                                                    <td>{{ number_format($materialProjeto->quantidade_necessaria, 2, ',', '.') }}
                                                        {{ $materialProjeto->material->unidade->sigla ?? '' }}</td>
                                                    <td>{{ number_format($materialProjeto->quantidade_reservada, 2, ',', '.') }}
                                                        {{ $materialProjeto->material->unidade->sigla ?? '' }}</td>
                                                    <td>{{ number_format($materialProjeto->quantidade_baixada, 2, ',', '.') }}
                                                        {{ $materialProjeto->material->unidade->sigla ?? '' }}</td>
                                                    <td>
                                                        <span class="{{ $materialProjeto->status_badge_class }}">
                                                            {{ $materialProjeto->status_label }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-list">
                                                            <button class="btn btn-sm btn-outline-primary">Editar</button>
                                                            <button class="btn btn-sm btn-outline-danger">Remover</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty">
                                    <div class="empty-img">
                                        <img src="{{ asset('tabler/static/illustrations/undraw_abstract_x68e.svg') }}"
                                            height="128" alt="">
                                    </div>
                                    <p class="empty-title">Nenhum material adicionado</p>
                                    <p class="empty-subtitle text-muted">
                                        Adicione materiais para começar a montar a BOM do projeto.
                                    </p>
                                    <div class="empty-action">
                                        <button class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                            Adicionar Material
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Aba Contratos -->
                        <div class="tab-pane" id="tab-contratos">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Contratos</h4>
                                <button class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <line x1="12" y1="5" x2="12" y2="19" />
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg>
                                    Novo Contrato
                                </button>
                            </div>

                            @if ($projeto->contratos->count() > 0)
                                <div class="row">
                                    @foreach ($projeto->contratos as $contrato)
                                        <div class="col-md-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h5 class="card-title mb-1">{{ $contrato->titulo }}</h5>
                                                        <span class="{{ $contrato->status_badge_class }}">
                                                            {{ $contrato->status_label }}
                                                        </span>
                                                    </div>
                                                    @if ($contrato->numero)
                                                        <div class="text-muted small mb-2">{{ $contrato->numero }}</div>
                                                    @endif
                                                    @if ($contrato->valor)
                                                        <div class="mb-2">
                                                            <strong>Valor:</strong> R$
                                                            {{ number_format($contrato->valor, 2, ',', '.') }}
                                                        </div>
                                                    @endif
                                                    @if ($contrato->data_vencimento)
                                                        <div class="mb-2">
                                                            <strong>Vencimento:</strong>
                                                            {{ $contrato->data_vencimento->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                    <div class="btn-list">
                                                        <button class="btn btn-sm btn-outline-primary">Ver</button>
                                                        <button class="btn btn-sm btn-outline-secondary">Editar</button>
                                                        @if ($contrato->tem_arquivo)
                                                            <button
                                                                class="btn btn-sm btn-outline-success">Download</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty">
                                    <div class="empty-img">
                                        <img src="{{ asset('tabler/static/illustrations/undraw_contract_uy56.svg') }}"
                                            height="128" alt="">
                                    </div>
                                    <p class="empty-title">Nenhum contrato criado</p>
                                    <p class="empty-subtitle text-muted">
                                        Crie contratos para formalizar o projeto com o cliente.
                                    </p>
                                    <div class="empty-action">
                                        <button class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                            Novo Contrato
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Aba Etapas -->
                        <div class="tab-pane" id="tab-etapas">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Etapas do Projeto</h4>
                                <button class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <line x1="12" y1="5" x2="12" y2="19" />
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg>
                                    Nova Etapa
                                </button>
                            </div>

                            <div class="empty">
                                <div class="empty-img">
                                    <img src="{{ asset('tabler/static/illustrations/undraw_checklist_re_2w7v.svg') }}"
                                        height="128" alt="">
                                </div>
                                <p class="empty-title">Funcionalidade em desenvolvimento</p>
                                <p class="empty-subtitle text-muted">
                                    As etapas do projeto estarão disponíveis em breve.
                                </p>
                            </div>
                        </div>

                        <!-- Aba Anexos -->
                        <div class="tab-pane" id="tab-anexos">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Anexos</h4>
                                <button class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M12 17v-6" />
                                        <path d="M9.5 14.5l2.5 2.5l2.5 -2.5" />
                                    </svg>
                                    Upload Arquivo
                                </button>
                            </div>

                            <div class="empty">
                                <div class="empty-img">
                                    <img src="{{ asset('tabler/static/illustrations/undraw_add_files_re_v09g.svg') }}"
                                        height="128" alt="">
                                </div>
                                <p class="empty-title">Nenhum anexo</p>
                                <p class="empty-subtitle text-muted">
                                    Faça upload de documentos, imagens e outros arquivos relacionados ao projeto.
                                </p>
                                <div class="empty-action">
                                    <button class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M12 17v-6" />
                                            <path d="M9.5 14.5l2.5 2.5l2.5 -2.5" />
                                        </svg>
                                        Upload Arquivo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmação de exclusão -->
    <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">Tem certeza?</div>
                    <div>Esta ação não pode ser desfeita. O projeto será excluído permanentemente.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">Cancelar</button>
                    <form id="delete-form" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sim, excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
        <script>
            function confirmDelete(projetoId) {
                const form = document.getElementById('delete-form');
                form.action = '{{ route('projetos.destroy', ['projeto' => ':id']) }}'.replace(':id', projetoId);
                const modal = new bootstrap.Modal(document.getElementById('modal-delete'));
                modal.show();
            }
        </script>
    
@endsection
