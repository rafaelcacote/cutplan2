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
                        <i class="fa-solid fa-building-user fa-lg me-2"></i>
                        Nova Empresa
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
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

                    <form method="POST" action="{{ route('tenants.store') }}" enctype="multipart/form-data" class="card">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Informações da Empresa</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome da Empresa</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" placeholder="Digite o nome da empresa" required>
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">CNPJ</label>
                                        <input type="text" class="form-control @error('cnpj') is-invalid @enderror" name="cnpj" value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00" id="cnpj">
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
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="contato@empresa.com">
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
                                            <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" id="telefone">
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
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" placeholder="slug-da-empresa" id="slug">
                                        <small class="form-hint">Deixe em branco para gerar automaticamente. Usado para URLs amigáveis</small>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Preview do Logo -->
                            <div class="row" id="logo-preview-container" style="display: none;">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Preview do Logo</label>
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
                                    <i class="fa-solid fa-plus me-2"></i> Criar Empresa
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

    // Gerar slug automaticamente baseado no nome
    const nomeInput = document.querySelector('input[name="nome"]');
    const slugInput = document.getElementById('slug');
    
    if (nomeInput && slugInput) {
        nomeInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.manual !== 'true') {
                const slug = this.value
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                    .replace(/[^a-z0-9\s-]/g, '') // Remove caracteres especiais
                    .replace(/\s+/g, '-') // Substitui espaços por hífens
                    .replace(/-+/g, '-') // Remove hífens duplicados
                    .replace(/^-|-$/g, ''); // Remove hífens do início e fim
                
                slugInput.value = slug;
            }
        });

        // Marcar como manual se o usuário editar o slug
        slugInput.addEventListener('input', function() {
            this.dataset.manual = 'true';
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
        estadoSelect.addEventListener('change', function() {
            const estadoId = this.value;
            
            // Limpar municípios
            municipioSelect.innerHTML = '<option value="">Selecione o município</option>';
            
            if (estadoId && municipios[estadoId]) {
                municipios[estadoId].forEach(function(municipio) {
                    const option = document.createElement('option');
                    option.value = municipio.id;
                    option.textContent = municipio.nome;
                    municipioSelect.appendChild(option);
                });
            }
        });

        // Pré-selecionar município se houver valor old
        @if(old('endereco.municipio_id'))
            const oldMunicipioId = {{ old('endereco.municipio_id') }};
            const oldEstadoId = {{ old('endereco.estado_id') ?? 'null' }};
            
            if (oldEstadoId && municipios[oldEstadoId]) {
                municipios[oldEstadoId].forEach(function(municipio) {
                    const option = document.createElement('option');
                    option.value = municipio.id;
                    option.textContent = municipio.nome;
                    if (municipio.id == oldMunicipioId) {
                        option.selected = true;
                    }
                    municipioSelect.appendChild(option);
                });
            }
        @endif
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