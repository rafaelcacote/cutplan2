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
                            <i class="fa-solid fa-address-card fa-lg me-2"></i>
                            Detalhes do Cliente
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-pen me-2"></i> Editar
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
                    <div class="col-12 col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informações do Cliente</h3>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Nome</dt>
                                    <dd class="col-sm-8">{{ $cliente->nome }}</dd>
                                    <dt class="col-sm-4">Documento</dt>
                                    <dd class="col-sm-8">{{ $cliente->documento }}</dd>
                                    <dt class="col-sm-4">Email</dt>
                                    <dd class="col-sm-8">{{ $cliente->email }}</dd>
                                    <dt class="col-sm-4">Telefone</dt>
                                    <dd class="col-sm-8">{{ $cliente->telefone }}</dd>
                                    <dt class="col-sm-4">Endereço</dt>
                                    <dd class="col-sm-8">{{ $cliente->endereco ? $cliente->endereco->linha1 : '-' }}</dd>
                                    <dt class="col-sm-4">Usuário Responsável</dt>
                                    <dd class="col-sm-8">{{ $cliente->user ? $cliente->user->name : '-' }}</dd>
                                    <dt class="col-sm-4">Observações</dt>
                                    <dd class="col-sm-8">{{ $cliente->observacoes }}</dd>
                                    <dt class="col-sm-4">Criado em</dt>
                                    <dd class="col-sm-8">
                                        {{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : '-' }}</dd>
                                </dl>
                            </div>
                            <div class="card-footer text-end">
                                <form method="POST" action="{{ route('clientes.destroy', $cliente) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modal-excluir-{{ $cliente->id }}">
                                        <i class="fa-solid fa-trash"></i> Excluir
                                    </button>
                                    <!-- Modal Exclusão -->
                                    <div class="modal fade" id="modal-excluir-{{ $cliente->id }}" tabindex="-1"
                                        aria-labelledby="modalLabel-{{ $cliente->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel-{{ $cliente->id }}">Confirmar
                                                        Exclusão</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja excluir o cliente
                                                    <strong>{{ $cliente->nome }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
