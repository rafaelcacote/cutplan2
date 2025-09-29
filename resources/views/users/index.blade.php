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
                            <i class="fa-solid fa-users icon me-2"></i>
                            Usuários
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            @can('usuarios.criar')
                                <a href="{{ route('users.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                    <i class="fa-solid fa-plus icon"></i>
                                    Novo Usuário
                                </a>
                                <a href="{{ route('users.create') }}" class="btn btn-primary d-sm-none btn-icon">
                                    <i class="fa-solid fa-plus icon"></i>
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
                                <form method="GET" action="{{ route('users.index') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search_name" class="form-label">Nome</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_name" name="search_name"
                                                value="{{ request('search_name') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="search_cpf" class="form-label">CPF</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-id-card"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_cpf" name="search_cpf"
                                                value="{{ request('search_cpf') }}" placeholder="Pesquisar por CPF..."
                                                data-mask="000.000.000-00">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
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
                                <h3 class="card-title">Lista de Usuários</h3>
                                <div class="card-actions">
                                    <!-- <a href="#" class="btn btn-outline-secondary btn-sm">
                                            <i class="fa-solid fa-download icon"></i>
                                            Exportar
                                        </a> -->
                                </div>
                            </div>
                            <div class="table-responsive position-relative" style="min-width:100%;" id="table-container">
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
                                                Pesquisando usuários...
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-vcenter card-table w-100" style="min-width:1200px;">
                                    <thead>
                                        <tr>
                                            <th class="w-1">ID</th>
                                            <th>Usuário</th>
                                            <th>E-mail</th>
                                            <th>CPF</th>
                                            <th>Empresa</th>
                                            <th>Perfil</th>
                                            <th>Data de Criação</th>
                                            <th class="w-1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td class="text-muted">
                                                    <span class="badge bg-secondary-lt">#{{ $user->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=206bc4&color=fff)"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{ $user->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-muted">
                                                        <i class="fa-solid fa-envelope icon icon-sm me-1"></i>
                                                        {{ $user->email }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($user->cpf)
                                                        <span class="badge bg-blue-lt">{{ $user->formatted_cpf }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->tenant)
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa-solid fa-building me-2 text-primary"></i>
                                                            <div>
                                                                <div class="font-weight-medium">{{ $user->tenant->nome }}</div>
                                                                @if($user->tenant->cnpj)
                                                                    <small class="text-muted">{{ $user->tenant->formatted_cnpj }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Não vinculado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->roles->isNotEmpty())
                                                        <span class="badge bg-purple-lt">
                                                            <i class="fa-solid fa-user-shield me-1"></i>
                                                            {{ $user->roles->first()->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Sem perfil</span>
                                                    @endif
                                                </td>
                                                <td class="text-muted">
                                                    {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @can('usuarios.visualizar')
                                                            <a href="{{ route('users.show', $user) }}" class="action-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Visualizar">
                                                                <i class="fa-solid fa-eye fa-lg text-primary"></i>
                                                            </a>
                                                        @endcan
                                                        @can('usuarios.editar')
                                                            <a href="{{ route('users.edit', $user) }}" class="action-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Editar">
                                                                <i class="fa-solid fa-pen-to-square fa-lg text-warning"></i>
                                                            </a>
                                                        @endcan
                                                        @can('usuarios.excluir')
                                                            @if ($user->email !== 'admin@admin.com')
                                                                <a href="#" class="action-btn" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal{{ $user->id }}"
                                                                    title="Excluir">
                                                                    <i class="fa-solid fa-trash fa-lg text-danger"></i>
                                                                </a>
                                                            @else
                                                                <span class="action-btn disabled"
                                                                    title="Usuário administrador não pode ser excluído"
                                                                    style="cursor:not-allowed; opacity:0.5;">
                                                                    <i class="fa-solid fa-trash fa-lg text-danger"></i>
                                                                </span>
                                                            @endif
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
                                                        <p class="empty-title">Nenhum usuário encontrado</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Tente criar um novo usuário para começar.
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('users.create') }}"
                                                                class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar seu primeiro usuário
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
                @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                <li class="page-item{{ $users->onFirstPage() ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}" tabindex="-1"
                                        aria-disabled="{{ $users->onFirstPage() ? 'true' : 'false' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                                {{-- Pagination Elements --}}
                                @foreach ($users->links()->elements[0] as $page => $url)
                                    @if ($url)
                                        <li class="page-item{{ $page == $users->currentPage() ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @endif
                                @endforeach
                                {{-- Next Page Link --}}
                                <li class="page-item{{ $users->hasMorePages() ? '' : ' disabled' }}">
                                    <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}"
                                        aria-disabled="{{ $users->hasMorePages() ? 'false' : 'true' }}">
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
        @foreach ($users as $user)
            <div class="modal modal-blur fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-status bg-danger"></div>
                        <div class="modal-body text-center py-4">
                            <i class="fa-solid fa-triangle-exclamation icon mb-2 text-danger icon-lg"></i>
                            <h3>Tem certeza?</h3>
                            <div class="text-muted">Você realmente deseja excluir o usuário
                                <strong>{{ $user->name }}</strong>? Esta ação não pode ser desfeita.
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
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
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
        <script src="https://cdn.jsdelivr.net/npm/imask@7.1.3/dist/imask.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Máscara para CPF
                const cpfInput = document.getElementById('search_cpf');
                if (cpfInput) {
                    IMask(cpfInput, {
                        mask: '000.000.000-00'
                    });
                }

                // Loading overlay para pesquisa
                const searchForm = document.querySelector('form[action*="users.index"]');
                const tableLoading = document.getElementById('table-loading');
                const searchButton = searchForm.querySelector('button[type="submit"]');

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
