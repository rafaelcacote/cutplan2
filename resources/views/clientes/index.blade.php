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
                @include('components.toast')
                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showToast('Sucesso!', @json(session('success')), 'success');
                        });
                    </script>
                @endif
                <!-- Filtros de Pesquisa -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('clientes.index') }}" class="row g-3">
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
                                        <label for="search_documento" class="form-label">CPF</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="fa-solid fa-id-card"></i>
                                            </span>
                                            <input type="text" class="form-control" id="search_documento" name="search_documento"
                                                value="{{ request('search_documento') }}" placeholder="Pesquisar por CPF..."
                                                data-mask="000.000.000-00">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search me-1"></i>
                                                Pesquisar
                                            </button>
                                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
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
                                <h3 class="card-title">Lista de Clientes</h3>
                                <div class="card-actions">
                                    <span class="text-muted">{{ $clientes->total() }} cliente(s) encontrado(s)</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th class="w-1">
                                                <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices">
                                            </th>
                                            <th>Cliente</th>
                                            <th>CPF</th>
                                            <th>Contato</th>
                                            <th>Endereço</th>
                                            <th>Cadastro</th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($clientes as $cliente)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select cliente">
                                                </td>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($cliente->nome) }}&background=206bc4&color=fff&size=64)"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{ $cliente->nome }}</div>
                                                            <div class="text-muted">
                                                                @if($cliente->email)
                                                                    <a href="mailto:{{ $cliente->email }}" class="text-reset">{{ $cliente->email }}</a>
                                                                @else
                                                                    <span class="text-muted">Email não informado</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($cliente->documento)
                                                        <span class="badge bg-blue-lt">{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cliente->documento) }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($cliente->telefone)
                                                        <div class="small">
                                                            <i class="fa-solid fa-phone me-1"></i>
                                                            {{ $cliente->telefone }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($cliente->endereco)
                                                        <div class="small text-muted">
                                                            {{ $cliente->endereco->endereco ?? '' }}
                                                            @if($cliente->endereco->numero), {{ $cliente->endereco->numero }}@endif
                                                            @if($cliente->endereco->bairro)<br>{{ $cliente->endereco->bairro }}@endif
                                                            @if($cliente->endereco->municipio)
                                                                - {{ $cliente->endereco->municipio->nome ?? '' }}
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="small text-muted">
                                                        {{ $cliente->created_at ? $cliente->created_at->format('d/m/Y') : '-' }}
                                                    </div>
                                                    <div class="small text-muted">
                                                        {{ $cliente->created_at ? $cliente->created_at->format('H:i') : '' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-outline-secondary btn-sm">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $cliente->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal Exclusão -->
                                            <div class="modal modal-blur fade" id="modal-excluir-{{ $cliente->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="modal-status bg-danger"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                            <h3>Tem certeza?</h3>
                                                            <div class="text-muted">Deseja realmente excluir o cliente <strong>{{ $cliente->nome }}</strong>? Esta ação não pode ser desfeita.</div>
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
                                                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-img">
                                                    <img src="{{ asset('tabler/img/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
                                                </div>
                                                <p class="empty-title">Nenhum cliente encontrado</p>
                                                <p class="empty-subtitle text-muted">
                                                    Tente criar um novo cliente para começar.
                                                </p>
                                                <div class="empty-action">
                                                    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                                                        <i class="fa-solid fa-plus icon"></i>
                                                        Adicionar seu primeiro cliente
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
                        {{ $clientes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
