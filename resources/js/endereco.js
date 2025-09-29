// Lógica de endereço reutilizável
class EnderecoHandler {
    constructor(uniqueId = '') {
        this.uniqueId = uniqueId;
        this.initializeToastCSS();
        this.initializeMasks();
        this.initializeViaCEP();
    }

    // CSS para o toast
    initializeToastCSS() {
        const toastCSS = `
            .custom-toast {
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #ff6b6b, #ee5a52);
                color: white;
                padding: 16px 24px;
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
                z-index: 9999;
                opacity: 0;
                transform: translateX(100%) scale(0.8);
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                max-width: 350px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .custom-toast.success {
                background: linear-gradient(135deg, #51cf66, #40c057);
                box-shadow: 0 8px 32px rgba(81, 207, 102, 0.3);
            }
            .custom-toast.show {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            .custom-toast .toast-header {
                display: flex;
                align-items: center;
                margin-bottom: 8px;
                font-weight: 600;
                font-size: 14px;
            }
            .custom-toast .toast-icon {
                width: 20px;
                height: 20px;
                margin-right: 10px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
            }
            .custom-toast .toast-body {
                font-size: 13px;
                line-height: 1.4;
                opacity: 0.95;
            }
            .custom-toast .toast-close {
                position: absolute;
                top: 8px;
                right: 10px;
                background: none;
                border: none;
                color: white;
                font-size: 18px;
                cursor: pointer;
                opacity: 0.7;
                transition: opacity 0.2s;
            }
            .custom-toast .toast-close:hover {
                opacity: 1;
            }
        `;

        // Adicionar CSS ao head se não existir
        if (!document.querySelector('#endereco-toast-css')) {
            const style = document.createElement('style');
            style.id = 'endereco-toast-css';
            style.textContent = toastCSS;
            document.head.appendChild(style);
        }
    }

