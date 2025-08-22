@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('equipes.index') }}" class="btn-link">Equipes</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-users fa-lg me-2"></i>
                        Gerenciar Membros da Equipe
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('equipes.show', $equipe) }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-eye me-2"></i> Visualizar
                        </a>
                        <a href="{{ route('equipes.index') }}" class="btn btn-outline-secondary">
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
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Adicionar Membro</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="#">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Membro</label>
                                    <select class="form-select" name="membro_id">
                                        <option value="">Selecione o membro</option>
                                        @foreach($membros as $membro)
                                            <option value="{{ $membro->id }}">{{ $membro->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Função</label>
                                    <input type="text" class="form-control" name="funcao" placeholder="Função do membro (opcional)">
                                </div>
                                <button type="submit" class="btn btn-primary">Adicionar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Membros da Equipe</h3>
                        </div>
                        <div class="card-body">
                            @if($equipe->membros->count())
                                <ul class="list-group">
                                    @foreach($equipe->membros as $membro)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                {{ $membro->nome }}
                                                <span class="badge bg-blue-lt ms-2">{{ $membro->pivot->funcao ?: 'Membro' }}</span>
                                            </div>
                                            <form method="POST" action="#" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="membro_id" value="{{ $membro->id }}">
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Remover">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center text-muted">Nenhum membro cadastrado nesta equipe.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
