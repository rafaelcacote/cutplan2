@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            Administração
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-key icon me-2"></i>
                            Permissões
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            @can('permissoes.criar')
                                <a href="{{ route('permissions.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                    <i class="fa-solid fa-plus icon"></i>
                                    Nova Permissão
                                </a>
                            @endcan


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                @if (session('success'))
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <i class="fa-solid fa-check icon alert-icon"></i>
                                    </div>
                                    <div>
                                        {{ session('success') }}
                                    </div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Filtros de Pesquisa -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('permissions.index') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search_name" class="form-label">Nome da Permissão</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-key"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_name" name="search_name"
                                                value="{{ request('search_name') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="search_module" class="form-label">Módulo</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-layer-group"></i>
                                            </span>
                                            <select class="form-control" id="search_module" name="search_module">
                                                <option value="">Todos os módulos</option>
                                                <option value="dashboard"
                                                    {{ request('search_module') == 'dashboard' ? 'selected' : '' }}>
                                                    Dashboard</option>
                                                <option value="usuarios"
                                                    {{ request('search_module') == 'usuarios' ? 'selected' : '' }}>Usuários
                                                </option>
                                                <option value="perfis"
                                                    {{ request('search_module') == 'perfis' ? 'selected' : '' }}>Perfis
                                                </option>
                                                <option value="permissoes"
                                                    {{ request('search_module') == 'permissoes' ? 'selected' : '' }}>
                                                    Permissões</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Permissões</h3>
                            </div>
                            <div class="table-responsive position-relative" id="table-container">
                                <!-- Loading Overlay -->
                                <div id="table-loading" class="position-absolute w-100 h-100 d-none"
                                    style="top: 0; left: 0; background: rgba(255,255,255,0.8); z-index: 10;">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <div class="text-center">
                                            <div class="spinner-border text-primary mb-3" role="status">
                                                <span class="visually-hidden">Carregando...</span>
                                            </div>
                                            <div class="text-muted">
                                                <i class="fa-solid fa-search me-2"></i>
                                                Pesquisando permissões...
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th class="w-1">ID</th>
                                            <th>Permissão</th>
                                            <th>Módulo</th>
                                            <th>Ação</th>
                                            <th>Data de Criação</th>
                                            <th class="w-1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($permissions as $permission)
                                            @php
                                                $parts = explode('.', $permission->name);
                                                $module = $parts[0] ?? '';
                                                $action = $parts[1] ?? '';

                                                $moduleIcons = [
                                                    'dashboard' => 'fa-tachometer-alt',
                                                    'usuarios' => 'fa-users',
                                                    'perfis' => 'fa-user-shield',
                                                    'permissoes' => 'fa-key',
                                                ];

                                                $moduleLabels = [
                                                    'dashboard' => 'Dashboard',
                                                    'usuarios' => 'Usuários',
                                                    'perfis' => 'Perfis',
                                                    'permissoes' => 'Permissões',
                                                ];

                                                $actionLabels = [
                                                    'acessar' => 'Acessar',
                                                    'listar' => 'Listar',
                                                    'visualizar' => 'Visualizar',
                                                    'criar' => 'Criar',
                                                    'editar' => 'Editar',
                                                    'excluir' => 'Excluir',
                                                ];
                                            @endphp
                                            <tr>
                                                <td class="text-muted">
                                                    <span class="badge bg-secondary-lt">#{{ $permission->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($permission->name) }}&background=dc2626&color=fff)"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{ $permission->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i
                                                            class="fa-solid {{ $moduleIcons[$module] ?? 'fa-cog' }} me-2 text-primary"></i>
                                                        <span
                                                            class="badge bg-blue-lt">{{ $moduleLabels[$module] ?? ucfirst($module) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-green-lt">{{ $actionLabels[$action] ?? ucfirst($action) }}</span>
                                                </td>
                                                <td class="text-muted">
                                                    {{ $permission->created_at ? $permission->created_at->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @can('permissoes.editar')
                                                            <a href="{{ route('permissions.edit', $permission) }}"
                                                                class="action-btn" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Editar">
                                                                <i class="fa-solid fa-pen-to-square fa-lg text-warning"></i>
                                                            </a>
                                                        @endcan
                                                        @can('permissoes.excluir')
                                                            <a href="#" class="action-btn" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $permission->id }}"
                                                                title="Excluir">
                                                                <i class="fa-solid fa-trash fa-lg text-danger"></i>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-img">
                                                            <img src="{{ asset('tabler/img/undraw_printing_invoices_5r4r.svg') }}"
                                                                height="128" alt="">
                                                        </div>
                                                        <p class="empty-title">Nenhuma permissão encontrada</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Tente criar uma nova permissão para começar.
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('permissions.create') }}"
                                                                class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar sua primeira permissão
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
                    </div>
                </div>
                @if ($permissions instanceof \Illuminate\Pagination\LengthAwarePaginator && $permissions->hasPages())
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                <li class="page-item{{ $permissions->onFirstPage() ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $permissions->previousPageUrl() ?? '#' }}"
                                        tabindex="-1"
                                        aria-disabled="{{ $permissions->onFirstPage() ? 'true' : 'false' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                                {{-- Pagination Elements --}}
                                @foreach ($permissions->links()->elements[0] as $page => $url)
                                    @if ($url)
                                        <li class="page-item{{ $page == $permissions->currentPage() ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @endif
                                @endforeach
                                {{-- Next Page Link --}}
                                <li class="page-item{{ $permissions->hasMorePages() ? '' : ' disabled' }}">
                                    <a class="page-link" href="{{ $permissions->nextPageUrl() ?? '#' }}"
                                        aria-disabled="{{ $permissions->hasMorePages() ? 'false' : 'true' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modals de Exclusão -->
        @foreach ($permissions as $permission)
            <div class="modal modal-blur fade" id="deleteModal{{ $permission->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-status bg-danger"></div>
                        <div class="modal-body text-center py-4">
                            <i class="fa-solid fa-triangle-exclamation icon mb-2 text-danger icon-lg"></i>
                            <h3>Tem certeza?</h3>
                            <div class="text-muted">Você realmente deseja excluir a permissão
                                <strong>{{ $permission->name }}</strong>? Esta ação não pode ser desfeita.
                            </div>
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
                                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST"
                                            class="w-100">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @push('styles')
        <style>
            .action-btn {
                padding: 0 6px;
                line-height: 1;
                border-radius: 50%;
                transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .action-btn:hover {
                background: #f1f3f9;
                box-shadow: 0 2px 8px 0 rgba(32, 32, 64, 0.08);
                transform: scale(1.13);
                text-decoration: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Loading overlay para pesquisa
                const searchForm = document.querySelector('form[action*="permissions.index"]');
                const tableLoading = document.getElementById('table-loading');
                const searchButton = searchForm ? searchForm.querySelector('button[type="submit"]') : null;

                if (searchForm && tableLoading) {
                    searchForm.addEventListener('submit', function(e) {
                        // Mostrar loading
                        tableLoading.classList.remove('d-none');

                        // Desabilitar botão de pesquisa
                        if (searchButton) {
                            searchButton.disabled = true;
                            searchButton.innerHTML =
                                '<i class="fa-solid fa-spinner fa-spin me-1"></i>Pesquisando...';
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
