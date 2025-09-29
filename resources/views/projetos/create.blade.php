@extends('layouts.app')

@section('title', 'Novo Projeto')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('projetos.index') }}" class="text-muted">Projetos</a>
                    </div>
                    <h2 class="page-title">
                        Novo Projeto
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('projetos.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informações do Projeto</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Cliente</label>
                                            <select name="cliente_id"
                                                class="form-select @error('cliente_id') is-invalid @enderror" required>
                                                <option value="">Selecione um cliente</option>
                                                @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}"
                                                        {{ old('cliente_id') == $cliente->id || ($orcamentoSelecionado && $orcamentoSelecionado->cliente_id == $cliente->id) ? 'selected' : '' }}>
                                                        {{ $cliente->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('cliente_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Nome do Projeto</label>
                                            <input type="text" name="nome"
                                                class="form-control @error('nome') is-invalid @enderror"
                                                value="{{ old('nome') }}" required maxlength="150">
                                            @error('nome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Orçamento Vinculado</label>
                                            <select name="orcamento_id"
                                                class="form-select @error('orcamento_id') is-invalid @enderror">
                                                <option value="">Nenhum orçamento</option>
                                                @foreach ($orcamentos as $orcamento)
                                                    <option value="{{ $orcamento->id }}"
                                                        {{ old('orcamento_id') == $orcamento->id || ($orcamentoSelecionado && $orcamentoSelecionado->id == $orcamento->id) ? 'selected' : '' }}>
                                                        #{{ $orcamento->id }} - {{ $orcamento->cliente->nome }} - R$
                                                        {{ number_format($orcamento->total, 2, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('orcamento_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status"
                                                class="form-select @error('status') is-invalid @enderror">
                                                @foreach ($statusOptions as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ old('status', 'em_planejamento') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Data de Início</label>
                                            <input type="date" name="data_inicio"
                                                class="form-control @error('data_inicio') is-invalid @enderror"
                                                value="{{ old('data_inicio', date('Y-m-d')) }}">
                                            @error('data_inicio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Entrega Prevista</label>
                                            <input type="date" name="data_entrega_prevista"
                                                class="form-control @error('data_entrega_prevista') is-invalid @enderror"
                                                value="{{ old('data_entrega_prevista') }}">
                                            @error('data_entrega_prevista')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Gerente Responsável</label>
                                            <select name="gerente_user_id"
                                                class="form-select @error('gerente_user_id') is-invalid @enderror">
                                                <option value="">Selecione um gerente</option>
                                                @foreach ($gerentes as $gerente)
                                                    <option value="{{ $gerente->id }}"
                                                        {{ old('gerente_user_id') == $gerente->id ? 'selected' : '' }}>
                                                        {{ $gerente->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('gerente_user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Equipe</label>
                                            <select name="equipe_id"
                                                class="form-select @error('equipe_id') is-invalid @enderror">
                                                <option value="">Selecione uma equipe</option>
                                                @foreach ($equipes as $equipe)
                                                    <option value="{{ $equipe->id }}"
                                                        {{ old('equipe_id') == $equipe->id ? 'selected' : '' }}>
                                                        {{ $equipe->nome }} ({{ $equipe->membros_count }} {{ $equipe->membros_count == 1 ? 'membro' : 'membros' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('equipe_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Observações</label>
                                    <textarea name="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="4">{{ old('observacoes') }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Ações</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                        Salvar Projeto
                                    </button>
                                    <a href="{{ route('projetos.index') }}" class="btn btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l14 0" />
                                            <path d="m5 12l6 6" />
                                            <path d="m5 12l6 -6" />
                                        </svg>
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if ($orcamentoSelecionado)
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">Orçamento Selecionado</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Cliente:</strong><br>
                                        {{ $orcamentoSelecionado->cliente->nome }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Valor:</strong><br>
                                        R$ {{ number_format($orcamentoSelecionado->total, 2, ',', '.') }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Status:</strong><br>
                                        <span class="badge bg-success">{{ $orcamentoSelecionado->status_label }}</span>
                                    </div>
                                    <div class="text-muted small">
                                        Criado em {{ $orcamentoSelecionado->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>

                            @if ($itensPrevia->count() > 0)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M13 5h8"/>
                                                <path d="M13 9h5"/>
                                                <path d="M13 15h8"/>
                                                <path d="M13 19h5"/>
                                                <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                                                <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                                            </svg>
                                            Itens que serão criados no projeto
                                        </h3>
                                        <div class="card-subtitle">{{ $itensPrevia->count() }} {{ $itensPrevia->count() == 1 ? 'item será criado' : 'itens serão criados' }}</div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-vcenter card-table">
                                                <thead>
                                                    <tr>
                                                        <th>Descrição</th>
                                                        <th>Quantidade</th>
                                                        <th>Unidade</th>
                                                        <th>Preço Orçado</th>
                                                        <th>Status Inicial</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($itensPrevia as $index => $item)
                                                        <tr>
                                                            <td>
                                                                <div class="font-weight-medium">{{ $item->descricao }}</div>
                                                                @if ($item->observacao)
                                                                    <div class="text-muted small">{{ $item->observacao }}</div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-azure-lt">{{ number_format($item->quantidade, 3) }}</span>
                                                            </td>
                                                            <td>
                                                                {{ $item->unidade ?? '-' }}
                                                            </td>
                                                            <td>
                                                                <span class="text-green font-weight-medium">
                                                                    R$ {{ number_format($item->preco_orcado, 2, ',', '.') }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-secondary">{{ $item->status_label }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
                                                <path d="M12 9h.01"/>
                                                <path d="M11 12h1v4h1"/>
                                            </svg>
                                            Estes itens serão automaticamente criados quando o projeto for salvo.
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
