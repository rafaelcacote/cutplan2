@extends('layouts.app')

@section('title', 'Importar Materiais do Promob - ' . $itemProjeto->descricao)

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                <path d="M12 17v-6"/>
                                <path d="m9 14l3 3l3 -3"/>
                            </svg>
                            Importar Materiais do Promob
                        </h3>
                        <div class="card-actions">
                            <a href="{{ route('projetos.show', $itemProjeto->projeto_id) }}" class="btn btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 14l-4 -4l4 -4"/>
                                    <path d="M5 10h11a4 4 0 1 1 0 8h-1"/>
                                </svg>
                                Voltar ao Projeto
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Informações do Item -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h4>{{ $itemProjeto->descricao }}</h4>
                                <p class="text-muted">
                                    <strong>Projeto:</strong> {{ $itemProjeto->projeto->nome }}<br>
                                    @if($itemProjeto->codigo_promob)
                                        <strong>Código Promob:</strong> {{ $itemProjeto->codigo_promob }}<br>
                                    @endif
                                    @if($itemProjeto->data_importacao_xml)
                                        <strong>Última Importação:</strong> {{ $itemProjeto->data_importacao_xml->format('d/m/Y H:i') }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                @if($itemProjeto->materiaisImportados->count() > 0)
                                    <div class="alert alert-info">
                                        <strong>{{ $itemProjeto->materiaisImportados->count() }}</strong> materiais importados
                                    </div>
                                    <button class="btn btn-outline-danger" id="btn-limpar-importacao">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0"/>
                                            <path d="M10 11l0 6"/>
                                            <path d="M14 11l0 6"/>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                        Limpar Importação
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Upload do XML -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-primary">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Upload do arquivo XML</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="form-upload-xml" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label for="xml_file" class="form-label">Arquivo XML do Promob</label>
                                                        <input type="file" class="form-control" id="xml_file" name="xml_file" accept=".xml" required>
                                                        <div class="form-hint">
                                                            Selecione o arquivo XML gerado pelo Promob contendo a lista de materiais
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-grid gap-2">
                                                        <button type="button" class="btn btn-primary" id="btn-preview">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                            </svg>
                                                            Visualizar Materiais
                                                        </button>
                                                        <button type="button" class="btn btn-success" id="btn-importar" disabled>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M12 17v-6"/>
                                                                <path d="m9 14l3 3l3 -3"/>
                                                                <path d="M19 21h-14a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                                            </svg>
                                                            Importar Materiais
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview dos Materiais -->
                        <div id="preview-container" class="row mt-4" style="display: none;">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Preview dos Materiais</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="preview-content">
                                            <!-- Conteúdo será carregado via JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Materiais Importados -->
                        @if($itemProjeto->materiaisImportados->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Materiais Importados</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Descrição</th>
                                                        <th>Quantidade</th>
                                                        <th>Unidade</th>
                                                        <th>Material Vinculado</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($itemProjeto->materiaisImportados as $material)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $material->descricao }}</strong>
                                                            @if($material->codigo_promob)
                                                                <br><small class="text-muted">Código: {{ $material->codigo_promob }}</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($material->quantidade, 2, ',', '.') }}</td>
                                                        <td>{{ $material->unidade }}</td>
                                                        <td>
                                                            @if($material->material)
                                                                <span class="badge bg-success">
                                                                    {{ $material->material->nome }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-warning">Não vinculado</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                @if($material->material)
                                                                    <button class="btn btn-sm btn-outline-danger btn-desvincular" 
                                                                            data-material-id="{{ $material->id }}">
                                                                        Desvincular
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-sm btn-outline-primary btn-vincular" 
                                                                            data-material-id="{{ $material->id }}">
                                                                        Vincular
                                                                    </button>
                                                                @endif
                                                                <button class="btn btn-sm btn-outline-danger btn-remover" 
                                                                        data-material-id="{{ $material->id }}">
                                                                    Remover
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmação de importação -->
<div class="modal modal-blur fade" id="modal-confirmar-importacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Importação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente importar os materiais listados? Esta ação irá:</p>
                <ul>
                    <li>Remover todos os materiais importados anteriormente deste item</li>
                    <li>Adicionar os novos materiais do arquivo XML</li>
                    <li>Tentar vincular automaticamente aos materiais cadastrados</li>
                </ul>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="confirmar_importacao" name="confirmar_importacao">
                    <label class="form-check-label" for="confirmar_importacao">
                        Estou ciente e desejo prosseguir com a importação
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btn-confirmar-importacao" disabled>
                    Confirmar Importação
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formUpload = document.getElementById('form-upload-xml');
    const btnPreview = document.getElementById('btn-preview');
    const btnImportar = document.getElementById('btn-importar');
    const btnLimparImportacao = document.getElementById('btn-limpar-importacao');
    const previewContainer = document.getElementById('preview-container');
    const previewContent = document.getElementById('preview-content');
    const modalConfirmar = new bootstrap.Modal(document.getElementById('modal-confirmar-importacao'));
    const btnConfirmarImportacao = document.getElementById('btn-confirmar-importacao');
    const checkConfirmar = document.getElementById('confirmar_importacao');

    let previewData = null;

    // Preview dos materiais
    btnPreview.addEventListener('click', function() {
        console.log('🚀 Botão preview clicado');
        
        const formData = new FormData(formUpload);
        const file = formData.get('xml_file');
        
        console.log('📁 Arquivo selecionado:', file ? file.name : 'nenhum');
        console.log('📊 Tamanho do arquivo:', file ? file.size : 'N/A');
        
        if (!file) {
            console.log('❌ Nenhum arquivo selecionado');
            showAlert('Selecione um arquivo XML primeiro.', 'warning');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        console.log('🔒 CSRF Token encontrado:', csrfToken ? 'sim' : 'não');
        console.log('🔗 URL da requisição:', '{{ route("projetos.itens.promob.preview", $itemProjeto->id) }}');

        btnPreview.disabled = true;
        btnPreview.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processando...';

        fetch('{{ route("projetos.itens.promob.preview", $itemProjeto->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('📡 Status da resposta:', response.status, response.statusText);
            console.log('📋 Content-Type:', response.headers.get('content-type'));
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('✅ Dados recebidos:', data);
            
            if (data.success) {
                console.log('🎉 Preview bem-sucedido, materiais encontrados:', data.total_materiais);
                previewData = data;
                showPreview(data);
                btnImportar.disabled = false;
            } else {
                console.log('❌ Erro no preview:', data.message);
                showAlert(data.message || 'Erro desconhecido no preview', 'error');
            }
        })
        .catch(error => {
            console.error('💥 Erro na requisição:', error);
            showAlert(`Erro ao processar o arquivo: ${error.message}`, 'error');
        })
        .finally(() => {
            btnPreview.disabled = false;
            btnPreview.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/></svg>Visualizar Materiais';
        });
    });

    // Importar materiais
    btnImportar.addEventListener('click', function() {
        modalConfirmar.show();
    });

    // Confirmar importação
    checkConfirmar.addEventListener('change', function() {
        btnConfirmarImportacao.disabled = !this.checked;
    });

    btnConfirmarImportacao.addEventListener('click', function() {
        const formData = new FormData(formUpload);
        formData.append('confirmar_importacao', '1');

        btnConfirmarImportacao.disabled = true;
        btnConfirmarImportacao.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Importando...';

        fetch('{{ route("projetos.itens.promob.import.execute", $itemProjeto->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                modalConfirmar.hide();
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            showAlert('Erro na importação.', 'error');
        })
        .finally(() => {
            btnConfirmarImportacao.disabled = false;
            btnConfirmarImportacao.innerHTML = 'Confirmar Importação';
        });
    });

    // Limpar importação
    if (btnLimparImportacao) {
        btnLimparImportacao.addEventListener('click', function() {
            if (!confirm('Deseja realmente limpar toda a importação? Esta ação não pode ser desfeita.')) {
                return;
            }

            fetch('{{ route("projetos.itens.promob.limpar", $itemProjeto->id) }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert(data.message, 'error');
                }
            });
        });
    }

    function showPreview(data) {
        let html = `
            <div class="alert alert-info">
                <strong>Total de materiais encontrados:</strong> ${data.total_materiais}
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        data.materiais.forEach(material => {
            const statusClass = material.status_match === 'encontrado' ? 'success' : 'warning';
            const statusText = material.status_match === 'encontrado' ? 'Material encontrado' : 'Novo material';
            
            html += `
                <tr>
                    <td>
                        <strong>${material.descricao}</strong>
                        ${material.codigo_promob ? `<br><small class="text-muted">Código: ${material.codigo_promob}</small>` : ''}
                    </td>
                    <td>${material.quantidade}</td>
                    <td>${material.unidade}</td>
                    <td>
                        <span class="badge bg-${statusClass}">${statusText}</span>
                        ${material.material_encontrado ? `<br><small>${material.material_encontrado.nome}</small>` : ''}
                    </td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        `;

        previewContent.innerHTML = html;
        previewContainer.style.display = 'block';
    }

    function showAlert(message, type) {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning'
        };

        const alert = document.createElement('div');
        alert.className = `alert ${alertClass[type]} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.querySelector('.container-xl').prepend(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
});
</script>
@endpush