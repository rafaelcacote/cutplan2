
@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('servicos.index') }}" class="btn-link">Serviços</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-briefcase fa-lg me-2"></i>
                        Visualizar Serviço
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('servicos.edit', $servico) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('servicos.index') }}" class="btn btn-outline-secondary">
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
                                <span class="avatar avatar-xl bg-primary-lt"><i class="fa-solid fa-briefcase fa-2x text-primary"></i></span>
                            </div>
                            <h3 class="m-0 mb-1">{{ $servico->nome }}</h3>
                            <div class="text-muted">ID: {{ $servico->id }}</div>
                            <div class="mt-3">
                                <span class="badge bg-{{ $servico->ativo ? 'green' : 'red' }}-lt">{{ $servico->ativo ? 'Ativo' : 'Inativo' }}</span>
                            </div>
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
                            <div><strong>Criado em:</strong> {{ $servico->created_at->format('d/m/Y H:i') }}</div>
                            <div><strong>Atualizado em:</strong> {{ $servico->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">Dados do Serviço</div>
                        <div class="card-body row">
                            <div class="col-lg-8 mb-3">
                                <label class="form-label">Nome</label>
                                <div class="form-control-plaintext">{{ $servico->nome }}</div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Ativo</label>
                                <div class="form-control-plaintext">{{ $servico->ativo ? 'Sim' : 'Não' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
