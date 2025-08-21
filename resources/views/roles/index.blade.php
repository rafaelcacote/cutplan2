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
                            <i class="fa-solid fa-user-shield icon me-2"></i>
                            Perfis
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            @can('perfis.criar')
                                <a href="{{ route('roles.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                    <i class="fa-solid fa-plus icon"></i>
                                    Novo Perfil
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Perfis</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th class="w-1">ID</th>
                                            <th>Nome</th>
                                            <th>Permissões</th>
                                            <th>Data de Criação</th>
                                            <th class="w-1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($roles as $role)
                                            <tr>
                                                <td class="text-muted">
                                                    <span class="badge bg-secondary-lt">#{{ $role->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($role->name) }}&background=1f2937&color=fff)"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{ $role->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-blue-lt">{{ $role->permissions->count() }}
                                                        permissões</span>
                                                </td>
                                                <td class="text-muted">
                                                    {{ $role->created_at ? $role->created_at->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @can('perfis.editar')
                                                            <a href="{{ route('roles.edit', $role) }}" class="action-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                                                <i class="fa-solid fa-pen-to-square fa-lg text-warning"></i>
                                                            </a>
                                                        @endcan
                                                        @can('perfis.excluir')
                                                            <a href="#" class="action-btn" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $role->id }}"
                                                                title="Excluir">
                                                                <i class="fa-solid fa-trash fa-lg text-danger"></i>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-img">
                                                            <img src="{{ asset('tabler/img/undraw_printing_invoices_5r4r.svg') }}"
                                                                height="128" alt="">
                                                        </div>
                                                        <p class="empty-title">Nenhum perfil encontrado</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Tente criar um novo perfil para começar.
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar seu primeiro perfil
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
            </div>
        </div>

        <!-- Modals de Exclusão -->
        @foreach ($roles as $role)
            <div class="modal modal-blur fade" id="deleteModal{{ $role->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-status bg-danger"></div>
                        <div class="modal-body text-center py-4">
                            <i class="fa-solid fa-triangle-exclamation icon mb-2 text-danger icon-lg"></i>
                            <h3>Tem certeza?</h3>
                            <div class="text-muted">Você realmente deseja excluir o perfil
                                <strong>{{ $role->name }}</strong>? Esta ação não pode ser desfeita.
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
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="w-100">
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
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    @endpush
@endsection
