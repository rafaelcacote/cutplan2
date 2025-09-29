@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Administração</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-diagram-project icon me-2"></i>
                            Projetos
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('projetos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Novo Projeto
                            </a>
                            <a href="{{ route('projetos.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                @if (session('success'))
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
                                <form method="GET" action="{{ route('projetos.index') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <label for="cliente_id" class="form-label">Cliente</label>
                                        <select name="cliente_id" id="cliente_id" class="form-select">
                                            <option value="">Todos os clientes</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                    {{ $cliente->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="">Todos os status</option>
                                            @foreach($statusOptions as $value => $label)
                                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="gerente_id" class="form-label">Gerente</label>
                                        <select name="gerente_id" id="gerente_id" class="form-select">
                                            <option value="">Todos os gerentes</option>
                                            @foreach($gerentes as $gerente)
                                                <option value="{{ $gerente->id }}" {{ request('gerente_id') == $gerente->id ? 'selected' : '' }}>
                                                    {{ $gerente->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="data_inicio" class="form-label">Data Início</label>
                                        <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="data_fim" class="form-label">Data Fim</label>
                                        <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ request('data_fim') }}">
                                    </div>
                                    <div class="col-md-12 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <div class="btn-group" role="group">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-search me-1"></i>
                                                    Pesquisar
                                                </button>
                                                <a href="{{ route('projetos.index') }}" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fa-solid fa-times me-1"></i>
                                                    Limpar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Projetos</h3>
                                <div class="card-actions">
                                    <span class="text-muted">{{ $projetos->total() }} projeto(s) encontrado(s)</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Projeto</th>
                                            <th>Cliente</th>
                                            <th>Status</th>
                                            <th>Gerente</th>
                                            <th>Período</th>
                                            <th>Orçamento</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($projetos as $projeto)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $projeto->nome }}</div>
                                                    @if($projeto->descricao)
                                                        <div class="text-muted small">{{ Str::limit($projeto->descricao, 50) }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="fw-medium">{{ $projeto->cliente->nome }}</div>
                                                    @if($projeto->cliente->email)
                                                        <div class="text-muted small">{{ $projeto->cliente->email }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $statusClass = match($projeto->status) {
                                                            'planejamento' => 'bg-blue text-white',
                                                            'em_andamento' => 'bg-yellow text-white',
                                                            'concluido' => 'bg-lime text-white',
                                                            'pausado' => 'bg-orange text-white',
                                                            'cancelado' => 'bg-red text-white',
                                                            default => 'bg-secondary text-white'
                                                        };
                                                        $statusLabel = match($projeto->status) {
                                                            'planejamento' => 'Planejamento',
                                                            'em_andamento' => 'Em Andamento',
                                                            'concluido' => 'Concluído',
                                                            'pausado' => 'Pausado',
                                                            'cancelado' => 'Cancelado',
                                                            default => $projeto->status
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                                </td>
                                                <td>
                                                    @if($projeto->gerente)
                                                        <div class="fw-medium">{{ $projeto->gerente->name }}</div>
                                                    @else
                                                        <span class="text-muted">Não definido</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($projeto->data_inicio)
                                                        <div><strong>Início:</strong> {{ \Carbon\Carbon::parse($projeto->data_inicio)->format('d/m/Y') }}</div>
                                                    @endif
                                                    @if($projeto->data_fim)
                                                        <div><strong>Fim:</strong> {{ \Carbon\Carbon::parse($projeto->data_fim)->format('d/m/Y') }}</div>
                                                    @endif
                                                    @if(!$projeto->data_inicio && !$projeto->data_fim)
                                                        <span class="text-muted">Não definido</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($projeto->valor_orcado)
                                                        <div class="fw-bold text-success">R$ {{ number_format($projeto->valor_orcado, 2, ',', '.') }}</div>
                                                    @else
                                                        <span class="text-muted">Não definido</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-list flex-nowrap justify-content-end">
                                                        <a href="{{ route('projetos.show', $projeto) }}" class="btn btn-outline-primary btn-xs" title="Visualizar Detalhes">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('projetos.edit', $projeto) }}" class="btn btn-outline-secondary btn-xs" title="Editar Projeto">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger btn-xs" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $projeto->id }}" title="Excluir">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal Exclusão -->
                                            <div class="modal modal-blur fade" id="modal-excluir-{{ $projeto->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="modal-status bg-danger"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                            <h3>Tem certeza?</h3>
                                                            <div class="text-muted">Deseja realmente excluir o projeto <strong>{{ $projeto->nome }}</strong>? Esta ação não pode ser desfeita.</div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="w-100">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <button type="button" class="btn w-100" data-bs-dismiss="modal">Cancelar</button>
                                                                    </div>
                                                                    <div class="col">
                                                                        <form action="{{ route('projetos.destroy', $projeto) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger btn-sm">Sim, excluir</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-img">
                                                            <i class="fa-solid fa-diagram-project fa-3x text-muted mb-2"></i>
                                                        </div>
                                                        <p class="empty-title">Nenhum projeto encontrado</p>
                                                        <p class="empty-subtitle text-muted">
                                                            @if (request()->hasAny(['cliente_id', 'status', 'gerente_id', 'data_inicio', 'data_fim']))
                                                                Não há projetos que correspondam aos filtros aplicados.
                                                            @else
                                                                Não há projetos cadastrados.
                                                            @endif
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('projetos.create') }}" class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar seu primeiro projeto
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                {{ $projetos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection