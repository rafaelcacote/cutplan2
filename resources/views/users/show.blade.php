@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('users.index') }}" class="btn-link">Usuários</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-user fa-lg me-2"></i>
                        Visualizar Usuário
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <span class="avatar avatar-xl" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=206bc4&color=fff&size=128)"></span>
                            </div>
                            <h3 class="m-0 mb-1">{{ $user->name }}</h3>
                            <div class="text-muted">{{ $user->email }}</div>
                            <div class="mt-3">
                                <span class="badge bg-purple-lt">ID: {{ $user->id }}</span>
                                @if($user->cpf)
                                    <span class="badge bg-blue-lt">CPF: {{ $user->formatted_cpf }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('users.edit', $user) }}" class="card-btn">
                                <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                            </a>
                            <button class="card-btn text-red" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash me-2"></i> Excluir
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informações do Usuário</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nome Completo</label>
                                        <div class="form-control-plaintext">{{ $user->name }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-mail</label>
                                        <div class="form-control-plaintext">
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">CPF</label>
                                        <div class="form-control-plaintext">
                                            {{ $user->formatted_cpf ?: 'Não informado' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Empresa</label>
                                        <div class="form-control-plaintext">
                                            @if($user->tenant)
                                                <i class="fa-solid fa-building me-2 text-primary"></i>
                                                {{ $user->tenant->nome }}
                                                @if($user->tenant->cnpj)
                                                    <small class="text-muted">({{ $user->tenant->formatted_cnpj }})</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Não vinculado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Cadastrado por</label>
                                        <div class="form-control-plaintext">
                                            @if($user->creator)
                                                <span class="avatar avatar-xs me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->creator->name) }}&background=206bc4&color=fff')"></span>
                                                {{ $user->creator->name }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status de Verificação</label>
                                        <div class="form-control-plaintext">
                                            @if($user->email_verified_at)
                                                <span class="badge bg-green">E-mail Verificado</span>
                                                <small class="text-muted d-block">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge bg-yellow">E-mail Não Verificado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Data de Criação</label>
                                        <div class="form-control-plaintext">
                                            {{ $user->created_at->format('d/m/Y H:i') }}
                                            <small class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Última Atualização</label>
                                        <div class="form-control-plaintext">
                                            {{ $user->updated_at->format('d/m/Y H:i') }}
                                            <small class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline / Activity Log (placeholder) -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Atividades Recentes</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot status-dot-animated bg-green d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Usuário criado</strong>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Conta criada no sistema
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-muted">{{ $user->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if($user->email_verified_at)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot bg-blue d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>E-mail verificado</strong>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Endereço de e-mail confirmado
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-muted">{{ $user->email_verified_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Exclusão -->
    <div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <i class="fa-solid fa-triangle-exclamation icon mb-2 text-danger icon-lg"></i>
                    <h3>Tem certeza?</h3>
                    <div class="text-muted">Você realmente deseja excluir o usuário <strong>{{ $user->name }}</strong>? Esta ação não pode ser desfeita.</div>
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
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="w-100">
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
</div>
@endsection
