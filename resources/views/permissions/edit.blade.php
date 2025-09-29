@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('permissions.index') }}" class="btn-link">Permissões</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-pen-to-square fa-lg me-2"></i>
                        Editar Permissão: {{ $permission->name }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
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
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="alert-title">Ops! Algo deu errado...</h4>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('permissions.update', $permission) }}" class="card">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Informações da Permissão</h3>
                            <div class="card-actions">
                                <span class="badge bg-purple-lt">ID: {{ $permission->id }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome da Permissão</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $permission->name) }}" placeholder="Ex: usuarios.criar, perfis.editar" required>
                                        <small class="form-hint">Use o formato: modulo.acao (ex: usuarios.criar, perfis.editar)</small>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Guard</label>
                                        <input type="text" class="form-control @error('guard_name') is-invalid @enderror" name="guard_name" value="{{ old('guard_name', $permission->guard_name) }}" placeholder="web">
                                        <small class="form-hint">Geralmente 'web' para aplicações web</small>
                                        @error('guard_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <h4 class="card-title">Informações Atuais</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <strong>Criada em:</strong> {{ $permission->created_at ? $permission->created_at->format('d/m/Y H:i') : '-' }}
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong>Atualizada em:</strong> {{ $permission->updated_at ? $permission->updated_at->format('d/m/Y H:i') : '-' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    @php
                                                        $parts = explode('.', $permission->name);
                                                        $module = $parts[0] ?? '';
                                                        $action = $parts[1] ?? '';
                                                    @endphp
                                                    @if($module && $action)
                                                        <div class="mb-2">
                                                            <strong>Módulo:</strong> <span class="badge bg-blue-lt">{{ ucfirst($module) }}</span>
                                                        </div>
                                                        <div class="mb-2">
                                                            <strong>Ação:</strong> <span class="badge bg-green-lt">{{ ucfirst($action) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('permissions.index') }}" class="btn btn-link">Cancelar</a>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="fa-solid fa-save me-2"></i> Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
