@extends('layouts.app')

@section('title', 'Importar Materiais - ' . $item->descricao)

@push('styles')
    <style>
        .upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .upload-area:hover,
        .upload-area.dragover {
            border-color: #4299e1;
            background: #ebf8ff;
        }

        .item-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('projetos.show', $projeto) }}" class="text-muted">
                            {{ $projeto->nome }}
                        </a>
                    </div>
                    <h2 class="page-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                            <path d="M12 12l8 -4.5"/>
                            <path d="M12 12l0 9"/>
                            <path d="M12 12l-8 -4.5"/>
                        </svg>
                        Importar Materiais do Item
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('projetos.show', $projeto) }}" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0"/>
                                <path d="M5 12l6 6"/>
                                <path d="M5 12l6 -6"/>
                            </svg>
                            Voltar ao Projeto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Informações do Item -->
                    <div class="item-info">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-1">{{ $item->descricao }}</h3>
                                <div class="text-white-50 mb-2">
                                    Projeto: {{ $projeto->nome }} | Cliente: {{ $projeto->cliente->nome }}
                                </div>
                                <div class="d-flex gap-3">
                                    @if($item->categoria)
                                        <div>
                                            <small class="text-white-50">Categoria</small><br>
                                            <span class="badge bg-white text-dark">{{ $item->categoria }}</span>
                                        </div>
                                    @endif
                                    @if($item->quantidade)
                                        <div>
                                            <small class="text-white-50">Quantidade</small><br>
                                            <strong>{{ number_format($item->quantidade, 3) }} {{ $item->unidade ? $item->unidade->sigla : '' }}</strong>
                                        </div>
                                    @endif
                                    @if($item->materiaisPromob->count() > 0)
                                        <div>
                                            <small class="text-white-50">Materiais Atuais</small><br>
                                            <strong>{{ $item->materiaisPromob->count() }} materiais</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Importar Materiais do Promob</h3>
                        </div>
                        <form action="{{ route('projetos.itens.importar-xml.processar', [$projeto, $item]) }}" method="POST" 
                              enctype="multipart/form-data" id="import-form">
                            @csrf
                            <div class="card-body">
                                <!-- Instruções -->
                                <div class="alert alert-info">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <circle cx="12" cy="12" r="9"/>
                                                <path d="M12 8l.01 0"/>
                                                <path d="M11 12l1 0l0 4l1 0"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">Importação de Materiais por Item</h4>
                                            <div class="text-muted">
                                                <ul class="mb-0">
                                                    <li>Selecione o arquivo XML específico deste item do Promob</li>
                                                    <li>Os materiais serão associados exclusivamente a este item</li>
                                                    <li>Formato aceito: .xml (máximo 10MB)</li>
                                                    <li>Materiais duplicados serão atualizados automaticamente</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Opções de Importação -->
                                @if($item->materiaisPromob->count() > 0)
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="substituir_existentes" name="substituir_existentes" value="1">
                                            <label class="form-check-label" for="substituir_existentes">
                                                <strong>Substituir materiais existentes</strong>
                                                <div class="form-hint">Remove todos os {{ $item->materiaisPromob->count() }} materiais atuais antes da importação</div>
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                <!-- Área de Upload -->
                                <div class="mb-4">
                                    <label class="form-label">Arquivo XML do Promob</label>
                                    <div class="upload-area" id="upload-area">
                                        <input type="file" name="arquivo_xml" id="file-input" 
                                               accept=".xml" required class="d-none">
                                        <!-- Botão alternativo visível para clique direto -->
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="file-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                            </svg>
                                            Escolher Arquivo
                                        </button>
                                        <div class="upload-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-3 text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                                <path d="M12 17v-6"/>
                                                <path d="M9.5 14.5l2.5 2.5l2.5 -2.5"/>
                                            </svg>
                                            <h4>Clique aqui ou arraste o arquivo XML</h4>
                                            <div class="text-muted">Arquivo .xml específico deste item (máx. 10MB)</div>
                                            <div id="file-name" class="mt-2 fw-bold text-primary" style="display: none;"></div>
                                        </div>
                                    </div>
                                    @error('arquivo_xml')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Materiais Atuais -->
                                @if($item->materiaisPromob->count() > 0)
                                    <div class="mb-4">
                                        <label class="form-label">Materiais Atuais ({{ $item->materiaisPromob->count() }})</label>
                                        <div class="row">
                                            @foreach($item->materiaisPromob->groupBy('categoria') as $categoria => $materiais)
                                                <div class="col-md-4 mb-2">
                                                    <div class="card card-sm bg-light">
                                                        <div class="card-body">
                                                            <div class="fw-bold">{{ $categoria ?: 'Sem categoria' }}</div>
                                                            <div class="text-muted small">{{ $materiais->count() }} materiais</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('projetos.show', $projeto) }}" class="btn btn-outline-secondary">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-12"/>
                                            <path d="M9 15l3 -3l3 3"/>
                                            <path d="M12 12l0 9"/>
                                        </svg>
                                        Importar Materiais
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Loading -->
    <div class="modal modal-blur fade" id="loading-modal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Processando...</span>
                        </div>
                    </div>
                    <h4>Importando materiais...</h4>
                    <p class="text-muted">Processando arquivo XML do Promob...</p>
                </div>
            </div>
        </div>
    </div>
        <script>
        // Aguardar tanto o DOM quanto possíveis bibliotecas
        function initializeUpload() {
            const uploadArea = document.getElementById('upload-area');
            const fileInput = document.getElementById('file-input');
            const fileName = document.getElementById('file-name');
            const submitBtn = document.getElementById('submit-btn');
            const importForm = document.getElementById('import-form');
            const fileButton = document.getElementById('file-button');
            
            // Verificar se todos os elementos existem
            if (!uploadArea || !fileInput || !fileName || !submitBtn || !importForm || !fileButton) {
                console.error('Elementos não encontrados:', {
                    uploadArea: !!uploadArea,
                    fileInput: !!fileInput,
                    fileName: !!fileName,
                    submitBtn: !!submitBtn,
                    importForm: !!importForm,
                    fileButton: !!fileButton
                });
                return;
            }
            
            console.log('Todos os elementos encontrados, inicializando...');
            
            // Verificar se Bootstrap está disponível
            let loadingModal;
            
            // Tentar diferentes formas de acessar Bootstrap
            function createModalHandler() {
                const modalElement = document.getElementById('loading-modal');
                
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    console.log('Usando Bootstrap 5 nativo');
                    return new bootstrap.Modal(modalElement);
                } else if (typeof $ !== 'undefined' && $.fn.modal) {
                    console.log('Usando Bootstrap via jQuery');
                    return {
                        show: () => $(modalElement).modal('show'),
                        hide: () => $(modalElement).modal('hide')
                    };
                } else {
                    console.log('Usando fallback manual para modal');
                    return {
                        show: () => {
                            modalElement.style.display = 'block';
                            modalElement.classList.add('show');
                            document.body.classList.add('modal-open');
                        },
                        hide: () => {
                            modalElement.style.display = 'none';
                            modalElement.classList.remove('show');
                            document.body.classList.remove('modal-open');
                        }
                    };
                }
            }
            
            loadingModal = createModalHandler();
            
            // Marcar como inicializado
            window.uploadInitialized = true;
            console.log('Upload system initialized successfully');

            // Botão de escolher arquivo
            fileButton.addEventListener('click', (e) => {
                e.stopPropagation(); // Impedir que o evento chegue ao uploadArea
                console.log('File button clicked');
                fileInput.click();
            });

            // Upload area click (apenas se não clicaram no botão)
            uploadArea.addEventListener('click', (e) => {
                console.log('Upload area clicked:', e.target);
                // Não abrir se o clique foi no botão
                if (!e.target.closest('button')) {
                    console.log('Clicking file input from upload area');
                    fileInput.click();
                } else {
                    console.log('Click was on button, skipping file input click');
                }
            });

            // File input change
            fileInput.addEventListener('change', (e) => {
                console.log('File input changed:', e.target.files);
                handleFile(e.target.files[0]);
            });

            // Drag and drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                
                console.log('Files dropped:', e.dataTransfer.files);
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFile(files[0]);
                    
                    // Atualizar o input file
                    const dt = new DataTransfer();
                    dt.items.add(files[0]);
                    fileInput.files = dt.files;
                }
            });

            function handleFile(file) {
                console.log('Handling file:', file);
                console.log('File details:', {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    lastModified: file.lastModified
                });
                
                if (file) {
                    console.log('File validation - name ends with xml:', file.name.toLowerCase().endsWith('.xml'));
                    console.log('File validation - type is xml:', file.type === 'text/xml' || file.type === 'application/xml');
                    
                    // Aceitar vários tipos MIME que podem ser usados para XML
                    const validTypes = ['text/xml', 'application/xml', 'text/plain', 'application/octet-stream'];
                    const isValidType = validTypes.includes(file.type) || file.name.toLowerCase().endsWith('.xml');
                    
                    if (isValidType) {
                        console.log('File type accepted, checking size...');
                        if (file.size <= 10 * 1024 * 1024) { // 10MB
                            console.log('File size accepted, enabling submit button');
                            fileName.textContent = `Arquivo selecionado: ${file.name} (${(file.size/1024).toFixed(1)} KB)`;
                            fileName.style.display = 'block';
                            submitBtn.disabled = false;
                            
                            // Ler um pouco do conteúdo para debug
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const content = e.target.result;
                                console.log('File content preview (first 500 chars):', content.substring(0, 500));
                            };
                            reader.readAsText(file);
                            
                        } else {
                            console.log('File too large:', file.size);
                            alert('Arquivo muito grande. Máximo: 10MB');
                            clearFile();
                        }
                    } else {
                        console.log('Invalid file type. File type:', file.type, 'File name:', file.name);
                        alert('Selecione apenas arquivos .xml\nTipo detectado: ' + file.type);
                        clearFile();
                    }
                } else {
                    console.log('No file provided');
                }
            }

            function clearFile() {
                fileInput.value = '';
                fileName.style.display = 'none';
                submitBtn.disabled = true;
            }

            // Form submit
            importForm.addEventListener('submit', (e) => {
                console.log('Form submit triggered');
                console.log('Files in input:', fileInput.files);
                console.log('Submit button disabled?', submitBtn.disabled);
                
                if (!fileInput.files.length) {
                    console.log('No files selected, preventing submit');
                    e.preventDefault();
                    alert('Selecione um arquivo XML.');
                    return;
                }

                console.log('File selected, showing loading modal and submitting...');
                // Show loading modal
                loadingModal.show();
            });
            
        } // Fecha initializeUpload
        
        // Inicializar quando DOM estiver pronto
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeUpload);
        } else {
            initializeUpload();
        }
        
        // Fallback - tentar novamente após um pequeno delay se algo falhou
        setTimeout(() => {
            if (!window.uploadInitialized) {
                console.log('Tentando inicializar novamente...');
                initializeUpload();
            }
        }, 1000);
    </script>
@endsection

