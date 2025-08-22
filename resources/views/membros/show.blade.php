@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('membros.index') }}" class="btn-link">Membros</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-user fa-lg me-2"></i>
                        Visualizar Membro
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('membros.edit', $membro) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('membros.index') }}" class="btn btn-outline-secondary">
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
                                <span class="avatar avatar-xl" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($membro->nome) }}&background=206bc4&color=fff&size=128)"></span>
                            </div>
                            <h3 class="m-0 mb-1">{{ $membro->nome }}</h3>
                            <div class="text-muted">{{ $membro->email ?: 'Email não informado' }}</div>
                            <div class="mt-3">
                                <span class="badge bg-purple-lt">ID: {{ $membro->id }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('membros.edit', $membro) }}" class="card-btn">
                                <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                            </a>
                            <button class="card-btn text-red" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash me-2"></i> Excluir
                            </button>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                Informações do Sistema
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Data de Cadastro</label>
                                <div class="form-control-plaintext">
                                    {{ $membro->created_at ? $membro->created_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Última Atualização</label>
                                <div class="form-control-plaintext">
                                    {{ $membro->updated_at ? $membro->updated_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-user me-2"></i>
                                Dados do Membro
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nome</label>
                                        <div class="form-control-plaintext">{{ $membro->nome }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-mail</label>
                                        <div class="form-control-plaintext">
                                            @if($membro->email)
                                                <a href="mailto:{{ $membro->email }}">{{ $membro->email }}</a>
                                            @else
                                                Não informado
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Telefone</label>
                                        <div class="form-control-plaintext">
                                            @if($membro->telefone)
                                                <a href="tel:{{ $membro->telefone }}">{{ $membro->telefone }}</a>
                                            @else
                                                Não informado
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Cargo</label>
                                        <div class="form-control-plaintext">{{ $membro->cargo->nome ?: 'Não informado' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Ativo</label>
                                        <div class="form-control-plaintext">
                                            @if($membro->ativo)
                                                <span class="badge bg-green-lt">Sim</span>
                                            @else
                                                <span class="badge bg-red-lt">Não</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                <h3>Tem certeza?</h3>
                <div class="text-muted">Deseja realmente excluir o membro <strong>{{ $membro->nome }}</strong>? Esta ação não pode ser desfeita.</div>
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
                            <form action="{{ route('membros.destroy', $membro) }}" method="POST" class="d-inline">
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
