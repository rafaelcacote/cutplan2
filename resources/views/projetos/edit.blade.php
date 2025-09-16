@extends('layouts.app')

@section('title', 'Editar Projeto: ' . $projeto->nome)

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('projetos.index') }}" class="text-muted">Projetos</a> /
                        <a href="{{ route('projetos.show', $projeto) }}" class="text-muted">{{ $projeto->nome }}</a>
                    </div>
                    <h2 class="page-title">
                        Editar Projeto
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('projetos.update', $projeto) }}" method="POST">
                @csrf
                @method('PUT')

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
                                                        {{ old('cliente_id', $projeto->cliente_id) == $cliente->id ? 'selected' : '' }}>
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
                                                value="{{ old('nome', $projeto->nome) }}" required maxlength="150">
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
                                                        {{ old('orcamento_id', $projeto->orcamento_id) == $orcamento->id ? 'selected' : '' }}>
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
                                                        {{ old('status', $projeto->status) == $value ? 'selected' : '' }}>
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
                                                value="{{ old('data_inicio', $projeto->data_inicio?->format('Y-m-d')) }}">
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
                                                value="{{ old('data_entrega_prevista', $projeto->data_entrega_prevista?->format('Y-m-d')) }}">
                                            @error('data_entrega_prevista')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Entrega Real</label>
                                            <input type="date" name="data_entrega_real"
                                                class="form-control @error('data_entrega_real') is-invalid @enderror"
                                                value="{{ old('data_entrega_real', $projeto->data_entrega_real?->format('Y-m-d')) }}">
                                            @error('data_entrega_real')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Gerente Responsável</label>
                                            <select name="gerente_user_id"
                                                class="form-select @error('gerente_user_id') is-invalid @enderror">
                                                <option value="">Selecione um gerente</option>
                                                @foreach ($gerentes as $gerente)
                                                    <option value="{{ $gerente->id }}"
                                                        {{ old('gerente_user_id', $projeto->gerente_user_id) == $gerente->id ? 'selected' : '' }}>
                                                        {{ $gerente->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('gerente_user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Equipe</label>
                                            <select name="equipe_id"
                                                class="form-select @error('equipe_id') is-invalid @enderror">
                                                <option value="">Selecione uma equipe</option>
                                                @foreach ($equipes as $equipe)
                                                    <option value="{{ $equipe->id }}"
                                                        {{ old('equipe_id', $projeto->equipe_id) == $equipe->id ? 'selected' : '' }}>
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
                                    <textarea name="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="4">{{ old('observacoes', $projeto->observacoes) }}</textarea>
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
                                        Salvar Alterações
                                    </button>
                                    <a href="{{ route('projetos.show', $projeto) }}" class="btn btn-secondary">
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

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Informações</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>Código:</strong><br>
                                    {{ $projeto->codigo }}
                                </div>
                                <div class="mb-2">
                                    <strong>Status Atual:</strong><br>
                                    <span class="{{ $projeto->status_badge_class }}">
                                        {{ $projeto->status_label }}
                                    </span>
                                </div>
                                @if ($projeto->orcamento)
                                    <div class="mb-2">
                                        <strong>Orçamento:</strong><br>
                                        <a href="#" class="text-decoration-none">
                                            #{{ $projeto->orcamento->id }} - R$
                                            {{ number_format($projeto->orcamento->total, 2, ',', '.') }}
                                        </a>
                                    </div>
                                @endif
                                <div class="text-muted small">
                                    Criado em {{ $projeto->created_at->format('d/m/Y H:i') }}<br>
                                    Última atualização: {{ $projeto->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>

                        @if ($projeto->materiaisProjeto->count() > 0 || $projeto->contratos->count() > 0)
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">Resumo</h3>
                                </div>
                                <div class="card-body">
                                    @if ($projeto->materiaisProjeto->count() > 0)
                                        <div class="mb-2">
                                            <strong>Materiais:</strong><br>
                                            {{ $projeto->materiaisProjeto->count() }} itens na BOM
                                        </div>
                                    @endif
                                    @if ($projeto->contratos->count() > 0)
                                        <div class="mb-2">
                                            <strong>Contratos:</strong><br>
                                            {{ $projeto->contratos->count() }} contratos
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
