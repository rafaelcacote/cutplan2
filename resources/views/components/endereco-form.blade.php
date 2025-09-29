@props([
    'estados' => [],
    'municipios' => [],
    'endereco' => null,
    'title' => 'Endereço',
    'showTitle' => true,
    'prefix' => 'endereco',
    'required' => true,
    'uniqueId' => null
])

@php
    // Usar um ID fixo para simplicidade, já que geralmente há só um formulário de endereço por página
    $uniqueId = $uniqueId ?? 'main';
@endphp

@php
    // Preparar dados do endereço existente para edição
    $enderecoData = $endereco ? [
        'cep' => $endereco->cep,
        'endereco' => $endereco->endereco,
        'numero' => $endereco->numero,
        'bairro' => $endereco->bairro,
        'complemento' => $endereco->complemento,
        'referencia' => $endereco->referencia,
        'estado_id' => $endereco->municipio->estado_id ?? null,
        'municipio_id' => $endereco->municipio_id,
    ] : [];
@endphp

@if($showTitle)
<div class="row mt-4">
    <div class="col-12">
        <h4 class="card-title mb-3">
            <i class="fa-solid fa-map-marker-alt me-2 text-primary"></i>
            {{ $title }}
        </h4>
    </div>
</div>
@endif

<!-- Linha 1: CEP, Endereço, Número -->
<div class="row">
    <div class="col-lg-3">
        <div class="mb-3">
            <label class="form-label">CEP</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-mail-bulk"></i>
                </span>
                <input 
                    type="text" 
                    class="form-control @error('{{ $prefix }}.cep') is-invalid @enderror" 
                    name="{{ $prefix }}[cep]" 
                    value="{{ old($prefix . '.cep', $enderecoData['cep'] ?? '') }}" 
                    placeholder="00000-000" 
                    id="cep_{{ $uniqueId }}" 
                    maxlength="9"
                >
                @error($prefix . '.cep')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label {{ $required ? 'required' : '' }}">Endereço</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-road"></i>
                </span>
                <input 
                    type="text" 
                    class="form-control @error('{{ $prefix }}.endereco') is-invalid @enderror" 
                    name="{{ $prefix }}[endereco]" 
                    value="{{ old($prefix . '.endereco', $enderecoData['endereco'] ?? '') }}" 
                    placeholder="Rua, Avenida..." 
                    maxlength="150" 
                    id="endereco_{{ $uniqueId }}"
                    {{ $required ? 'required' : '' }}
                >
                @error($prefix . '.endereco')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <label class="form-label {{ $required ? 'required' : '' }}">Número</label>
            <input 
                type="text" 
                class="form-control @error('{{ $prefix }}.numero') is-invalid @enderror" 
                name="{{ $prefix }}[numero]" 
                value="{{ old($prefix . '.numero', $enderecoData['numero'] ?? '') }}" 
                placeholder="123" 
                maxlength="10" 
                id="numero_{{ $uniqueId }}"
                {{ $required ? 'required' : '' }}
            >
            @error($prefix . '.numero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Linha 2: Bairro, Estado, Município, Complemento -->
<div class="row">
    <div class="col-lg-3">
        <div class="mb-3">
            <label class="form-label {{ $required ? 'required' : '' }}">Bairro</label>
            <input 
                type="text" 
                class="form-control @error('{{ $prefix }}.bairro') is-invalid @enderror" 
                name="{{ $prefix }}[bairro]" 
                value="{{ old($prefix . '.bairro', $enderecoData['bairro'] ?? '') }}" 
                placeholder="Nome do bairro" 
                maxlength="45" 
                id="bairro_{{ $uniqueId }}"
                {{ $required ? 'required' : '' }}
            >
            @error($prefix . '.bairro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <label class="form-label {{ $required ? 'required' : '' }}">Estado</label>
            <select 
                class="form-select @error('{{ $prefix }}.estado_id') is-invalid @enderror" 
                name="{{ $prefix }}[estado_id]" 
                id="estado_id_{{ $uniqueId }}"
                {{ $required ? 'required' : '' }}
            >
                <option value="">Selecione o estado</option>
                @foreach($estados as $estado)
                    <option 
                        value="{{ $estado->id }}" 
                        {{ old($prefix . '.estado_id', $enderecoData['estado_id'] ?? '') == $estado->id ? 'selected' : '' }}
                    >
                        {{ $estado->nome }} ({{ $estado->uf }})
                    </option>
                @endforeach
            </select>
            @error($prefix . '.estado_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <label class="form-label {{ $required ? 'required' : '' }}">Município</label>
            <select 
                class="form-select @error('{{ $prefix }}.municipio_id') is-invalid @enderror" 
                name="{{ $prefix }}[municipio_id]" 
                id="municipio_id_{{ $uniqueId }}"
                data-old-value="{{ old($prefix . '.municipio_id', $enderecoData['municipio_id'] ?? '') }}"
                {{ $required ? 'required' : '' }}
            >
                <option value="">Selecione o município</option>
                {{-- Municípios filtrados por estado via JS --}}
            </select>
            @error($prefix . '.municipio_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <label class="form-label">Complemento</label>
            <input 
                type="text" 
                class="form-control @error('{{ $prefix }}.complemento') is-invalid @enderror" 
                name="{{ $prefix }}[complemento]" 
                value="{{ old($prefix . '.complemento', $enderecoData['complemento'] ?? '') }}" 
                placeholder="Apto, Bloco..." 
                maxlength="150" 
                id="complemento_{{ $uniqueId }}"
            >
            @error($prefix . '.complemento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Linha 3: Referência -->
<div class="row">
    <div class="col-lg-12">
        <div class="mb-3">
            <label class="form-label">Referência</label>
            <input 
                type="text" 
                class="form-control @error('{{ $prefix }}.referencia') is-invalid @enderror" 
                name="{{ $prefix }}[referencia]" 
                value="{{ old($prefix . '.referencia', $enderecoData['referencia'] ?? '') }}" 
                placeholder="Próximo ao..." 
                maxlength="255" 
                id="referencia_{{ $uniqueId }}"
            >
            @error($prefix . '.referencia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
@vite('resources/js/endereco.js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Inicializando componente endereco para ID: {{ $uniqueId }}');
        
        // Dados dos municípios para JavaScript
        window.municipios = @json($municipios ?? []);
        
        // Verificar se a classe existe
        if (typeof window.EnderecoHandler === 'undefined') {
            console.error('EnderecoHandler não encontrado!');
            return;
        }
        
        try {
            // Inicializar endereço para este formulário específico
            const enderecoHandler = new window.EnderecoHandler('{{ $uniqueId }}');
            enderecoHandler.initializeMunicipioFilter(window.municipios, '{{ $uniqueId }}');
            console.log('EnderecoHandler inicializado com sucesso para ID: {{ $uniqueId }}');
        } catch (error) {
            console.error('Erro ao inicializar EnderecoHandler:', error);
        }
    });
</script>
@endpush