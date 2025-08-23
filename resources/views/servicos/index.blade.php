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
                                        @if($servico->ativo)
                                            <span class="badge bg-green-lt">Ativo</span>
                                        @else
                                            <span class="badge bg-red-lt">Inativo</span>
                                        @endif
                                    </td>
                                    <td>{{ $servico->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('servicos.show', $servico) }}" class="btn btn-outline-primary btn-sm" title="Visualizar"><i class="fa-solid fa-eye"></i></a>
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
                                    <td colspan="5" class="text-center">
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
@endsection
