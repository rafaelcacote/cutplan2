@extends('layouts.app')

@section('content')
@include('components.toast')
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
                        Editar Tipo de Material
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('tipos-materiais.show', $tipoMaterial) }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-eye me-2"></i> Visualizar
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
                <div class="col-12">
                    <form method="POST" action="{{ route('tipos-materiais.update', $tipoMaterial) }}" class="card">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Informações do Tipo</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $tipoMaterial->nome) }}" placeholder="Digite o nome do tipo" maxlength="100">
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex">
                                <a href="{{ route('tipos-materiais.index') }}" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="fa-solid fa-save me-2"></i> Salvar Alterações
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
