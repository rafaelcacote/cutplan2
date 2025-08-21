@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('roles.index') }}" class="btn-link">Perfis</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-pen-to-square fa-lg me-2"></i>
                        Editar Perfil: {{ $role->name }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
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

                    <form method="POST" action="{{ route('roles.update', $role) }}" class="card">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Informações do Perfil</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label class="form-label required">Nome do Perfil</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $role->name) }}" placeholder="Digite o nome do perfil" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-3">Permissões</h4>
                                    <div class="row">
                                        @php
                                            $modules = [
                                                'dashboard' => ['icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                                                'usuarios' => ['icon' => 'fa-users', 'label' => 'Usuários'],
                                                'perfis' => ['icon' => 'fa-user-shield', 'label' => 'Perfis'],
                                                'permissoes' => ['icon' => 'fa-key', 'label' => 'Permissões'],
                                            ];
                                            $actions = [
                                                'acessar' => 'Acessar',
                                                'listar' => 'Listar',
                                                'visualizar' => 'Visualizar',
                                                'criar' => 'Criar',
                                                'editar' => 'Editar',
                                                'excluir' => 'Excluir'
                                            ];
                                        @endphp

                                        @foreach($modules as $module => $moduleData)
                                        <div class="col-lg-6 col-xl-4 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <i class="fa-solid {{ $moduleData['icon'] }} me-2"></i>
                                                        {{ $moduleData['label'] }}
                                                    </h4>
                                                    <div class="card-actions">
                                                        <label class="form-check form-switch">
                                                            <input class="form-check-input module-toggle" type="checkbox" data-module="{{ $module }}">
                                                            <span class="form-check-label">Selecionar tudo</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @foreach($permissions as $permission)
                                                        @if(str_starts_with($permission->name, $module . '.'))
                                                            @php
                                                                $action = str_replace($module . '.', '', $permission->name);
                                                                $isChecked = in_array($permission->name, $rolePermissions) || in_array($permission->name, old('permissions', []));
                                                            @endphp
                                                            <label class="form-check">
                                                                <input class="form-check-input permission-check" type="checkbox" name="permissions[]" value="{{ $permission->name }}" data-module="{{ $module }}" {{ $isChecked ? 'checked' : '' }}>
                                                                <span class="form-check-label">{{ $actions[$action] ?? ucfirst($action) }}</span>
                                                            </label>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('roles.index') }}" class="btn btn-link">Cancelar</a>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função para atualizar o estado do toggle do módulo
    function updateModuleToggle(module) {
        const moduleToggle = document.querySelector(`input[data-module="${module}"].module-toggle`);
        const moduleCheckboxes = document.querySelectorAll(`input[data-module="${module}"].permission-check`);
        const checkedBoxes = document.querySelectorAll(`input[data-module="${module}"].permission-check:checked`);
        
        if (!moduleToggle) return;
        
        if (checkedBoxes.length === moduleCheckboxes.length && moduleCheckboxes.length > 0) {
            moduleToggle.checked = true;
            moduleToggle.indeterminate = false;
        } else if (checkedBoxes.length > 0) {
            moduleToggle.checked = false;
            moduleToggle.indeterminate = true;
        } else {
            moduleToggle.checked = false;
            moduleToggle.indeterminate = false;
        }
    }

    // Toggle de módulo completo
    document.querySelectorAll('.module-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const module = this.dataset.module;
            const checkboxes = document.querySelectorAll(`input[data-module="${module}"].permission-check`);
            
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = toggle.checked;
            });
        });
    });

    // Atualizar toggle de módulo quando permissões individuais mudam
    document.querySelectorAll('.permission-check').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const module = this.dataset.module;
            updateModuleToggle(module);
        });
    });

    // Inicializar estado dos toggles de módulo
    document.querySelectorAll('.module-toggle').forEach(function(toggle) {
        const module = toggle.dataset.module;
        updateModuleToggle(module);
    });
});
</script>
@endpush
@endsection
