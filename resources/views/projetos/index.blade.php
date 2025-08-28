@extends('layouts.app')

@section('title', 'Projetos')

@push('styles')
    <style>
        .project-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .project-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .status-indicator {
            width: 4px;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            border-radius: 8px 0 0 8px;
        }

        .filters-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Gestão
                    </div>
                    <h2 class="page-title">
                        Projetos
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('projetos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Novo Projeto
                        </a>
                        <a href="{{ route('projetos.create') }}" class="btn btn-primary d-sm-none btn-icon"
                            aria-label="Novo projeto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Filtros -->
            <div class="card filters-card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('projetos.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Cliente</label>
                                <select name="cliente_id" class="form-select">
                                    <option value="">Todos os clientes</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Todos os status</option>
                                    @foreach ($statusOptions as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ request('status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Gerente</label>
                                <select name="gerente_id" class="form-select">
                                    <option value="">Todos os gerentes</option>
                                    @foreach ($gerentes as $gerente)
                                        <option value="{{ $gerente->id }}"
                                            {{ request('gerente_id') == $gerente->id ? 'selected' : '' }}>
                                            {{ $gerente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Data Início</label>
                                <input type="date" name="data_inicio" class="form-control"
                                    value="{{ request('data_inicio') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Data Fim</label>
                                <input type="date" name="data_fim" class="form-control"
                                    value="{{ request('data_fim') }}">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <circle cx="10" cy="10" r="7" />
                                            <path d="m21 21-6-6" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('projetos.index') }}" class="btn btn-outline-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="m18 6-12 12" />
                                            <path d="m6 6 12 12" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Projetos -->
            @if ($projetos->count() > 0)
                <div class="row">
                    @foreach ($projetos as $projeto)
                        <div class="col-12 col-md-6 col-xl-4 mb-4">
                            <div class="card project-card position-relative">
                                <div
                                    class="status-indicator bg-{{ $projeto->status == 'em_planejamento' ? 'secondary' : ($projeto->status == 'producao' ? 'primary' : ($projeto->status == 'montagem' ? 'info' : ($projeto->status == 'vistoria' ? 'warning' : ($projeto->status == 'concluido' ? 'success' : 'danger')))) }}">
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h3 class="card-title mb-1">
                                                <a href="{{ route('projetos.show', $projeto) }}"
                                                    class="text-decoration-none">
                                                    {{ $projeto->nome }}
                                                </a>
                                            </h3>
                                            <div class="text-muted small">
                                                {{ $projeto->codigo }}
                                            </div>
                                        </div>
                                        <span class="{{ $projeto->status_badge_class }}">
                                            {{ $projeto->status_label }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small mb-1">Cliente</div>
                                        <div class="fw-bold">{{ $projeto->cliente->nome }}</div>
                                    </div>

                                    @if ($projeto->gerente)
                                        <div class="mb-3">
                                            <div class="text-muted small mb-1">Gerente</div>
                                            <div>{{ $projeto->gerente->name }}</div>
                                        </div>
                                    @endif

                                    @if ($projeto->data_entrega_prevista)
                                        <div class="mb-3">
                                            <div class="text-muted small mb-1">Entrega Prevista</div>
                                            <div
                                                class="{{ $projeto->data_entrega_prevista < now() && $projeto->status != 'concluido' ? 'text-danger fw-bold' : '' }}">
                                                {{ $projeto->data_entrega_prevista->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    @endif

                                    @if ($projeto->equipe)
                                        <div class="mb-3">
                                            <div class="text-muted small mb-1">Equipe</div>
                                            <div>{{ $projeto->equipe->nome }}</div>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer bg-transparent">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-muted small">
                                                Criado em {{ $projeto->created_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="btn-list">
                                                <a href="{{ route('projetos.show', $projeto) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    Ver
                                                </a>
                                                <a href="{{ route('projetos.edit', $projeto) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    Editar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                @if ($projetos->hasPages())
                    <div class="mt-4">
                        {{ $projetos->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <div class="empty">
                    <div class="empty-img">
                        <img src="{{ asset('tabler/static/illustrations/undraw_printing_invoices_5r4r.svg') }}"
                            height="128" alt="">
                    </div>
                    <p class="empty-title">Nenhum projeto encontrado</p>
                    <p class="empty-subtitle text-muted">
                        @if (request()->hasAny(['cliente_id', 'status', 'gerente_id', 'data_inicio', 'data_fim']))
                            Tente ajustar os filtros ou
                            <a href="{{ route('projetos.index') }}" class="link-primary">limpar filtros</a>
                        @else
                            Comece criando seu primeiro projeto.
                        @endif
                    </p>
                    <div class="empty-action">
                        <a href="{{ route('projetos.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Novo Projeto
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
