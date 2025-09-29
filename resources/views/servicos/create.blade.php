@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administração</div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-plus icon me-2"></i>
                        Novo Serviço
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <a href="{{ route('servicos.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @include('components.toast')
            <div class="card">
                <form method="POST" action="{{ route('servicos.store') }}" class="card">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Informações do Serviço</h3>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-lg-6">
                            <label for="nome" class="form-label required">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-briefcase"></i></span>
                                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror" required maxlength="100">
                            </div>
                            @error('nome')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <label for="ativo" class="form-label">Ativo</label>
                            <select name="ativo" id="ativo" class="form-select">
                                <option value="1" @if(old('ativo', '1')=='1') selected @endif>Sim</option>
                                <option value="0" @if(old('ativo')=='0') selected @endif>Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('servicos.index') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa-solid fa-check me-2"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
