@extends('layouts.app')

@section('content')
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
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div><i class="fa-solid fa-exclamation-triangle icon alert-icon"></i></div>
                                    <div>
                                        <h4 class="alert-title">Ops! Algo deu errado...</h4>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('clientes.update', $cliente) }}" class="card">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h3 class="card-title">Informações do Cliente</h3>
                            </div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        value="{{ old('nome', $cliente->nome) }}" required maxlength="150">
                                </div>
                                <label for="documento" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento"
                                    value="{{ old('documento', $cliente->documento) }}" maxlength="32">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $cliente->email) }}" maxlength="150">
                            </div>
                            <div class="col-md-6">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone"
                                    value="{{ old('telefone', $cliente->telefone) }}" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <label for="endereco_id" class="form-label">Endereço</label>
                                <!-- campo de endereço removido, agora é formulário embutido -->
                                <input type="text" class="form-control" id="endereco_linha1" name="endereco[linha1]"
                                    value="{{ old('endereco.linha1', $endereco->linha1 ?? '') }}" required maxlength="150">
                                <input type="text" class="form-control" id="endereco_linha2" name="endereco[linha2]"
                                    value="{{ old('endereco.linha2', $endereco->linha2 ?? '') }}" maxlength="150">
                                <input type="text" class="form-control" id="endereco_cidade" name="endereco[cidade]"
                                    value="{{ old('endereco.cidade', $endereco->cidade ?? '') }}" required maxlength="100">
                                <input type="text" class="form-control" id="endereco_estado" name="endereco[estado]"
                                    value="{{ old('endereco.estado', $endereco->estado ?? '') }}" required maxlength="100">
                                <input type="text" class="form-control" id="endereco_cep" name="endereco[cep]"
                                    value="{{ old('endereco.cep', $endereco->cep ?? '') }}" maxlength="20">
                                <input type="text" class="form-control" id="endereco_pais" name="endereco[pais]"
                                    value="{{ old('endereco.pais', $endereco->pais ?? 'Brasil') }}" required
                                    maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">Usuário Responsável</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="">Selecione...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $cliente->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- campo de usuário removido, agora é automático pelo usuário logado -->
                            </div>
                            <div class="col-12">
                                <label for="observacoes" class="form-label">Observações</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="3">{{ old('observacoes', $cliente->observacoes) }}</textarea>
                            </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
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


<div class="col-md-6">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email"
        value="{{ old('email', $cliente->email) }}" maxlength="150">
</div>
<div class="col-md-6">
    <label for="telefone" class="form-label">Telefone</label>
    <input type="text" class="form-control" id="telefone" name="telefone"
        value="{{ old('telefone', $cliente->telefone) }}" maxlength="50">
</div>
<div class="col-12">
    <h5 class="mt-3">Endereço</h5>
</div>
<div class="col-md-6">
    <label for="endereco_linha1" class="form-label">Endereço (linha 1)</label>
    <input type="text" class="form-control" id="endereco_linha1" name="endereco[linha1]"
        value="{{ old('endereco.linha1', $endereco->linha1 ?? '') }}" required maxlength="150">
</div>
<div class="col-md-6">
    <label for="endereco_linha2" class="form-label">Endereço (linha 2)</label>
    <input type="text" class="form-control" id="endereco_linha2" name="endereco[linha2]"
        value="{{ old('endereco.linha2', $endereco->linha2 ?? '') }}" maxlength="150">
</div>
<div class="col-md-4">
    <label for="endereco_cidade" class="form-label">Cidade</label>
    <input type="text" class="form-control" id="endereco_cidade" name="endereco[cidade]"
        value="{{ old('endereco.cidade', $endereco->cidade ?? '') }}" required maxlength="100">
</div>
<div class="col-md-4">
    <label for="endereco_estado" class="form-label">Estado</label>
    <input type="text" class="form-control" id="endereco_estado" name="endereco[estado]"
        value="{{ old('endereco.estado', $endereco->estado ?? '') }}" required maxlength="100">
</div>
<div class="col-md-4">
    <label for="endereco_cep" class="form-label">CEP</label>
    <input type="text" class="form-control" id="endereco_cep" name="endereco[cep]"
        value="{{ old('endereco.cep', $endereco->cep ?? '') }}" maxlength="20">
</div>
<div class="col-md-6">
    <label for="endereco_pais" class="form-label">País</label>
    <input type="text" class="form-control" id="endereco_pais" name="endereco[pais]"
        value="{{ old('endereco.pais', $endereco->pais ?? 'Brasil') }}" required maxlength="100">
</div>
<div class="col-12">
    <label for="observacoes" class="form-label">Observações</label>
    <textarea class="form-control" id="observacoes" name="observacoes" rows="3">{{ old('observacoes', $cliente->observacoes) }}</textarea>
</div>
</div>
<div class="card-footer text-end">
    <button type="submit" class="btn btn-primary">
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
