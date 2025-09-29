@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('itens-servico.index') }}" class="btn-link">Itens de Serviço</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-plus icon me-2"></i>
                        Novo Item de Serviço
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <a href="{{ route('itens-servico.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @include('components.toast')
            <form method="POST" action="{{ route('itens-servico.store') }}" class="card">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Informações do Item de Serviço</h3>
                </div>
                <div class="card-body row g-3">
                    <div class="col-lg-8">
                        <label for="descricao_item" class="form-label required">Descrição do Item</label>
                        <textarea name="descricao_item" id="descricao_item" class="form-control @error('descricao_item') is-invalid @enderror" required rows="2">{{ old('descricao_item') }}</textarea>
                        @error('descricao_item')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="servico_id" class="form-label required">Serviço</label>
                        <select name="servico_id" id="servico_id" class="form-select @error('servico_id') is-invalid @enderror" required>
                            <option value="">Selecione o serviço</option>
                            @foreach($servicos as $servico)
                                <option value="{{ $servico->id }}" @if(old('servico_id') == $servico->id) selected @endif>{{ $servico->nome }}</option>
                            @endforeach
                        </select>
                        @error('servico_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('itens-servico.index') }}" class="btn btn-outline-secondary">
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
@endsection
