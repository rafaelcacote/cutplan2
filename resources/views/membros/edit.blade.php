@extends('layouts.app')

@section('content')
    @include('components.toast')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            <a href="{{ route('membros.index') }}" class="btn-link">Membros</a>
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-user-pen fa-lg me-2"></i>
                            Editar Membro
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('membros.show', $membro) }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-eye me-2"></i> Visualizar
                            </a>
                            <a href="{{ route('membros.index') }}" class="btn btn-outline-secondary">
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
                        <form method="POST" action="{{ route('membros.update', $membro) }}" class="card">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h3 class="card-title">Informações do Membro</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Nome</label>
                                            <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $membro->nome) }}" placeholder="Digite o nome completo" maxlength="100">
                                            @error('nome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </span>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $membro->email) }}" placeholder="membro@email.com" maxlength="100">
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
                                            <label class="form-label">Telefone</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-phone"></i>
                                                </span>
                                                <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $membro->telefone) }}" placeholder="(99) 99999-9999" maxlength="20" id="telefone">
                                                @error('telefone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Cargo</label>
                                            <select class="form-select @error('cargo_id') is-invalid @enderror" name="cargo_id" required>
                                                <option value="">Selecione o cargo</option>
                                                @foreach($cargos as $cargo)
                                                    <option value="{{ $cargo->id }}" {{ old('cargo_id', $membro->cargo_id) == $cargo->id ? 'selected' : '' }}>{{ $cargo->nome }}</option>
                                                @endforeach
                                            </select>
                                            @error('cargo_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Ativo</label>
                                            <select class="form-select @error('ativo') is-invalid @enderror" name="ativo">
                                                <option value="1" {{ old('ativo', $membro->ativo) == 1 ? 'selected' : '' }}>Sim</option>
                                                <option value="0" {{ old('ativo', $membro->ativo) == 0 ? 'selected' : '' }}>Não</option>
                                            </select>
                                            @error('ativo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Máscara telefone
                                        const telefoneInput = document.getElementById('telefone');
                                        if (telefoneInput) {
                                            telefoneInput.addEventListener('input', function() {
                                                let value = this.value.replace(/\D/g, '');
                                                if (value.length > 10) {
                                                    value = value.replace(/(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
                                                } else if (value.length > 5) {
                                                    value = value.replace(/(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
                                                } else if (value.length > 2) {
                                                    value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
                                                }
                                                this.value = value;
                                            });
                                        }
                                    });
                                </script>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex">
                                    <a href="{{ route('membros.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                                    </a>
                                    <button type="submit" class="btn btn-primary ms-auto">
                                        <i class="fa-solid fa-save me-2"></i> Salvar Membro
                                    </button>
                                </div>
                            </div>
                            @if(session('success'))
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        showToast('Sucesso!', @json(session('success')), 'success');
                                    });
                                </script>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
