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

        /* Garantir visibilidade dos badges de status */
        .badge {
            font-weight: 600 !important;
            font-size: 0.75rem !important;
        }
        
        .badge.bg-primary,
        .badge.bg-success,
        .badge.bg-danger,
        .badge.bg-secondary {
            color: white !important;
        }
        
        .badge.bg-light {
            color: #333 !important;
            border: 1px solid #dee2e6;
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
                                <div class="btn-group">
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
                                    <a href="{{ route('projetos.importar-xml', $projeto) }}" class="btn btn-success btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                            <path d="M12 12l8 -4.5"/>
                                            <path d="M12 12l0 9"/>
                                            <path d="M12 12l-8 -4.5"/>
                                        </svg>
                                        Importar XML Promob
                                    </a>
                                </div>
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
                                                <tr data-item-id="{{ $item->id }}">
                                                    <td>
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="font-weight-medium">{{ $item->descricao }}</div>
                                                                @if($item->codigo_promob)
                                                                    <span class="badge bg-success-lt ms-2" title="Importado do Promob">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                            <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                                                            <path d="M12 12l8 -4.5"/>
                                                                            <path d="M12 12l0 9"/>
                                                                            <path d="M12 12l-8 -4.5"/>
                                                                        </svg>
                                                                        Promob
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if($item->referencia)
                                                                <div class="text-muted small">Ref: {{ $item->referencia }}</div>
                                                            @endif
                                                            @if($item->observacao)
                                                                <div class="text-muted small mt-1">{{ $item->observacao }}</div>
                                                            @endif
                                                            @if($item->dimensoes_completas)
                                                                <div class="text-info small mt-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                        <rect x="4" y="4" width="6" height="6" rx="1"/>
                                                                        <rect x="14" y="4" width="6" height="6" rx="1"/>
                                                                        <rect x="4" y="14" width="6" height="6" rx="1"/>
                                                                        <rect x="14" y="14" width="6" height="6" rx="1"/>
                                                                    </svg>
                                                                    {{ $item->dimensoes_completas }}
                                                                </div>
                                                            @endif
                                                            <div class="mt-1">
                                                                @if($item->categoria)
                                                                    <span class="badge bg-azure-lt">{{ $item->categoria }}</span>
                                                                @endif
                                                                @if($item->familia)
                                                                    <span class="badge bg-cyan-lt">{{ $item->familia }}</span>
                                                                @endif
                                                                @if($item->grupo)
                                                                    <span class="badge bg-purple-lt">{{ $item->grupo }}</span>
                                                                @endif
                                                                @if($item->repeticao && $item->repeticao > 1)
                                                                    <span class="badge bg-yellow-lt">{{ $item->repeticao }}x</span>
                                                                @endif
                                                            </div>
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
                                                                    onclick="editarProgresso({{ $item->id }}, {{ $item->percentual_concluido }})"
                                                                    title="Editar progresso">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                                    <path d="M16 5l3 3"/>
                                                                </svg>
                                                            </button>
                                                            
                                                            <a href="{{ route('projetos.itens.importar-xml', [$projeto, $item]) }}" 
                                                               class="btn btn-sm btn-outline-success"
                                                               title="Importar materiais XML">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                                                    <path d="M12 12l8 -4.5"/>
                                                                    <path d="M12 12l0 9"/>
                                                                    <path d="M12 12l-8 -4.5"/>
                                                                </svg>
                                                            </a>

                                                            @if($item->materiaisPromob->count() > 0)
                                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                                        onclick="mostrarMateriaisItem({{ $item->id }})"
                                                                        title="Ver materiais ({{ $item->materiaisPromob->count() }})">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                        <path d="M8 9l5 5v7h-5v-4m0 4h-5v-7l5 -5m1 1v-6a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v17h-8"/>
                                                                        <path d="M13 7l0 .01"/>
                                                                        <path d="M17 7l0 .01"/>
                                                                        <path d="M17 11l0 .01"/>
                                                                        <path d="M13 11l0 .01"/>
                                                                    </svg>
                                                                    <span class="badge bg-info ms-1">{{ $item->materiaisPromob->count() }}</span>
                                                                </button>
                                                            @endif

                                                            @if($item->codigo_promob)
                                                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                                        onclick="mostrarDetalhesPromob({{ $item->id }})"
                                                                        title="Detalhes Promob">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                        <circle cx="12" cy="12" r="9"/>
                                                                        <path d="M12 8l.01 0"/>
                                                                        <path d="M11 12l1 0l0 4l1 0"/>
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
                                <div class="btn-group">
                                    <form method="POST" action="{{ route('projetos.contratos.gerar-cliente', $projeto) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm" title="Gerar contrato do cliente">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                            Gerar Contrato do Cliente
                                        </button>
                                    </form>
                                </div>
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
                                                        <button class="btn btn-sm btn-outline-primary" disabled>Ver</button>
                                                        <button class="btn btn-sm btn-outline-secondary" disabled>Editar</button>
                                                        @if ($contrato->tem_arquivo)
                                                            <a href="{{ route('contratos.download', $contrato) }}" class="btn btn-sm btn-outline-success">Download</a>
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
                                        <form method="POST" action="{{ route('projetos.contratos.gerar-cliente', $projeto) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="12" y1="5" x2="12" y2="19" />
                                                    <line x1="5" y1="12" x2="19" y2="12" />
                                                </svg>
                                                Gerar Contrato do Cliente
                                            </button>
                                        </form>
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

<<<<<<< HEAD
    <!-- Modal de detalhes do Promob -->
    <div class="modal modal-blur fade" id="modal-promob-details" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                            <path d="M12 12l8 -4.5"/>
                            <path d="M12 12l0 9"/>
                            <path d="M12 12l-8 -4.5"/>
                        </svg>
                        Dados do Promob
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="promob-details-content">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de materiais do item -->
    <div class="modal modal-blur fade" id="modalMateriaisItem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materiaisItemTitle">Materiais do Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div id="materiaisItemContent">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

=======
   
>>>>>>> 7012bec986af49e4fe38c2a79df68e11c2fd8a81
        <script>
            function confirmDelete(projetoId) {
                const form = document.getElementById('delete-form');
                form.action = '{{ route('projetos.destroy', ['projeto' => ':id']) }}'.replace(':id', projetoId);
                const modal = new bootstrap.Modal(document.getElementById('modal-delete'));
                modal.show();
            }

            function criarItensAutomaticamente() {
                if (confirm('Deseja criar os itens automaticamente baseados no orçamento?')) {
                    fetch('{{ route('projetos.criar-itens-orcamento', $projeto) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Erro ao criar itens');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao processar solicitação');
                    });
                }
            }

            function editarProgresso(itemId, progressoAtual) {
                const novoProgresso = prompt('Digite o novo progresso (0-100):', progressoAtual);
                
                if (novoProgresso !== null && !isNaN(novoProgresso) && novoProgresso >= 0 && novoProgresso <= 100) {
                    fetch(`{{ route('projetos.itens.progresso', ['projeto' => $projeto->id, 'item' => ':itemId']) }}`.replace(':itemId', itemId), {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            percentual_concluido: parseFloat(novoProgresso)
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Erro ao atualizar progresso');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao processar solicitação');
                    });
                }
            }

            function mostrarDetalhesPromob(itemId) {
                const modal = new bootstrap.Modal(document.getElementById('modal-promob-details'));
                const content = document.getElementById('promob-details-content');
                
                // Buscar item nos dados da página
                const item = @json($projeto->itensProjeto->keyBy('id'));
                
                if (item[itemId] && item[itemId].metadados_promob) {
                    const dados = item[itemId].metadados_promob;
                    const importacao = item[itemId].data_importacao_xml;
                    
                    content.innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Informações Básicas</h6>
                                <table class="table table-sm">
                                    <tr><td><strong>ID Promob:</strong></td><td>${dados.id_promob || '-'}</td></tr>
                                    <tr><td><strong>Referência:</strong></td><td>${dados.referencia || '-'}</td></tr>
                                    <tr><td><strong>Código:</strong></td><td>${dados.codigo_promob || '-'}</td></tr>
                                    <tr><td><strong>GUID:</strong></td><td class="text-muted small">${dados.guid || '-'}</td></tr>
                                    <tr><td><strong>Família:</strong></td><td>${dados.familia || '-'}</td></tr>
                                    <tr><td><strong>Grupo:</strong></td><td>${dados.grupo || '-'}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Dimensões e Quantidades</h6>
                                <table class="table table-sm">
                                    <tr><td><strong>Largura:</strong></td><td>${dados.largura || '-'} mm</td></tr>
                                    <tr><td><strong>Altura:</strong></td><td>${dados.altura || '-'} mm</td></tr>
                                    <tr><td><strong>Profundidade:</strong></td><td>${dados.profundidade || '-'} mm</td></tr>
                                    <tr><td><strong>Quantidade:</strong></td><td>${dados.quantidade || '-'} ${dados.unidade || ''}</td></tr>
                                    <tr><td><strong>Repetição:</strong></td><td>${dados.repeticao || 1}x</td></tr>
                                </table>
                            </div>
                        </div>
                        
                        ${dados.observacao ? `
                            <div class="mt-3">
                                <h6>Observações</h6>
                                <div class="bg-light p-2 rounded">${dados.observacao}</div>
                            </div>
                        ` : ''}
                        
                        <div class="mt-3">
                            <h6>Dados Técnicos</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">Categoria:</small><br>
                                    <span class="badge bg-azure-lt">${dados.categoria || 'N/A'}</span>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Ambiente:</small><br>
                                    <span class="badge bg-cyan-lt">${dados.ambiente || 'N/A'}</span>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Importado em:</small><br>
                                    <small>${importacao ? new Date(importacao).toLocaleString() : 'N/A'}</small>
                                </div>
                            </div>
                        </div>
                        
                        ${dados.component || dados.structure ? `
                            <div class="mt-3">
                                <h6>Informações Adicionais</h6>
                                <div class="row">
                                    ${dados.component ? `<div class="col-md-6"><small class="text-muted">Componente:</small><br>${dados.component}</div>` : ''}
                                    ${dados.structure ? `<div class="col-md-6"><small class="text-muted">Estrutura:</small><br>${dados.structure}</div>` : ''}
                                </div>
                            </div>
                        ` : ''}
                    `;
                } else {
                    content.innerHTML = `
                        <div class="alert alert-warning">
                            <h4 class="alert-title">Dados não disponíveis</h4>
                            <div class="text-muted">Este item não possui dados detalhados do Promob.</div>
                        </div>
                    `;
                }
                
                modal.show();
            }

            // Função para mostrar materiais de um item
            async function mostrarMateriaisItem(itemId) {
                try {
                    console.log('Carregando materiais para item:', itemId);
                    const url = `{{ route('projetos.itens.materiais', ['projeto' => $projeto->id, 'item' => ':item']) }}`.replace(':item', itemId);
                    console.log('URL da requisição:', url);
                    
                    const response = await fetch(url);
                    console.log('Response status:', response.status);
                    
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Erro na resposta:', response.status, errorText);
                        throw new Error(`Erro ${response.status}: ${errorText}`);
                    }
                    
                    const data = await response.json();
                    console.log('Dados recebidos:', data);
                    
                    // Buscar o modal - usando método mais compatível
                    const modalElement = document.getElementById('modalMateriaisItem');
                    let modal;
                    
                    // Método 1: Tentar bootstrap global
                    if (typeof bootstrap !== 'undefined') {
                        modal = bootstrap.Modal.getInstance(modalElement);
                        if (!modal) {
                            modal = new bootstrap.Modal(modalElement);
                        }
                    } 
                    // Método 2: Tentar jQuery Bootstrap
                    else if (typeof $ !== 'undefined' && $.fn.modal) {
                        modal = {
                            show: function() {
                                $(modalElement).modal('show');
                            }
                        };
                    }
                    // Método 3: Manipulação manual do DOM
                    else {
                        modal = {
                            show: function() {
                                modalElement.classList.add('show');
                                modalElement.style.display = 'block';
                                modalElement.setAttribute('aria-hidden', 'false');
                                
                                // Adicionar backdrop
                                const backdrop = document.createElement('div');
                                backdrop.className = 'modal-backdrop fade show';
                                backdrop.id = 'modal-backdrop-' + Date.now();
                                document.body.appendChild(backdrop);
                                
                                // Fechar modal ao clicar no backdrop ou botão fechar
                                const closeModal = () => {
                                    modalElement.classList.remove('show');
                                    modalElement.style.display = 'none';
                                    modalElement.setAttribute('aria-hidden', 'true');
                                    if (backdrop.parentNode) {
                                        backdrop.parentNode.removeChild(backdrop);
                                    }
                                };
                                
                                backdrop.onclick = closeModal;
                                modalElement.querySelector('.btn-close').onclick = closeModal;
                                modalElement.querySelector('[data-bs-dismiss="modal"]').onclick = closeModal;
                            }
                        };
                    }
                    
                    // Preencher conteúdo
                    const content = document.getElementById('materiaisItemContent');
                    const itemNome = document.querySelector(`tr[data-item-id="${itemId}"] .font-weight-medium`);
                    document.getElementById('materiaisItemTitle').textContent = `Materiais - ${data.item.descricao}`;
                    
                    if (data.materiais && data.materiais.length > 0) {
                        content.innerHTML = `
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Dimensões</th>
                                            <th>Quantidade</th>
                                            <th>Categoria</th>
                                            <th>Grupo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.materiais.map(material => `
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">${material.descricao || 'N/A'}</div>
                                                    ${material.id_promob ? `<small class="text-muted">${material.id_promob}</small>` : ''}
                                                    ${material.referencia ? `<br><small class="text-info">Ref: ${material.referencia}</small>` : ''}
                                                </td>
                                                <td>
                                                    ${material.dimensoes_texto || `${material.largura}×${material.altura}×${material.profundidade}`}
                                                    <small class="text-muted d-block">${material.unidade || 'mm'}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-blue-lt">${material.quantidade || 1}</span>
                                                    ${material.repeticao > 1 ? `<br><small class="text-muted">${material.repeticao}x</small>` : ''}
                                                </td>
                                                <td>
                                                    <span class="badge bg-azure-lt">${material.categoria || 'N/A'}</span>
                                                    ${material.familia ? `<br><span class="badge bg-cyan-lt">${material.familia}</span>` : ''}
                                                </td>
                                                <td>
                                                    <span class="badge bg-purple-lt">${material.subcategoria || material.grupo || 'N/A'}</span>
                                                </td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        `;
                    } else {
                        content.innerHTML = `
                            <div class="alert alert-info">
                                <h4 class="alert-title">Nenhum material encontrado</h4>
                                <div class="text-muted">Este item ainda não possui materiais importados do Promob.</div>
                            </div>
                        `;
                    }
                    
                    modal.show();
                } catch (error) {
                    console.error('Erro ao carregar materiais:', error);
                    console.error('Stack trace:', error.stack);
                    
                    // Mostrar modal de erro com detalhes
                    const content = document.getElementById('materiaisItemContent');
                    content.innerHTML = `
                        <div class="alert alert-danger">
                            <h4 class="alert-title">Erro ao carregar materiais</h4>
                            <div class="text-muted">${error.message}</div>
                        </div>
                    `;
                    
                    const modalElement = document.getElementById('modalMateriaisItem');
                    let modal = {
                        show: function() {
                            modalElement.classList.add('show');
                            modalElement.style.display = 'block';
                            modalElement.setAttribute('aria-hidden', 'false');
                        }
                    };
                    document.getElementById('materiaisItemTitle').textContent = 'Erro';
                    modal.show();
                }
            }

            // Mostrar detalhes da importação se houver
            @if(session('import_details'))
                const importDetails = @json(session('import_details'));
                console.log('Detalhes da importação:', importDetails);
                
                // Aqui você pode mostrar um modal com os detalhes se necessário
                if (importDetails.total_erros > 0) {
                    console.warn('Houveram erros na importação:', importDetails.erros_gerais);
                }
            @endif
        </script>
<<<<<<< HEAD
=======
    
>>>>>>> 7012bec986af49e4fe38c2a79df68e11c2fd8a81
@endsection
