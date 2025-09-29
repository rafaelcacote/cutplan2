@extends('layouts.app')

@section('content')
    @include('components.toast')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            <a href="{{ route('fornecedores.index') }}" class="btn-link">Fornecedores</a>
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-truck fa-lg me-2"></i>
                            Editar Fornecedor
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          
                            <a href="{{ route('fornecedores.index') }}" class="btn btn-outline-secondary">
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
                        <form method="POST" action="{{ route('fornecedores.update', $fornecedor) }}" class="card">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h3 class="card-title">Informações do Fornecedor</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label class="form-label required">Nome</label>
                                            <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $fornecedor->nome) }}" placeholder="Digite o nome" maxlength="150">
                                            @error('nome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Documento (CPF/CNPJ)</label>
                                            <input type="text" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ old('documento', $fornecedor->documento) }}" placeholder="000.000.000-00 ou 00.000.000/0000-00" maxlength="18" id="documento">
                                            <small class="form-hint">Digite CPF (11 dígitos) ou CNPJ (14 dígitos)</small>
                                            @error('documento')
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
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $fornecedor->email) }}" placeholder="fornecedor@email.com" maxlength="150">
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
                                                <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $fornecedor->telefone) }}" placeholder="(99) 99999-9999" maxlength="50">
                                                @error('telefone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4 class="card-title mb-3">
                                            <i class="fa-solid fa-map-marker-alt me-2 text-primary"></i>
                                            Endereço
                                        </h4>
                                    </div>
                                </div>
                                <!-- Linha 1: CEP, Endereço, Número -->
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">CEP</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-mail-bulk"></i>
                                                </span>
                                                <input type="text" class="form-control @error('endereco.cep') is-invalid @enderror" name="endereco[cep]" value="{{ old('endereco.cep', $endereco->cep ?? '') }}" placeholder="00000-000" maxlength="9" id="cep">
                                                @error('endereco.cep')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Endereço</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-road"></i>
                                                </span>
                                                <input type="text" class="form-control @error('endereco.endereco') is-invalid @enderror" name="endereco[endereco]" value="{{ old('endereco.endereco', $endereco->endereco ?? '') }}" placeholder="Rua, Avenida..." maxlength="150" id="endereco">
                                                @error('endereco.endereco')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label required">Número</label>
                                            <input type="text" class="form-control @error('endereco.numero') is-invalid @enderror" name="endereco[numero]" value="{{ old('endereco.numero', $endereco->numero ?? '') }}" placeholder="123" maxlength="10" id="numero">
                                            @error('endereco.numero')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Linha 2: Bairro, Estado, Município, Complemento -->
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label required">Bairro</label>
                                            <input type="text" class="form-control @error('endereco.bairro') is-invalid @enderror" name="endereco[bairro]" value="{{ old('endereco.bairro', $endereco->bairro ?? '') }}" placeholder="Nome do bairro" maxlength="45" id="bairro">
                                            @error('endereco.bairro')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label required">Estado</label>
                                            <select class="form-select @error('endereco.estado_id') is-invalid @enderror" name="endereco[estado_id]" id="estado_id">
                                                <option value="">Selecione o estado</option>
                                                @foreach($estados as $estado)
                                                    <option value="{{ $estado->id }}" {{ old('endereco.estado_id', $endereco->municipio->estado_id ?? null) == $estado->id ? 'selected' : '' }}>{{ $estado->nome }} ({{ $estado->uf }})</option>
                                                @endforeach
                                            </select>
                                            @error('endereco.estado_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label required">Município</label>
                                            <select class="form-select @error('endereco.municipio_id') is-invalid @enderror" name="endereco[municipio_id]" id="municipio_id">
                                                <option value="">Selecione o município</option>
                                                {{-- Municípios filtrados por estado via JS --}}
                                            </select>
                                            @error('endereco.municipio_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Complemento</label>
                                            <input type="text" class="form-control @error('endereco.complemento') is-invalid @enderror" name="endereco[complemento]" value="{{ old('endereco.complemento', $endereco->complemento ?? '') }}" placeholder="Apto, Bloco..." maxlength="150" id="complemento">
                                            @error('endereco.complemento')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Referência</label>
                                            <input type="text" class="form-control @error('endereco.referencia') is-invalid @enderror" name="endereco[referencia]" value="{{ old('endereco.referencia', $endereco->referencia ?? '') }}" placeholder="Próximo ao..." maxlength="255" id="referencia">
                                            @error('endereco.referencia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Linha 3: Observação -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Observações</label>
                                            <textarea class="form-control @error('observacoes') is-invalid @enderror" name="observacoes" rows="3" placeholder="Observações adicionais sobre o fornecedor..." id="observacoes">{{ old('observacoes', $fornecedor->observacoes) }}</textarea>
                                            @error('observacoes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    window.municipios = @json($municipios ?? []);
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Máscara para documento (CPF/CNPJ)
                                        const documentoInput = document.getElementById('documento');
                                        if (documentoInput) {
                                            documentoInput.addEventListener('input', function() {
                                                let value = this.value.replace(/\D/g, '');
                                                
                                                if (value.length <= 11) {
                                                    // Máscara CPF: 000.000.000-00
                                                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                                                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                                                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                                                } else {
                                                    // Máscara CNPJ: 00.000.000/0000-00
                                                    value = value.replace(/(\d{2})(\d)/, '$1.$2');
                                                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                                                    value = value.replace(/(\d{3})(\d)/, '$1/$2');
                                                    value = value.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
                                                }
                                                
                                                this.value = value;
                                            });
                                        }
                                        
                                        // Máscara telefone
                                        const telefoneInput = document.querySelector('input[name="telefone"]');
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
                                        // Máscara CEP
                                        const cepInput = document.getElementById('cep');
                                        if (cepInput) {
                                            cepInput.addEventListener('input', function() {
                                                let value = this.value.replace(/\D/g, '');
                                                value = value.replace(/(\d{5})(\d)/, '$1-$2');
                                                this.value = value;
                                            });
                                            // Busca de endereço por CEP (usando ViaCEP)
                                            function buscarCep(cepInput) {
                                                const cep = cepInput.value.replace(/\D/g, '');
                                                if (cep.length === 8) {
                                                    const originalBg = cepInput.style.backgroundColor;
                                                    cepInput.style.backgroundColor = '#f8f9fa';
                                                    cepInput.style.cursor = 'wait';
                                                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            cepInput.style.backgroundColor = originalBg;
                                                            cepInput.style.cursor = '';
                                                            if (!data.erro) {
                                                                document.getElementById('endereco').value = data.logradouro || '';
                                                                document.getElementById('bairro').value = data.bairro || '';
                                                                const estadoSelect = document.getElementById('estado_id');
                                                                const municipioSelect = document.getElementById('municipio_id');
                                                                for (let i = 0; i < estadoSelect.options.length; i++) {
                                                                    if (estadoSelect.options[i].text.includes(data.uf)) {
                                                                        estadoSelect.selectedIndex = i;
                                                                        estadoSelect.dispatchEvent(new Event('change'));
                                                                        break;
                                                                    }
                                                                }
                                                                setTimeout(() => {
                                                                    for (let i = 0; i < municipioSelect.options.length; i++) {
                                                                        if (municipioSelect.options[i].text.trim() === data.localidade) {
                                                                            municipioSelect.selectedIndex = i;
                                                                            break;
                                                                        }
                                                                    }
                                                                }, 200);
                                                                document.getElementById('numero').focus();
                                                                showToast('CEP Encontrado!', `Endereço preenchido automaticamente para ${data.localidade}/${data.uf}`, 'success');
                                                            } else {
                                                                showToast(
                                                                    'CEP Não Encontrado',
                                                                    `O CEP ${cep.replace(/(\d{5})(\d{3})/, '$1-$2')} não foi encontrado. Verifique o número digitado e tente novamente.`,
                                                                    'error'
                                                                );
                                                                cepInput.focus();
                                                                cepInput.select();
                                                            }
                                                        })
                                                        .catch(error => {
                                                            cepInput.style.backgroundColor = originalBg;
                                                            cepInput.style.cursor = '';
                                                            showToast(
                                                                'Erro de Conexão',
                                                                'Não foi possível consultar o CEP. Verifique sua conexão e tente novamente.',
                                                                'error'
                                                            );
                                                        });
                                                }
                                            }
                                            cepInput.addEventListener('blur', function() {
                                                buscarCep(this);
                                            });
                                            cepInput.addEventListener('keypress', function(e) {
                                                if (e.key === 'Enter') {
                                                    e.preventDefault();
                                                    buscarCep(this);
                                                }
                                            });
                                        }
                                        // Estado/Município
                                        const estadoSelect = document.getElementById('estado_id');
                                        const municipioSelect = document.getElementById('municipio_id');
                                        const municipios = window.municipios;
                                        const oldMunicipioId = "{{ old('endereco.municipio_id', $endereco->municipio_id ?? null) }}";
                                        function filtrarMunicipios() {
                                            const estadoId = estadoSelect.value;
                                            municipioSelect.innerHTML = '<option value="">Selecione o município</option>';
                                            if (estadoId && municipios[estadoId]) {
                                                municipios[estadoId].forEach(function(m) {
                                                    const selected = oldMunicipioId == m.id ? 'selected' : '';
                                                    municipioSelect.innerHTML += `<option value="${m.id}" ${selected}>${m.nome}</option>`;
                                                });
                                            }
                                        }
                                        estadoSelect.addEventListener('change', filtrarMunicipios);
                                        if (estadoSelect.value) filtrarMunicipios();
                                    });
                                </script>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex">
                                    <a href="{{ route('fornecedores.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-left me-2"></i> Voltar
                                    </a>
                                    <button type="submit" class="btn btn-primary ms-auto">
                                        <i class="fa-solid fa-save me-2"></i> Salvar Fornecedor
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
