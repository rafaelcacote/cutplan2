@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Administração</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-box icon me-2"></i>
                            Materiais
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('materiais.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Novo Material
                            </a>
                            <a href="{{ route('materiais.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                                <form method="GET" action="{{ route('materiais.index') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="nome" class="form-label">Nome</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-box"></i>
                                            </span>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                   value="{{ request('nome') }}" placeholder="Buscar por nome">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ativo" class="form-label">Ativo</label>
                                        <select name="ativo" id="ativo" class="form-select">
                                            <option value="">Todos</option>
                                            <option value="1" @selected(request('ativo')==='1')>Sim</option>
                                            <option value="0" @selected(request('ativo')==='0')>Não</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fa-solid fa-search me-1"></i>
                                            Pesquisar
                                        </button>
                                        <a href="{{ route('materiais.index') }}" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-times me-1"></i>
                                            Limpar
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lista de Materiais -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Materiais</h3>
                                <div class="card-actions">
                                    <span class="text-muted">{{ $materiais->total() }} registro(s) encontrado(s)</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Tipo</th>
                                                <th>Unidade</th>
                                                <th>Preço Custo</th>
                                                <th>Estoque Mínimo</th>
                                                <th>Controla Estoque</th>
                                                <th>Ativo</th>
                                                <th class="w-1">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($materiais as $item)
                                                <tr>
                                                    <td class="text-secondary">{{ $item->id }}</td>
                                                    <td>
                                                        <div class="d-flex py-1 align-items-center">
                                                             <span class="avatar me-2" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($item->nome) }}&background=206bc4&color=fff&size=64)"></span>
                                                            <div class="flex-fill">
                                                                <div class="font-weight-medium">{{ $item->nome }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->tipo->nome ?? '-' }}</td>
                                                    <td>{{ $item->unidade->nome ?? '-' }}</td>
                                                    <td>{{ $item->preco_custo ? 'R$ ' . number_format($item->preco_custo, 2, ',', '.') : '-' }}</td>
                                                    <td>{{ $item->estoque_minimo ?? '-' }}</td>
                                                    <td>
                                                        @if($item->controla_estoque)
                                                            <span class="badge rounded-pill bg-gradient bg-success text-white px-3 py-1 shadow-sm d-inline-flex align-items-center">
                                                                <i class="fa-solid fa-check-circle me-1"></i> Sim
                                                            </span>
                                                        @else
                                                            <span class="badge rounded-pill bg-gradient bg-secondary text-white px-3 py-1 shadow-sm d-inline-flex align-items-center">
                                                                <i class="fa-solid fa-times-circle me-1"></i> Não
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->ativo)
                                                            <span class="badge rounded-pill bg-gradient bg-success text-white px-3 py-1 shadow-sm d-inline-flex align-items-center">
                                                                <i class="fa-solid fa-circle-check me-1"></i> Ativo
                                                            </span>
                                                        @else
                                                            <span class="badge rounded-pill bg-gradient bg-danger text-white px-3 py-1 shadow-sm d-inline-flex align-items-center">
                                                                <i class="fa-solid fa-circle-xmark me-1"></i> Inativo
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-list flex-nowrap">
                                                            <a href="{{ route('materiais.show', $item) }}" class="btn btn-outline-primary btn-sm" title="Visualizar">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('materiais.edit', $item) }}" class="btn btn-outline-secondary btn-sm" title="Editar">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-excluir-{{ $item->id }}"
                                                                title="Excluir">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Modal Exclusão -->
                                                <div class="modal modal-blur fade" id="modal-excluir-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            <div class="modal-status bg-danger"></div>
                                                            <div class="modal-body text-center py-4">
                                                                <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                                <h3>Tem certeza?</h3>
                                                                <div class="text-muted">Deseja realmente excluir o material <strong>{{ $item->nome }}</strong>? Esta ação não pode ser desfeita.</div>
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
                                                                            <form action="{{ route('materiais.destroy', $item) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger w-100">
                                                                                    Sim, excluir
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-5">
                                                        <div class="empty">
                                                            <div class="empty-img"><img src="{{ asset('tabler/dist/img/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
                                                            </div>
                                                            <p class="empty-title">Nenhum material encontrado</p>
                                                            <p class="empty-subtitle text-muted">
                                                                Tente ajustar sua pesquisa ou filtro para encontrar o que você está procurando.
                                                            </p>
                                                            <div class="empty-action">
                                                                <a href="{{ route('materiais.create') }}" class="btn btn-primary">
                                                                    <i class="fa-solid fa-plus me-1"></i>
                                                                    Adicionar seu primeiro material
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($materiais->hasPages())
                                <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-muted">
                                        Mostrando <span>{{ $materiais->firstItem() }}</span> até <span>{{ $materiais->lastItem() }}</span>
                                        de <span>{{ $materiais->total() }}</span> resultados
                                    </p>
                                    <ul class="pagination m-0 ms-auto">
                                        {{ $materiais->links() }}
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
