@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Administração</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-address-book icon me-2"></i>
                            Clientes
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('clientes.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Novo Cliente
                            </a>
                            <a href="{{ route('clientes.create') }}" class="btn btn-primary d-sm-none btn-icon">
                                <i class="fa-solid fa-plus icon"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div><i class="fa-solid fa-check icon alert-icon"></i></div>
                            <div>{{ session('success') }}</div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="GET" action="{{ route('clientes.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="search_nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="search_nome" name="search_nome"
                                    value="{{ request('search_nome') }}" placeholder="Pesquisar por nome...">
                            </div>
                            <div class="col-md-4">
                                <label for="search_documento" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="search_documento" name="search_documento"
                                    value="{{ request('search_documento') }}" placeholder="Pesquisar por documento...">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="btn-group w-100" role="group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-search me-1"></i> Pesquisar
                                    </button>
                                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-times me-1"></i> Limpar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Clientes</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Documento</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Endereço</th>
                                    <th>Usuário</th>
                                    <th>Data de Criação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->id }}</td>
                                        <td>{{ $cliente->nome }}</td>
                                        <td>{{ $cliente->documento }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>{{ $cliente->telefone }}</td>
                                        <td>{{ $cliente->endereco ? $cliente->endereco->linha1 : '-' }}</td>
                                        <td>{{ $cliente->user ? $cliente->user->name : '-' }}</td>
                                        <td>{{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('clientes.show', $cliente) }}"
                                                class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
                                            <a href="{{ route('clientes.edit', $cliente) }}"
                                                class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen"></i></a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $cliente->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <!-- Modal Exclusão -->
                                            <div class="modal fade" id="modal-excluir-{{ $cliente->id }}" tabindex="-1"
                                                aria-labelledby="modalLabel-{{ $cliente->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel-{{ $cliente->id }}">
                                                                Confirmar Exclusão</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Tem certeza que deseja excluir o cliente
                                                            <strong>{{ $cliente->nome }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST"
                                                                action="{{ route('clientes.destroy', $cliente) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Excluir</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Nenhum cliente encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        {{ $clientes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
