@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            <a href="{{ route('materiais.index') }}" class="btn-link">Materiais</a>
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-eye fa-lg me-2"></i>
                            Visualizar Material
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('materiais.edit', $material) }}" class="btn btn-primary">
                                <i class="fa-solid fa-pen me-2"></i> Editar
                            </a>
                            <a href="{{ route('materiais.index') }}" class="btn btn-outline-secondary">
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
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-box fa-4x mb-3 text-primary"></i>
                                <h3>{{ $material->nome }}</h3>
                                <div class="text-muted">ID: {{ $material->id }}</div>
                                <div class="mt-3">
                                    @if($material->ativo)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informações do Sistema</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Cadastrado por:</strong></div>
                                    <div class="col-sm-7">{{ $material->user->name ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Data de Cadastro:</strong></div>
                                    <div class="col-sm-7">{{ $material->created_at ? $material->created_at->format('d/m/Y H:i') : '-' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5"><strong>Atualizado em:</strong></div>
                                    <div class="col-sm-7">{{ $material->updated_at ? $material->updated_at->format('d/m/Y H:i') : '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Dados do Material</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tipo</label>
                                            <div class="form-control-plaintext">{{ $material->tipo->nome ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Unidade</label>
                                            <div class="form-control-plaintext">{{ $material->unidade->nome ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Preço Custo</label>
                                            <div class="form-control-plaintext">{{ $material->preco_custo ? 'R$ ' . number_format($material->preco_custo, 2, ',', '.') : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Estoque Mínimo</label>
                                            <div class="form-control-plaintext">{{ $material->estoque_minimo ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Controla Estoque</label>
                                            <div class="form-control-plaintext">
                                                @if($material->controla_estoque)
                                                    <span class="badge bg-green">Sim</span>
                                                @else
                                                    <span class="badge bg-secondary">Não</span>
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
@endsection
