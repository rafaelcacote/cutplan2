@extends('layouts.app')

@section('content')
@include('components.toast')
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
                        Nova Equipe
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
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
                <div class="col-12">
                    <form method="POST" action="{{ route('equipes.store') }}" class="card">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Informações da Equipe</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" placeholder="Nome da equipe" maxlength="100">
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Líder</label>
                                        <select class="form-select @error('lider_id') is-invalid @enderror" name="lider_id">
                                            <option value="">Selecione o líder</option>
                                            @foreach($membros as $membro)
                                                <option value="{{ $membro->id }}" @if(old('lider_id') == $membro->id) selected @endif>{{ $membro->nome }}</option>
                                            @endforeach
                                        </select>
                                        @error('lider_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control @error('descricao') is-invalid @enderror" name="descricao" rows="2" maxlength="255">{{ old('descricao') }}</textarea>
                                        @error('descricao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select @error('ativo') is-invalid @enderror" name="ativo">
                                            <option value="1" @if(old('ativo', 1) == 1) selected @endif>Ativo</option>
                                            <option value="0" @if(old('ativo') == 0) selected @endif>Inativo</option>
                                        </select>
                                        @error('ativo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center gap-2">
                            <a href="{{ route('equipes.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <i class="fa-solid fa-save me-2"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
