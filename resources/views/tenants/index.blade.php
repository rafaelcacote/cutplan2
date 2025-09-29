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
                            <i class="fa-solid fa-building icon me-2"></i>
                            Empresas
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            @can('tenants.criar')
                                <a href="{{ route('tenants.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                    <i class="fa-solid fa-plus icon"></i>
                                    Nova Empresa
                                </a>
                                <a href="{{ route('tenants.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                                <form method="GET" action="{{ route('tenants.index') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <label for="search_name" class="form-label">Nome da Empresa</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-building"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_name" name="search_name"
                                                value="{{ request('search_name') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="search_cnpj" class="form-label">CNPJ</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-id-card"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_cnpj" name="search_cnpj"
                                                value="{{ request('search_cnpj') }}" placeholder="Pesquisar por CNPJ..."
                                                data-mask="00.000.000/0000-00">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="search_email" class="form-label">E-mail</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-envelope"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_email" name="search_email"
                                                value="{{ request('search_email') }}" placeholder="Pesquisar por e-mail...">
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">
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
                                <h3 class="card-title">Lista de Empresas</h3>
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
                                                Pesquisando empresas...
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-vcenter card-table w-100" style="min-width:1200px;">
                                    <thead>
                                        <tr>
                                            <th class="w-1">ID</th>
                                            <th>Empresa</th>
                                            <th>CNPJ</th>
                                            <th>Localização</th>
                                            <th>Contato</th>
                                            <th>Data de Criação</th>
                                            <th class="w-1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tenants as $tenant)
                                            <tr>
                                                <td class="text-muted">
                                                    <span class="badge bg-secondary-lt">#{{ $tenant->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        @if($tenant->logo)
                                                            <img class="avatar me-2" src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo">
                                                        @else
                                                            <span class="avatar me-2"
                                                                style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($tenant->nome) }}&background=206bc4&color=fff)"></span>
                                                        @endif
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{ $tenant->nome }}</div>
                                                            @if($tenant->slug)
                                                                <div class="text-muted small">{{ $tenant->slug }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($tenant->cnpj)
                                                        <span class="badge bg-blue-lt">{{ $tenant->formatted_cnpj }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($tenant->endereco)
                                                        <div class="text-muted small">
                                                            <i class="fa-solid fa-map-marker-alt icon icon-sm me-1"></i>
                                                            {{ $tenant->endereco->municipio->nome ?? 'N/A' }}/{{ $tenant->endereco->municipio->estado->uf ?? 'N/A' }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            {{ $tenant->endereco->bairro ?? 'N/A' }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($tenant->email)
                                                        <div class="text-muted small">
                                                            <i class="fa-solid fa-envelope icon icon-sm me-1"></i>
                                                            {{ $tenant->email }}
                                                        </div>
                                                    @endif
                                                    @if($tenant->telefone)
                                                        <div class="text-muted small">
                                                            <i class="fa-solid fa-phone icon icon-sm me-1"></i>
                                                            {{ $tenant->formatted_telefone }}
                                                        </div>
                                                    @endif
                                                    @if(!$tenant->email && !$tenant->telefone)
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-muted">
                                                    {{ $tenant->created_at ? $tenant->created_at->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @can('tenants.ver')
                                                            <a href="{{ route('tenants.show', $tenant) }}" class="action-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Visualizar">
                                                                <i class="fa-solid fa-eye fa-lg text-primary"></i>
                                                            </a>
                                                        @endcan
                                                        @can('tenants.editar')
                                                            <a href="{{ route('tenants.edit', $tenant) }}" class="action-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Editar">
                                                                <i class="fa-solid fa-pen-to-square fa-lg text-warning"></i>
                                                            </a>
                                                        @endcan
                                                        @can('tenants.excluir')
                                                            <a href="#" class="action-btn" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $tenant->id }}"
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
                                                        <p class="empty-title">Nenhuma empresa encontrada</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Crie uma nova empresa para começar.
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('tenants.create') }}"
                                                                class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar sua primeira empresa
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
                @if ($tenants instanceof \Illuminate\Pagination\LengthAwarePaginator && $tenants->hasPages())
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $tenants->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modals de Exclusão -->
        @foreach ($tenants as $tenant)
            <div class="modal modal-blur fade" id="deleteModal{{ $tenant->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-status bg-danger"></div>
                        <div class="modal-body text-center py-4">
                            <i class="fa-solid fa-triangle-exclamation icon mb-2 text-danger icon-lg"></i>
                            <h3>Tem certeza?</h3>
                            <div class="text-muted">Você realmente deseja excluir a empresa
                                <strong>{{ $tenant->nome }}</strong>? Esta ação não pode ser desfeita.
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
                                        <form action="{{ route('tenants.destroy', $tenant) }}" method="POST"
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

    
        <script src="https://cdn.jsdelivr.net/npm/imask@7.1.3/dist/imask.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Máscara para CNPJ
                const cnpjInput = document.getElementById('search_cnpj');
                if (cnpjInput) {
                    IMask(cnpjInput, {
                        mask: '00.000.000/0000-00'
                    });
                }

                // Loading overlay para pesquisa
                const searchForm = document.querySelector('form[action*="tenants.index"]');
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
    
@endsection