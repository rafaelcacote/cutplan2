@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Cadastros Básicos</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-cubes-stacked icon me-2"></i>
                            Tipos de Materiais
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('tipos-materiais.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Novo Tipo
                            </a>
                            <a href="{{ route('tipos-materiais.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                                <form method="GET" action="{{ route('tipos-materiais.index') }}" class="row g-3">
                                    <div class="col-md-6">
                                        <label for="search_nome" class="form-label">Nome</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-cube"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_nome" name="search_nome"
                                                value="{{ request('search_nome') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('tipos-materiais.index') }}" class="btn btn-outline-secondary">
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
                                <h3 class="card-title">Lista de Tipos de Materiais</h3>
                                <div class="card-actions">
                                    <span class="text-muted">{{ $tipos->total() }} tipo(s) encontrado(s)</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tipos as $tipo)
                                            <tr>
                                                <td>{{ $tipo->nome }}</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('tipos-materiais.show', $tipo) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('tipos-materiais.edit', $tipo) }}" class="btn btn-outline-secondary btn-sm">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $tipo->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal modal-blur fade" id="modal-excluir-{{ $tipo->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="modal-status bg-danger"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                            <h3>Tem certeza?</h3>
                                                            <div class="text-muted">Deseja realmente excluir o tipo <strong>{{ $tipo->nome }}</strong>? Esta ação não pode ser desfeita.</div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="w-100">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <button type="button" class="btn w-100" data-bs-dismiss="modal">Cancelar</button>
                                                                    </div>
                                                                    <div class="col">
                                                                        <form action="{{ route('tipos-materiais.destroy', $tipo) }}" method="POST" class="d-inline">
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
                                                <td colspan="2" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-img">
                                                            <img src="{{ asset('tabler/img/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
                                                        </div>
                                                        <p class="empty-title">Nenhum tipo encontrado</p>
                                                        <p class="empty-subtitle text-muted">Tente criar um novo tipo para começar.</p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('tipos-materiais.create') }}" class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar seu primeiro tipo
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
                                {{ $tipos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
