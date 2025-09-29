@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('tenants.index') }}" class="btn-link">Empresas</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-building fa-lg me-2"></i>
                        {{ $tenant->nome }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('tenants.editar')
                            <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-primary">
                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                Editar
                            </a>
                        @endcan
                        <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">
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
                <!-- Informações da Empresa -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Informações da Empresa
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nome da Empresa</label>
                                        <div class="form-control-plaintext">
                                            <strong>{{ $tenant->nome }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">CNPJ</label>
                                        <div class="form-control-plaintext">
                                            @if($tenant->cnpj)
                                                <span class="badge bg-blue-lt fs-6">{{ $tenant->formatted_cnpj }}</span>
                                            @else
                                                <span class="text-muted">Não informado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-mail</label>
                                        <div class="form-control-plaintext">
                                            @if($tenant->email)
                                                <i class="fa-solid fa-envelope me-2 text-muted"></i>
                                                <a href="mailto:{{ $tenant->email }}">{{ $tenant->email }}</a>
                                            @else
                                                <span class="text-muted">Não informado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Telefone</label>
                                        <div class="form-control-plaintext">
                                            @if($tenant->telefone)
                                                <i class="fa-solid fa-phone me-2 text-muted"></i>
                                                <a href="tel:{{ $tenant->telefone }}">{{ $tenant->formatted_telefone }}</a>
                                            @else
                                                <span class="text-muted">Não informado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Endereço</label>
                                        <div class="form-control-plaintext">
                                            @if($tenant->endereco)
                                                <i class="fa-solid fa-map-marker-alt me-2 text-muted"></i>
                                                {{ $tenant->endereco->endereco }}, {{ $tenant->endereco->numero }}
                                                @if($tenant->endereco->complemento)
                                                    - {{ $tenant->endereco->complemento }}
                                                @endif
                                                <br>
                                                <small class="text-muted">
                                                    {{ $tenant->endereco->bairro }} - {{ $tenant->endereco->municipio->nome ?? 'N/A' }}/{{ $tenant->endereco->municipio->estado->uf ?? 'N/A' }}
                                                    @if($tenant->endereco->cep)
                                                        - CEP: {{ $tenant->endereco->cep }}
                                                    @endif
                                                </small>
                                                @if($tenant->endereco->referencia)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fa-solid fa-info-circle me-1"></i>
                                                        {{ $tenant->endereco->referencia }}
                                                    </small>
                                                @endif
                                            @else
                                                <span class="text-muted">Endereço não informado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Slug</label>
                                        <div class="form-control-plaintext">
                                            @if($tenant->slug)
                                                <code>{{ $tenant->slug }}</code>
                                            @else
                                                <span class="text-muted">Não informado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Data de Criação</label>
                                        <div class="form-control-plaintext">
                                            <i class="fa-solid fa-calendar me-2 text-muted"></i>
                                            {{ $tenant->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($tenant->updated_at && $tenant->updated_at != $tenant->created_at)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Última Atualização</label>
                                            <div class="form-control-plaintext">
                                                <i class="fa-solid fa-clock me-2 text-muted"></i>
                                                {{ $tenant->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card dos Usuários da Empresa -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-users me-2"></i>
                                Usuários da Empresa
                            </h3>
                            <div class="card-actions">
                                <span class="badge bg-primary">{{ $tenant->users->count() }} usuários</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($tenant->users->count() > 0)
                                <div class="row g-3">
                                    @foreach($tenant->users as $user)
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar me-3"
                                                    style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=206bc4&color=fff)"></span>
                                                <div>
                                                    <div class="font-weight-medium">{{ $user->name }}</div>
                                                    <div class="text-muted small">{{ $user->email }}</div>
                                                    @if($user->roles->isNotEmpty())
                                                        <span class="badge bg-purple-lt mt-1">
                                                            <i class="fa-solid fa-user-shield me-1"></i>
                                                            {{ $user->roles->first()->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <p class="empty-title">Nenhum usuário encontrado</p>
                                    <p class="empty-subtitle text-muted">
                                        Esta empresa ainda não possui usuários cadastrados.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar com Logo e Ações -->
                <div class="col-lg-4">
                    <!-- Logo da Empresa -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Logo da Empresa</h3>
                        </div>
                        <div class="card-body text-center">
                            @if($tenant->logo)
                                <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo de {{ $tenant->nome }}" class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                    <p class="empty-title">Sem logo</p>
                                    <p class="empty-subtitle text-muted">
                                        Nenhum logo foi enviado para esta empresa.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Estatísticas Rápidas -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Estatísticas</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="bg-primary text-white avatar">
                                                        <i class="fa-solid fa-users"></i>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">
                                                        {{ $tenant->users->count() }}
                                                    </div>
                                                    <div class="text-muted">Usuários</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="bg-green text-white avatar">
                                                        <i class="fa-solid fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">
                                                        {{ $tenant->created_at->diffInDays(now()) }}
                                                    </div>
                                                    <div class="text-muted">Dias</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações Rápidas -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Ações Rápidas</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @can('tenants.editar')
                                    <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-primary">
                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                        Editar Empresa
                                    </a>
                                @endcan
                                @can('usuarios.criar')
                                    <a href="{{ route('users.create') }}?tenant={{ $tenant->id }}" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-user-plus me-2"></i>
                                        Adicionar Usuário
                                    </a>
                                @endcan
                                @can('tenants.excluir')
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fa-solid fa-trash me-2"></i>
                                        Excluir Empresa
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('tenants.excluir')
        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <i class="fa-solid fa-triangle-exclamation icon mb-2 text-danger icon-lg"></i>
                        <h3>Tem certeza?</h3>
                        <div class="text-muted">Você realmente deseja excluir a empresa
                            <strong>{{ $tenant->nome }}</strong>? Esta ação não pode ser desfeita e todos os dados relacionados serão perdidos.
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
                                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="w-100">
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
    @endcan
</div>
@endsection