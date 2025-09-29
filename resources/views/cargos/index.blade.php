@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Administração</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-briefcase icon me-2"></i>
                            Cargos
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('cargos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Novo Cargo
                            </a>
                            <a href="{{ route('cargos.create') }}" class="btn btn-primary d-sm-none btn-icon">
                                <i class="fa-solid fa-plus icon"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                @include('components.toast')
                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showToast('Sucesso!', @json(session('success')), 'success');
                        });
                    </script>
                @endif
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('cargos.index') }}" class="row g-3">
                                    <div class="col-md-6">
                                        <label for="search_nome" class="form-label">Nome</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-briefcase"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_nome" name="search_nome" value="{{ request('search_nome') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('cargos.index') }}" class="btn btn-outline-secondary">
                                                <i class="fa-solid fa-times me-1"></i>
                                                Limpar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Cargos</h3>
                        <span class="badge bg-blue-lt ms-2">{{ $cargos->total() }} registros</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Ativo</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cargos as $cargo)
                                    <tr>
                                        <td>{{ $cargo->nome }}</td>
                                        <td>{{ $cargo->descricao }}</td>
                                        <td>
                                            @if($cargo->ativo)
                                                <span class="badge bg-green">Sim</span>
                                            @else
                                                <span class="badge bg-red">Não</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <a href="{{ route('cargos.show', $cargo) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
                                                <a href="{{ route('cargos.edit', $cargo) }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $cargo->id }}"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                            <div class="modal modal-blur fade" id="modal-excluir-{{ $cargo->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Excluir Cargo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Tem certeza que deseja excluir o cargo <strong>{{ $cargo->nome }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST" action="{{ route('cargos.destroy', $cargo) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <img src="/tabler/illustrations/undraw_empty_xct9.svg" alt="Sem registros" height="120" class="mb-2">
                                            <div class="mb-2">Nenhum cargo encontrado.</div>
                                            <a href="{{ route('cargos.create') }}" class="btn btn-primary">
                                                <i class="fa-solid fa-plus"></i> Cadastrar primeiro cargo
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        {{ $cargos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
