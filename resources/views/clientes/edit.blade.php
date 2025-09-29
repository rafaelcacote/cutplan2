@extends('layouts.app')


@section('content')
    @include('components.toast')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            <a href="{{ route('clientes.index') }}" class="btn-link">Clientes</a>
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-user-pen fa-lg me-2"></i>
                            Editar Cliente
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-eye me-2"></i> Visualizar
                            </a>
                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
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
                        <form method="POST" action="{{ route('clientes.update', $cliente) }}" class="card">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h3 class="card-title">Informações do Cliente</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label class="form-label required">Nome Completo</label>
                                            <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $cliente->nome) }}" placeholder="Digite o nome completo" maxlength="150">
                                            @error('nome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label required">CPF</label>
                                            <input type="text" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ old('documento', $cliente->documento) }}" placeholder="00000000000" id="cpf" maxlength="14">
                                            <small class="form-hint">Digite apenas números</small>
                                            @error('documento')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </span>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $cliente->email) }}" placeholder="cliente@email.com" maxlength="100">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Telefone</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-phone"></i>
                                                </span>
                                                <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $cliente->telefone) }}" placeholder="(99) 99999-9999" id="telefone" maxlength="15">
                                                @error('telefone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-endereco-form 
                                    :estados="$estados" 
                                    :municipios="$municipios" 
                                    :endereco="$endereco ?? null"
                                    title="Endereço"
                                    prefix="endereco"
                                    :required="true"
                                />
                                <!-- Linha 3: Observação -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Observações</label>
                                            <textarea class="form-control @error('observacoes') is-invalid @enderror" name="observacoes" rows="3" placeholder="Observações adicionais sobre o cliente..." id="observacoes">{{ old('observacoes', $cliente->observacoes) }}</textarea>
                                            @error('observacoes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer">
                                <div class="d-flex">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                                    </a>
                                    <button type="submit" class="btn btn-primary ms-auto">
                                        <i class="fa-solid fa-save me-2"></i> Salvar Cliente
                                    </button>
                                </div>
                            </div>
                            @if(session('success'))
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        if (window.enderecoHandler) {
                                            window.enderecoHandler.showToast('Sucesso!', @json(session('success')), 'success');
                                        }
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
