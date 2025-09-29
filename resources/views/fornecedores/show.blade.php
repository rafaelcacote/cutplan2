@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('fornecedores.index') }}" class="btn-link">Fornecedores</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-truck fa-lg me-2"></i>
                        Visualizar Fornecedor
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('fornecedores.edit', $fornecedor) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('fornecedores.index') }}" class="btn btn-outline-secondary">
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
                <!-- Card do Perfil -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <span class="avatar avatar-xl" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($fornecedor->nome) }}&background=206bc4&color=fff&size=128)"></span>
                            </div>
                            <h3 class="m-0 mb-1">{{ $fornecedor->nome }}</h3>
                            <div class="text-muted">{{ $fornecedor->email ?: 'Email não informado' }}</div>
                            <div class="mt-3">
                                <span class="badge bg-purple-lt">ID: {{ $fornecedor->id }}</span>
                                @if($fornecedor->documento)
                                    <span class="badge bg-blue-lt">Documento: {{ $fornecedor->documento }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('fornecedores.edit', $fornecedor) }}" class="card-btn">
                                <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                            </a>
                            <button class="card-btn text-red" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash me-2"></i> Excluir
                            </button>
                        </div>
                    </div>
                    <!-- Card de Informações de Cadastro -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Informações do Sistema
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Cadastrado por</label>
                                <div class="form-control-plaintext">
                                    @if($fornecedor->user)
                                        <span class="avatar avatar-xs me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($fornecedor->user->name) }}&background=206bc4&color=fff')"></span>
                                        {{ $fornecedor->user->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Data de Cadastro</label>
                                <div class="form-control-plaintext">
                                    {{ $fornecedor->created_at ? $fornecedor->created_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Última Atualização</label>
                                <div class="form-control-plaintext">
                                    {{ $fornecedor->updated_at ? $fornecedor->updated_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dados Principais -->
                <div class="col-lg-8">
                    <!-- Informações Pessoais -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-user me-2"></i>
                                Dados do Fornecedor
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nome</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->nome }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Documento</label>
                                        <div class="form-control-plaintext">
                                            {{ $fornecedor->documento ?: 'Não informado' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-mail</label>
                                        <div class="form-control-plaintext">
                                            @if($fornecedor->email)
                                                <a href="mailto:{{ $fornecedor->email }}">{{ $fornecedor->email }}</a>
                                            @else
                                                Não informado
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Telefone</label>
                                        <div class="form-control-plaintext">
                                            @if($fornecedor->telefone)
                                                <a href="tel:{{ $fornecedor->telefone }}">{{ $fornecedor->telefone }}</a>
                                            @else
                                                Não informado
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Endereço -->
                    @if($fornecedor->endereco)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-map-marker-alt me-2"></i>
                                Endereço Completo
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">CEP</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->endereco->cep ?: 'Não informado' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Logradouro</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->endereco->endereco ?: 'Não informado' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Número</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->endereco->numero ?: 'S/N' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Bairro</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->endereco->bairro ?: 'Não informado' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Município</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->endereco->municipio->nome ?? 'Não informado' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <div class="form-control-plaintext">
                                            {{ $fornecedor->endereco->municipio->estado->nome ?? 'Não informado' }}
                                            @if($fornecedor->endereco->municipio->estado->uf)
                                                ({{ $fornecedor->endereco->municipio->estado->uf }})
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($fornecedor->endereco->complemento)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Complemento</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->endereco->complemento }}</div>
                                    </div>
                                </div>
                                @endif
                                @if($fornecedor->endereco->referencia)
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Ponto de Referência</label>
                                        <div class="form-control-plaintext">{{ $fornecedor->endereco->referencia }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- Observações -->
                    @if($fornecedor->observacoes)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-sticky-note me-2"></i>
                                Observações Adicionais
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-control-plaintext">{{ $fornecedor->observacoes }}</div>
                        </div>
                    </div>
                    @endif
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
                <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                <h3>Tem certeza?</h3>
                <div class="text-muted">Deseja realmente excluir o fornecedor <strong>{{ $fornecedor->nome }}</strong>? Esta ação não pode ser desfeita.</div>
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
                            <form action="{{ route('fornecedores.destroy', $fornecedor) }}" method="POST" class="d-inline">
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
@endsection
