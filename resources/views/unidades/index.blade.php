@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Cadastros Básicos</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-ruler-combined icon me-2"></i>
                            Unidades
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('unidades.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Nova Unidade
                            </a>
                            <a href="{{ route('unidades.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                                <form method="GET" action="{{ route('unidades.index') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search_nome" class="form-label">Nome</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-ruler"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_nome" name="search_nome"
                                                value="{{ request('search_nome') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="search_codigo" class="form-label">Código</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-barcode"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_codigo" name="search_codigo"
                                                value="{{ request('search_codigo') }}" placeholder="Pesquisar por código...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('unidades.index') }}" class="btn btn-outline-secondary">
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Unidades</h3>
                                <div class="card-actions">
                                    <span class="text-muted">{{ $unidades->total() }} unidade(s) encontrada(s)</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nome</th>
                                            <th>Precisão</th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($unidades as $unidade)
                                            <tr>
                                                <td>{{ $unidade->codigo }}</td>
                                                <td>{{ $unidade->nome }}</td>
                                                <td>{{ $unidade->precisao }}</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('unidades.show', $unidade) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('unidades.edit', $unidade) }}" class="btn btn-outline-secondary btn-sm">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $unidade->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal modal-blur fade" id="modal-excluir-{{ $unidade->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="modal-status bg-danger"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                            <h3>Tem certeza?</h3>
                                                            <div class="text-muted">Deseja realmente excluir a unidade <strong>{{ $unidade->nome }}</strong>? Esta ação não pode ser desfeita.</div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="w-100">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <button type="button" class="btn w-100" data-bs-dismiss="modal">Cancelar</button>
                                                                    </div>
                                                                    <div class="col">
                                                                        <form action="{{ route('unidades.destroy', $unidade) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger w-100">Sim, excluir</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-img">
                                                            <img src="{{ asset('tabler/img/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
                                                        </div>
                                                        <p class="empty-title">Nenhuma unidade encontrada</p>
                                                        <p class="empty-subtitle text-muted">Tente criar uma nova unidade para começar.</p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('unidades.create') }}" class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar sua primeira unidade
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                {{ $unidades->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
