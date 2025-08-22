@extends('layouts.app')
@section('content')

    @include('components.toast')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            <a href="{{ route('materiais.index') }}" class="btn-link">Materiais</a>
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-plus fa-lg me-2"></i>
                            Novo Material
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
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
                    <div class="col-12">
                        <form method="POST" action="{{ route('materiais.store') }}" class="card">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Informações do Material</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="nome" class="form-label required">Nome</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-box"></i></span>
                                                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror" required maxlength="150">
                                            </div>
                                            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="tipo_id" class="form-label required">Tipo</label>
                                            <select name="tipo_id" id="tipo_id" class="form-select @error('tipo_id') is-invalid @enderror" required>
                                                <option value="">Selecione</option>
                                                @foreach($tipos as $tipo)
                                                    <option value="{{ $tipo->id }}" @selected(old('tipo_id')==$tipo->id)>{{ $tipo->nome }}</option>
                                                @endforeach
                                            </select>
                                            @error('tipo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="unidade_id" class="form-label required">Unidade</label>
                                            <select name="unidade_id" id="unidade_id" class="form-select @error('unidade_id') is-invalid @enderror" required>
                                                <option value="">Selecione</option>
                                                @foreach($unidades as $unidade)
                                                    <option value="{{ $unidade->id }}" @selected(old('unidade_id')==$unidade->id)>{{ $unidade->nome }}</option>
                                                @endforeach
                                            </select>
                                            @error('unidade_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="preco_custo" class="form-label">Preço Custo</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                                                <input type="text" name="preco_custo" id="preco_custo" value="{{ old('preco_custo') }}" class="form-control @error('preco_custo') is-invalid @enderror" inputmode="decimal" autocomplete="off">
                                            </div>
                                            @error('preco_custo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="estoque_minimo" class="form-label">Estoque Mínimo</label>
                                            <input type="number" step="0.0001" name="estoque_minimo" id="estoque_minimo" value="{{ old('estoque_minimo') }}" class="form-control @error('estoque_minimo') is-invalid @enderror">
                                            @error('estoque_minimo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="controla_estoque" class="form-label required">Controla Estoque</label>
                                            <select name="controla_estoque" id="controla_estoque" class="form-select @error('controla_estoque') is-invalid @enderror" required>
                                                <option value="1" @selected(old('controla_estoque',1)==1)>Sim</option>
                                                <option value="0" @selected(old('controla_estoque')==0)>Não</option>
                                            </select>
                                            @error('controla_estoque')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="ativo" class="form-label required">Ativo</label>
                                            <select name="ativo" id="ativo" class="form-select @error('ativo') is-invalid @enderror" required>
                                                <option value="1" @selected(old('ativo',1)==1)>Sim</option>
                                                <option value="0" @selected(old('ativo')==0)>Não</option>
                                            </select>
                                            @error('ativo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex">
                                    <a href="{{ route('materiais.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                                    </a>
                                    <button type="submit" class="btn btn-primary ms-auto">
                                        <i class="fa-solid fa-save me-2"></i> Salvar Material
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Máscara para campo de preço custo (formato brasileiro: 1.234,56)
    document.addEventListener('DOMContentLoaded', function() {
        const precoInput = document.getElementById('preco_custo');
        if (precoInput) {
            precoInput.addEventListener('input', function(e) {
                let v = this.value.replace(/\D/g, '');
                v = (v/100).toFixed(2) + '';
                v = v.replace('.', ',');
                v = v.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                this.value = v;
            });
            // Corrige valor ao sair do campo
            precoInput.addEventListener('blur', function() {
                if (this.value && !this.value.includes(',')) {
                    this.value = parseFloat(this.value.replace(/\./g, '').replace(',', '.')).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
            });
        }

        // Converte o valor para formato numérico no submit do formulário
        const form = precoInput.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (precoInput.value) {
                    // Remove pontos e troca vírgula por ponto
                    precoInput.value = precoInput.value.replace(/\./g, '').replace(',', '.');
                }
            });
        }
    });
</script>

@endsection

