@extends('layouts.app')

@section('content')
@include('components.toast')
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
                        Nova Unidade
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
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
                <div class="col-12">
                    <form method="POST" action="{{ route('unidades.store') }}" class="card">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Informações da Unidade</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Código</label>
                                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo') }}" placeholder="Ex: UN, KG, M2" maxlength="16">
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" placeholder="Digite o nome da unidade" maxlength="64">
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label required">Precisão</label>
                                        <input type="number" class="form-control @error('precisao') is-invalid @enderror" name="precisao" value="{{ old('precisao', 3) }}" min="0" max="10">
                                        @error('precisao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex">
                                <a href="{{ route('unidades.index') }}" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="fa-solid fa-save me-2"></i> Salvar Unidade
                                </button>
                            </div>
                        </div>
                        @if(session('success'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    showToast('Sucesso!', @json(session('success')), 'success');
                                });
                            </script>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
