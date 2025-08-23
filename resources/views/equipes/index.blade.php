@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Administração</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-people-group icon me-2"></i>
                            Equipes
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('equipes.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Nova Equipe
                            </a>
                            <a href="{{ route('equipes.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                                <form method="GET" action="{{ route('equipes.index') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search_nome" class="form-label">Nome</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-users"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_nome" name="search_nome"
                                                value="{{ request('search_nome') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="search_ativo" class="form-label">Status</label>
                                        <select class="form-select" id="search_ativo" name="search_ativo">
                                            <option value="">Todos</option>
                                            <option value="1" @if(request('search_ativo')==='1') selected @endif>Ativo</option>
                                            <option value="0" @if(request('search_ativo')==='0') selected @endif>Inativo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('equipes.index') }}" class="btn btn-outline-secondary">
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
                <!-- Lista de Equipes -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Equipes</h3>
                        <span class="badge bg-blue-lt ms-2">{{ $equipes->total() }} registros</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Líder</th>
                                    <th>Membros</th>
                                    <th>Status</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($equipes as $equipe)
                                    <tr>
                                        <td>{{ $equipe->id }}</td>
                                        <td>{{ $equipe->nome }}</td>
                                        <td>{{ $equipe->lider ? $equipe->lider->nome : '-' }}</td>
                                        <td>
                                            @if($equipe->membros && $equipe->membros->count() > 0)
                                                <span class="badge bg-blue-lt">{{ $equipe->membros->count() }} membro{{ $equipe->membros->count() > 1 ? 's' : '' }}</span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($equipe->ativo)
                                                <span class="badge bg-green-lt">Ativo</span>
                                            @else
                                                <span class="badge bg-red-lt">Inativo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <a href="{{ route('equipes.show', $equipe) }}" class="btn btn-outline-primary btn-sm" title="Visualizar"><i class="fa-solid fa-eye"></i></a>
                                                <a href="{{ route('equipes.edit', $equipe) }}" class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                                <a href="{{ route('equipes.membros', $equipe) }}" class="btn btn-outline-info btn-sm" title="Gerenciar Membros"><i class="fa-solid fa-users"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $equipe->id }}"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                            <!-- Modal de Exclusão -->
                                            <div class="modal modal-blur fade" id="modal-excluir-{{ $equipe->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Exclusão</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Tem certeza que deseja excluir a equipe <strong>{{ $equipe->nome }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST" action="{{ route('equipes.destroy', $equipe) }}">
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
                                        <td colspan="5" class="text-center">
                                            <i class="fa-solid fa-box-open fa-3x text-muted mb-2"></i>
                                            <div class="mb-2">Nenhuma equipe encontrada.</div>
                                            <a href="{{ route('equipes.create') }}" class="btn btn-primary">Criar primeira equipe</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        {{ $equipes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
