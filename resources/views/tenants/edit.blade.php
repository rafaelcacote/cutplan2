@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('tenants.index') }}" class="btn-link">Empresas</a>
                    </div>
                    <h2 class="page-title">
                        <i class="fa-solid fa-pen-to-square fa-lg me-2"></i>
                        Editar Empresa
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('tenants.show', $tenant) }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-eye me-2"></i> Visualizar
                        </a>
                        <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">
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

                    <form method="POST" action="{{ route('tenants.update', $tenant) }}" enctype="multipart/form-data" class="card">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Informações da Empresa</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome da Empresa</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $tenant->nome) }}" placeholder="Digite o nome da empresa" required>
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">CNPJ</label>
                                        <input type="text" class="form-control @error('cnpj') is-invalid @enderror" name="cnpj" value="{{ old('cnpj', $tenant->formatted_cnpj) }}" placeholder="00.000.000/0000-00" id="cnpj">
                                        <small class="form-hint">Digite apenas números ou use a máscara</small>
                                        @error('cnpj')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-mail</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa-solid fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $tenant->email) }}" placeholder="contato@empresa.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Telefone</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa-solid fa-phone"></i>
                                            </span>
                                            <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $tenant->formatted_telefone) }}" placeholder="(00) 00000-0000" id="telefone">
                                            @error('telefone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <x-endereco-form 
                                :estados="$estados" 
                                :municipios="$municipios" 
                                :endereco="$endereco ?? null"
                                title="Endereço da Empresa"
                                prefix="endereco"
                                :required="true"
                            />

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Logo da Empresa</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*" id="logo">
                                        <small class="form-hint">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</small>
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $tenant->slug) }}" placeholder="slug-da-empresa" id="slug">
                                        <small class="form-hint">Usado para URLs amigáveis</small>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Logo Atual -->
                            @if($tenant->logo)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Logo Atual</label>
                                            <div class="border rounded p-3 text-center bg-light">
                                                <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo atual" class="img-thumbnail" style="max-height: 150px;">
                                                <div class="mt-2">
                                                    <small class="text-muted">Selecione uma nova imagem para substituir</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Preview do Novo Logo -->
                            <div class="row" id="logo-preview-container" style="display: none;">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Preview do Novo Logo</label>
                                        <div class="border rounded p-3 text-center bg-light">
                                            <img id="logo-preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('tenants.index') }}" class="btn btn-link">Cancelar</a>
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


<script src="https://cdn.jsdelivr.net/npm/imask@7.1.3/dist/imask.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CNPJ
    const cnpjInput = document.getElementById('cnpj');
    if (cnpjInput) {
        IMask(cnpjInput, {
            mask: '00.000.000/0000-00'
        });
    }
    
    // Máscara para Telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        IMask(telefoneInput, {
            mask: [
                {
                    mask: '(00) 0000-0000'
                },
                {
                    mask: '(00) 00000-0000'
                }
            ]
        });
    }

    // Preview do logo
    const logoInput = document.getElementById('logo');
    const logoPreviewContainer = document.getElementById('logo-preview-container');
    const logoPreview = document.getElementById('logo-preview');

    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    logoPreview.src = e.target.result;
                    logoPreviewContainer.style.display = 'block';
                };
                
                reader.readAsDataURL(file);
            } else {
                logoPreviewContainer.style.display = 'none';
            }
        });
    }

    // Filtro de municípios por estado
    const estadoSelect = document.getElementById('estado_id');
    const municipioSelect = document.getElementById('municipio_id');
    const municipios = @json($municipios);

    if (estadoSelect && municipioSelect) {
        // Função para carregar municípios
        function carregarMunicipios(estadoId, municipioSelecionado = null) {
            municipioSelect.innerHTML = '<option value="">Selecione o município</option>';
            
            if (estadoId && municipios[estadoId]) {
                municipios[estadoId].forEach(function(municipio) {
                    const option = document.createElement('option');
                    option.value = municipio.id;
                    option.textContent = municipio.nome;
                    if (municipioSelecionado && municipio.id == municipioSelecionado) {
                        option.selected = true;
                    }
                    municipioSelect.appendChild(option);
                });
            }
        }

        // Carregar municípios ao mudar estado
        estadoSelect.addEventListener('change', function() {
            carregarMunicipios(this.value);
        });

        // Carregar municípios iniciais
        const estadoInicial = estadoSelect.value;
        const municipioInicial = {{ old('endereco.municipio_id', $endereco->municipio_id ?? 'null') }};
        if (estadoInicial) {
            carregarMunicipios(estadoInicial, municipioInicial);
        }
    }

    // Máscara para CEP
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        IMask(cepInput, {
            mask: '00000-000'
        });
    }
});
</script>

@endsection