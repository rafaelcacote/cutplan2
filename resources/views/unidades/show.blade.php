@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('unidades.index') }}" class="btn-link">Unidades</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-ruler-combined fa-lg me-2"></i>
                        Visualizar Unidade
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('unidades.edit', $unidade) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                        </a>
                        <a href="{{ route('unidades.index') }}" class="btn btn-outline-secondary">
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
                                <i class="fa-solid fa-ruler me-2"></i>
                                Dados da Unidade
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Código</label>
                                <div class="form-control-plaintext">{{ $unidade->codigo }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <div class="form-control-plaintext">{{ $unidade->nome }}</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Precisão</label>
                                <div class="form-control-plaintext">{{ $unidade->precisao }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
