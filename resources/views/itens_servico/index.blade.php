@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('itens-servico.index') }}" class="btn-link">Itens de Serviço</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-list fa-lg me-2"></i>
                        Itens de Serviço
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('itens-servico.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <i class="fa-solid fa-plus icon"></i>
                            Novo Item
                        </a>
                        <a href="{{ route('itens-servico.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                            <form method="GET" action="{{ route('itens-servico.index') }}" class="row g-3">
                                <div class="col-md-6">
                                    <label for="descricao_item" class="form-label">Descrição do Item</label>
                                    <input type="text" class="form-control" id="descricao_item" name="descricao_item" value="{{ request('descricao_item') }}" placeholder="Pesquisar por descrição...">
                                </div>
                                <div class="col-md-4">
                                    <label for="servico_id" class="form-label">Serviço</label>
                                    <select class="form-select" id="servico_id" name="servico_id">
                                        <option value="">Todos</option>
                                        @foreach($servicos as $servico)
                                            <option value="{{ $servico->id }}" @if(request('servico_id') == $servico->id) selected @endif>{{ $servico->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <div class="btn-group w-100" role="group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-search me-1"></i>
                                            Pesquisar
                                        </button>
                                        <a href="{{ route('itens-servico.index') }}" class="btn btn-outline-secondary">
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
            <!-- Lista de Itens de Serviço -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Itens de Serviço</h3>
                    <span class="badge bg-blue-lt ms-2">{{ $itens->total() }} registros</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Serviço</th>
                                <th>Criado em</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($itens as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->descricao_item }}</td>
                                    <td>{{ $item->servico->nome ?? '-' }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('itens-servico.show', $item) }}" class="btn btn-outline-primary btn-sm" title="Visualizar"><i class="fa-solid fa-eye"></i></a>
                                            <a href="{{ route('itens-servico.edit', $item) }}" class="btn btn-outline-secondary btn-sm" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                        <!-- Modal de Exclusão -->
                                        <div class="modal modal-blur fade" id="modal-excluir-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirmar Exclusão</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja excluir o item <strong>{{ $item->descricao_item }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="{{ route('itens-servico.destroy', $item) }}">
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
                                        <div class="mb-2">Nenhum item cadastrado.</div>
                                        <a href="{{ route('itens-servico.create') }}" class="btn btn-primary">Cadastrar o primeiro item</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    {{ $itens->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