    // Função para mostrar toast
    showToast(title, message, type = 'error') {
        // Remove toast anterior se existir
        const existingToast = document.querySelector('.custom-toast');
        if (existingToast) {
            existingToast.remove();
        }

        const toast = document.createElement('div');
        toast.className = `custom-toast ${type}`;

        const icon = type === 'error' ? '⚠️' : '✅';

        toast.innerHTML = `
            <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
            <div class="toast-header">
                <div class="toast-icon">${icon}</div>
                ${title}
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;

        document.body.appendChild(toast);

        // Mostrar toast com animação
        setTimeout(() => toast.classList.add('show'), 100);

        // Auto-remover após 5 segundos
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%) scale(0.8)';
                setTimeout(() => toast.remove(), 400);
            }
        }, 5000);
    }

    // Máscaras de entrada
    initializeMasks() {
        // Máscara CEP
        const cepInput = document.getElementById('cep_' + this.uniqueId);
        if (cepInput) {
            cepInput.addEventListener('input', function () {
                let value = this.value.replace(/\D/g, '');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
                this.value = value;
            });
        }
    }

    // Filtrar municípios pelo estado selecionado
    initializeMunicipioFilter(municipios, uniqueId = null) {
        const id = uniqueId || this.uniqueId;
        const estadoSelect = document.getElementById('estado_id_' + id);
        const municipioSelect = document.getElementById('municipio_id_' + id);

        if (!estadoSelect || !municipioSelect) return;

        // Valor antigo do município (caso erro de validação)
        const oldMunicipioId = municipioSelect.dataset.oldValue || "";

        const filtrarMunicipios = () => {
            const estadoId = estadoSelect.value;
            municipioSelect.innerHTML = '<option value="">Selecione o município</option>';
            if (estadoId && municipios[estadoId]) {
                municipios[estadoId].forEach(function (m) {
                    const selected = oldMunicipioId == m.id ? 'selected' : '';
                    municipioSelect.innerHTML += `<option value="${m.id}" ${selected}>${m.nome}</option>`;
                });
            }
        };

        estadoSelect.addEventListener('change', filtrarMunicipios);
        if (estadoSelect.value) filtrarMunicipios();
    }

    // Busca de endereço por CEP (usando ViaCEP)
    initializeViaCEP() {
        const cepInput = document.getElementById('cep_' + this.uniqueId);
        if (!cepInput) return;

        const buscarCep = (cepInput) => {
            const cep = cepInput.value.replace(/\D/g, '');
            if (cep.length === 8) {
                // Mostrar loading visual
                const originalBg = cepInput.style.backgroundColor;
                cepInput.style.backgroundColor = '#f8f9fa';
                cepInput.style.cursor = 'wait';

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        // Restaurar visual do campo
                        cepInput.style.backgroundColor = originalBg;
                        cepInput.style.cursor = '';

                        if (!data.erro) {
                            // CEP encontrado - preencher campos
                            const enderecoInput = document.getElementById('endereco_' + this.uniqueId);
                            const bairroInput = document.getElementById('bairro_' + this.uniqueId);

                            if (enderecoInput) enderecoInput.value = data.logradouro || '';
                            if (bairroInput) bairroInput.value = data.bairro || '';

                            // Estado e município
                            const estadoSelect = document.getElementById('estado_id_' + this.uniqueId);
                            const municipioSelect = document.getElementById('municipio_id_' + this.uniqueId);

                            if (estadoSelect) {
                                // Seleciona estado
                                for (let i = 0; i < estadoSelect.options.length; i++) {
                                    if (estadoSelect.options[i].text.includes(data.uf)) {
                                        estadoSelect.selectedIndex = i;
                                        estadoSelect.dispatchEvent(new Event('change'));
                                        break;
                                    }
                                }
                            }

                            // Seleciona município após carregar lista
                            if (municipioSelect) {
                                setTimeout(() => {
                                    for (let i = 0; i < municipioSelect.options.length; i++) {
                                        if (municipioSelect.options[i].text.trim() === data.localidade) {
                                            municipioSelect.selectedIndex = i;
                                            break;
                                        }
                                    }
                                }, 200);
                            }

                            // Foca no campo número
                            const numeroInput = document.getElementById('numero_' + this.uniqueId);
                            if (numeroInput) numeroInput.focus();

                            // Toast de sucesso
                            this.showToast('CEP Encontrado!', `Endereço preenchido automaticamente para ${data.localidade}/${data.uf}`, 'success');
                        } else {
                            // CEP não encontrado - mostrar toast de erro
                            this.showToast(
                                'CEP Não Encontrado',
                                `O CEP ${cep.replace(/(\d{5})(\d{3})/, '$1-$2')} não foi encontrado. Verifique o número digitado e tente novamente.`,
                                'error'
                            );
                            cepInput.focus();
                            cepInput.select();
                        }
                    })
                    .catch(error => {
                        // Erro de conexão
                        cepInput.style.backgroundColor = originalBg;
                        cepInput.style.cursor = '';
                        this.showToast(
                            'Erro de Conexão',
                            'Não foi possível consultar o CEP. Verifique sua conexão e tente novamente.',
                            'error'
                        );
                    });
            }
        };

        // Event listeners para CEP
        cepInput.addEventListener('blur', () => buscarCep(cepInput));

        // Buscar CEP ao pressionar Enter
        cepInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                buscarCep(cepInput);
            }
        });
    }
}

// Expor a classe globalmente
window.EnderecoHandler = EnderecoHandler;

// Manter compatibilidade com versão anterior (se necessário)
document.addEventListener('DOMContentLoaded', function () {
    // Só criar instância global se houver elementos com IDs antigos
    if (document.getElementById('cep')) {
        window.enderecoHandler = new EnderecoHandler('');

        // Inicializar filtro de municípios se houver dados disponíveis
        if (typeof window.municipios !== 'undefined') {
            window.enderecoHandler.initializeMunicipioFilter(window.municipios, '');
        }
    }
});

// Função global para facilitar uso
function initializeEnderecoHandler(municipios = null, uniqueId = '') {
    const handler = new EnderecoHandler(uniqueId);
    if (municipios) {
        handler.initializeMunicipioFilter(municipios, uniqueId);
    }
    return handler;
}