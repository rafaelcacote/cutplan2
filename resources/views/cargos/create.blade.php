@extends('layouts.app')

@section('content')
@include('components.toast')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('cargos.index') }}" class="btn-link">Cargos</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-briefcase fa-lg me-2"></i>
                        Novo Cargo
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('cargos.index') }}" class="btn btn-outline-secondary">
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
                <div class="col-12">
                    <form method="POST" action="{{ route('cargos.store') }}" class="card">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Informações do Cargo</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" placeholder="Digite o nome do cargo" maxlength="100">
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Ativo</label>
                                        <select class="form-select @error('ativo') is-invalid @enderror" name="ativo">
                                            <option value="1" {{ old('ativo', 1) == 1 ? 'selected' : '' }}>Sim</option>
                                            <option value="0" {{ old('ativo', 1) == 0 ? 'selected' : '' }}>Não</option>
                                        </select>
                                        @error('ativo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control @error('descricao') is-invalid @enderror" name="descricao" rows="3" maxlength="255" placeholder="Descrição do cargo">{{ old('descricao') }}</textarea>
                                        @error('descricao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <a href="{{ route('cargos.index') }}" class="btn btn-outline-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary ms-auto">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
