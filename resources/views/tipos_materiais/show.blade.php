@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('tipos-materiais.index') }}" class="btn-link">Tipos de Materiais</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-cube fa-lg me-2"></i>
                        Visualizar Tipo de Material
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('tipos-materiais.edit', $tipoMaterial) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('tipos-materiais.index') }}" class="btn btn-outline-secondary">
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
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-cube me-2"></i>
                                Dados do Tipo
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <div class="form-control-plaintext">{{ $tipoMaterial->nome }}</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">ID</label>
                                <div class="form-control-plaintext">{{ $tipoMaterial->id }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
