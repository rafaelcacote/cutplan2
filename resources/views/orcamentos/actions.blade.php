@extends('layouts.app')

@section('content')
    @include('components.toast')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            <a href="{{ route('orcamentos.index') }}" class="btn-link">Orçamentos</a>
                        </div>
                        <h2 class="page-title">
                            <i class="fa-solid fa-rocket fa-lg me-2"></i>
                            Orçamento Criado com Sucesso!
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('orcamentos.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left me-2"></i> Voltar à Lista
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <!-- Card de Sucesso -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <div class="avatar avatar-xl bg-success text-white mb-3 mx-auto">
                                        <i class="fa-solid fa-check fa-2x"></i>
                                    </div>
                                    <h3 class="text-success">🎉 Orçamento Criado com Sucesso!</h3>
                                    <p class="text-muted">Orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }} está pronto para ser enviado</p>
                                </div>

                                <!-- Resumo do Orçamento -->
                                <div class="row text-center mb-4">
                                    <div class="col-md-3 col-6">
                                        <div class="card bg-light">
                                            <div class="card-body py-3">
                                                <div class="text-muted small">Cliente</div>
                                                <div class="h6 mb-0">{{ $orcamento->cliente->nome }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="card bg-light">
                                            <div class="card-body py-3">
                                                <div class="text-muted small">Total</div>
                                                <div class="h6 mb-0 text-success">R$ {{ number_format($orcamento->total, 2, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="card bg-light">
                                            <div class="card-body py-3">
                                                <div class="text-muted small">Itens</div>
                                                <div class="h6 mb-0">{{ $orcamento->itens->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="card bg-light">
                                            <div class="card-body py-3">
                                                <div class="text-muted small">Status</div>
                                                <span class="badge bg-primary text-white">Pronto</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ações Principais -->
                                <div class="mb-4">
                                    <h4 class="mb-3">O que deseja fazer agora?</h4>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <a href="{{ route('orcamentos.pdf', $orcamento) }}" target="_blank" 
                                               class="btn btn-danger btn-lg w-100">
                                                <i class="fa-solid fa-file-pdf me-2"></i>
                                                Visualizar PDF
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary btn-lg w-100" 
                                                    onclick="showEmailModal()">
                                                <i class="fa-solid fa-envelope me-2"></i>
                                                Enviar por Email
                                            </button>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ route('orcamentos.send-whatsapp', $orcamento) }}" 
                                               class="btn btn-success btn-lg w-100" target="_blank">
                                                <i class="fa-brands fa-whatsapp me-2"></i>
                                                Enviar via WhatsApp
                                            </a>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <a href="{{ route('orcamentos.edit', $orcamento) }}" 
                                               class="btn btn-warning btn-lg w-100">
                                                <i class="fa-solid fa-edit me-2"></i>
                                                Editar Orçamento
                                            </a>
                                        </div> -->
                                    </div>
                                </div>

                                <!-- Link Público -->
                                <div class="alert alert-info">
                                    <i class="fa-solid fa-info-circle me-2"></i>
                                    <strong>Link público do orçamento:</strong>
                                    <br>
                                    <small>
                                        <a href="{{ route('orcamentos.public', $orcamento->uuid) }}" target="_blank" class="text-decoration-none">
                                            {{ route('orcamentos.public', $orcamento->uuid) }}
                                        </a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Envio por Email -->
    <div class="modal modal-blur fade" id="modal-email" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('orcamentos.send-email', $orcamento) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-envelope me-2"></i>
                            Enviar por Email
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">Email do destinatário</label>
                            <input type="email" class="form-control" name="email" 
                                   value="{{ $orcamento->cliente->email ?? '' }}" required 
                                   placeholder="email@exemplo.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mensagem personalizada (opcional)</label>
                            <textarea class="form-control" name="message" rows="3" 
                                      placeholder="Adicione uma mensagem personalizada..."></textarea>
                        </div>
                        <div class="alert alert-info">
                            <i class="fa-solid fa-paperclip me-2"></i>
                            O PDF do orçamento será anexado automaticamente ao email.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-paper-plane me-2"></i>
                            Enviar Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showEmailModal() {
            const modal = new bootstrap.Modal(document.getElementById('modal-email'));
            modal.show();
        }

        // Auto mostrar toast de sucesso
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast('Sucesso!', @json(session('success')), 'success');
            @endif
            
            @if(session('error'))
                showToast('Erro!', @json(session('error')), 'error');
            @endif
        });
    </script>
@endsection