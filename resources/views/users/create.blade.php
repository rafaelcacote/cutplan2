@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('users.index') }}" class="btn-link">Usuários</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-user-plus fa-lg me-2"></i>
                        Novo Usuário
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
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

                    <form method="POST" action="{{ route('users.store') }}" class="card">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Informações do Usuário</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome Completo</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Digite o nome completo" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">CPF</label>
                                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" id="cpf">
                                        <small class="form-hint">Digite apenas números ou use a máscara</small>
                                        @error('cpf')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label required">E-mail</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa-solid fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Senha</label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Digite uma senha segura" required autocomplete="new-password">
                                            <span class="input-group-text">
                                                <a href="#" class="link-secondary" title="Mostrar senha" data-bs-toggle="tooltip">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-hint">Mínimo de 6 caracteres</small>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Confirmar Senha</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirme a senha" required autocomplete="new-password">
                                        <small class="form-hint">Digite a senha novamente</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Empresa</label>
                                        <select class="form-select @error('tenant_id') is-invalid @enderror" name="tenant_id">
                                            <option value="">Selecione uma empresa</option>
                                            @forelse($tenants ?? [] as $tenant)
                                                <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                                    {{ $tenant->nome }}
                                                    @if($tenant->cnpj)
                                                        - {{ $tenant->formatted_cnpj }}
                                                    @endif
                                                </option>
                                            @empty
                                                <option value="" disabled>Nenhuma empresa cadastrada</option>
                                            @endforelse
                                        </select>
                                        <small class="form-hint">Selecione a empresa à qual este usuário pertence</small>
                                        @error('tenant_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Perfis de Acesso</label>
                                        <div class="row">
                                            @forelse($roles ?? [] as $role)
                                                <div class="col-lg-6 col-xl-4 mb-3">
                                                    <label class="form-check form-check-single-select">
                                                        <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}" {{ old('role') == $role->name ? 'checked' : '' }}>
                                                        <span class="form-check-label">
                                                            <span class="form-check-description">
                                                                <span class="h4 d-block">
                                                                    <i class="fa-solid fa-user-shield me-2 text-primary"></i>
                                                                    {{ $role->name }}
                                                                </span>
                                                                <span class="text-secondary">
                                                                    {{ $role->permissions->count() }} {{ $role->permissions->count() == 1 ? 'permissão' : 'permissões' }}
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="empty">
                                                        <div class="empty-icon">
                                                            <i class="fa-solid fa-user-shield"></i>
                                                        </div>
                                                        <p class="empty-title">Nenhum perfil encontrado</p>
                                                        <p class="empty-subtitle text-secondary">
                                                            Crie perfis antes de atribuí-los aos usuários.
                                                        </p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                                                <i class="fa-solid fa-plus me-2"></i>
                                                                Criar Perfil
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                        <small class="form-hint">Selecione um perfil para definir as permissões do usuário</small>
                                        @error('role')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('users.index') }}" class="btn btn-link">Cancelar</a>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="fa-solid fa-plus me-2"></i> Criar Usuário
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    }
    
    // Toggle de senha
    const passwordToggle = document.querySelector('[title="Mostrar senha"]');
    if (passwordToggle) {
        passwordToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const passwordInput = this.closest('.input-group').querySelector('input[type="password"], input[type="text"]');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
                this.title = 'Ocultar senha';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fa-solid fa-eye';
                this.title = 'Mostrar senha';
            }
        });
    }
});
</script>

@endsection
