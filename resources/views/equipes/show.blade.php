@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('equipes.index') }}" class="btn-link">Equipes</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-people-group fa-lg me-2"></i>
                        Visualizar Equipe
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('equipes.edit', $equipe) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('equipes.index') }}" class="btn btn-outline-secondary">
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
                                <span class="avatar avatar-xl" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($equipe->nome) }}&background=206bc4&color=fff&size=128)"></span>
                            </div>
                            <h3 class="m-0 mb-1">{{ $equipe->nome }}</h3>
                            <div class="text-muted">Líder: {{ $equipe->lider ? $equipe->lider->nome : '-' }}</div>
                            <div class="mt-3">
                                <span class="badge bg-purple-lt">ID: {{ $equipe->id }}</span>
                                <span class="badge bg-{{ $equipe->ativo ? 'green' : 'red' }}-lt">{{ $equipe->ativo ? 'Ativo' : 'Inativo' }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('equipes.edit', $equipe) }}" class="card-btn">
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
                                <label class="form-label">Data de Cadastro</label>
                                <div class="form-control-plaintext">{{ $equipe->created_at ? $equipe->created_at->format('d/m/Y H:i') : '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Última Atualização</label>
                                <div class="form-control-plaintext">{{ $equipe->updated_at ? $equipe->updated_at->format('d/m/Y H:i') : '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card de Dados da Equipe -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dados da Equipe</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nome</label>
                                    <div class="form-control-plaintext">{{ $equipe->nome }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Líder</label>
                                    <div class="form-control-plaintext">{{ $equipe->lider ? $equipe->lider->nome : '-' }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Descrição</label>
                                    <div class="form-control-plaintext">{{ $equipe->descricao ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('equipes.membros', $equipe) }}" class="btn btn-outline-info">
                                <i class="fa-solid fa-users me-2"></i> Gerenciar Membros
                            </a>
                        </div>
                    </div>
                    <!-- Card de Membros -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Membros da Equipe</h3>
                        </div>
                        <div class="card-body">
                            @if($equipe->membros->count())
                                <ul class="list-group">
                                    @foreach($equipe->membros as $membro)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $membro->nome }}
                                            <span class="badge bg-blue-lt">{{ $membro->pivot->funcao ?: 'Membro' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center text-muted">Nenhum membro cadastrado nesta equipe.</div>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir a equipe <strong>{{ $equipe->nome }}</strong>?
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('equipes.destroy', $equipe) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
