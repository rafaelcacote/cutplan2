@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Administração</div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-users icon me-2"></i>
                            Membros
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('membros.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <i class="fa-solid fa-plus icon"></i>
                                Novo Membro
                            </a>
                            <a href="{{ route('membros.create') }}" class="btn btn-primary d-sm-none btn-icon">
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
                                <form method="GET" action="{{ route('membros.index') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search_nome" class="form-label">Nome</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_nome" name="search_nome"
                                                value="{{ request('search_nome') }}" placeholder="Pesquisar por nome...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="search_email" class="form-label">E-mail</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-envelope"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_email" name="search_email"
                                                value="{{ request('search_email') }}" placeholder="Pesquisar por e-mail...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('membros.index') }}" class="btn btn-outline-secondary">
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
                                <h3 class="card-title">Lista de Membros</h3>
                                <div class="card-actions">
                                    <span class="text-muted">{{ $membros->total() }} membro(s) encontrado(s)</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Telefone</th>
                                            <th>Cargo</th>
                                            <th>Ativo</th>
                                            <th>Cadastro</th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($membros as $membro)
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($membro->nome) }}&background=206bc4&color=fff&size=64)"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{ $membro->nome }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($membro->email)
                                                        <a href="mailto:{{ $membro->email }}" class="text-reset">{{ $membro->email }}</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($membro->telefone)
                                                        <div class="small">
                                                            <i class="fa-solid fa-phone me-1"></i>
                                                            {{ $membro->telefone }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $membro->cargo->nome ?? '-' }}</td>
                                                <td>
                                                    @if($membro->ativo)
                                                        <span class="badge bg-green-lt">Sim</span>
                                                    @else
                                                        <span class="badge bg-red-lt">Não</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="small text-muted">
                                                        {{ $membro->created_at ? $membro->created_at->format('d/m/Y') : '-' }}
                                                    </div>
                                                    <div class="small text-muted">
                                                        {{ $membro->created_at ? $membro->created_at->format('H:i') : '' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('membros.show', $membro) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('membros.edit', $membro) }}" class="btn btn-outline-secondary btn-sm">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $membro->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal Exclusão -->
                                            <div class="modal modal-blur fade" id="modal-excluir-{{ $membro->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="modal-status bg-danger"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                            <h3>Tem certeza?</h3>
                                                            <div class="text-muted">Deseja realmente excluir o membro <strong>{{ $membro->nome }}</strong>? Esta ação não pode ser desfeita.</div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="w-100">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <button type="button" class="btn w-100" data-bs-dismiss="modal">
                                                                            Cancelar
                                                                        </button>
                                                                    </div>
                                                                    <div class="col">
                                                                        <form action="{{ route('membros.destroy', $membro) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger w-100">
                                                                                Sim, excluir
                                                                            </button>
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
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="empty">
                                                        <div class="empty-img">
                                                            <img src="{{ asset('tabler/img/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
                                                        </div>
                                                        <p class="empty-title">Nenhum membro encontrado</p>
                                                        <p class="empty-subtitle text-muted">
                                                            Tente criar um novo membro para começar.
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('membros.create') }}" class="btn btn-primary">
                                                                <i class="fa-solid fa-plus icon"></i>
                                                                Adicionar seu primeiro membro
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($membros instanceof \Illuminate\Pagination\LengthAwarePaginator && $membros->hasPages())
                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-center">
                                        <ul class="pagination">
                                            {{-- Previous Page Link --}}
                                            <li class="page-item{{ $membros->onFirstPage() ? ' disabled' : '' }}">
                                                <a class="page-link" href="{{ $membros->previousPageUrl() ?? '#' }}" tabindex="-1"
                                                    aria-disabled="{{ $membros->onFirstPage() ? 'true' : 'false' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                        <path d="M15 6l-6 6l6 6"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                            {{-- Pagination Elements --}}
                                            @foreach ($membros->links()->elements[0] as $page => $url)
                                                @if ($url)
                                                    <li class="page-item{{ $page == $membros->currentPage() ? ' active' : '' }}">
                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled"><span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                            {{-- Next Page Link --}}
                                            <li class="page-item{{ $membros->hasMorePages() ? '' : ' disabled' }}">
                                                <a class="page-link" href="{{ $membros->nextPageUrl() ?? '#' }}"
                                                    aria-disabled="{{ $membros->hasMorePages() ? 'false' : 'true' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                        <path d="M9 6l6 6l-6 6"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
