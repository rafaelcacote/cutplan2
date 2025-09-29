# Sistema de Orçamentos - CutPlan2

## Visão Geral

O sistema de orçamentos foi desenvolvido para proporcionar uma experiência intuitiva e eficiente na criação e gestão de orçamentos. O sistema segue uma abordagem em etapas que guia o usuário através do processo de criação.

## Funcionalidades Implementadas

### 🎯 **Fluxo de Criação Otimizado**

#### **Etapa 1: Dados Básicos**
- Seleção obrigatória do cliente
- Definição da data de validade (opcional)
- Configuração de desconto em reais
- Campo de observações gerais

#### **Etapa 2: Montagem dos Itens**
- **Adicionar por Serviço**: Permite selecionar um serviço e incluir seus itens pré-cadastrados
- **Item Manual**: Criação de itens personalizados diretamente no orçamento
- **Cálculo Automático**: Todos os totais são calculados em tempo real
- **Resumo Visual**: Card com subtotal, desconto, total de itens e valor final

### 📊 **Recursos de Gestão**

#### **Listagem Inteligente**
- Filtros por cliente, status, data de criação
- Paginação otimizada
- Cards informativos para cada orçamento
- Badges coloridos para status

#### **Visualização Completa**
- Layout em duas colunas
- Informações detalhadas do cliente (incluindo endereço)
- Lista completa de itens com origem (serviço ou manual)
- Resumo financeiro destacado
- Alteração de status via dropdown

#### **Edição Flexível**
- Manutenção de todos os itens existentes
- Possibilidade de adicionar novos itens
- Alteração de status do orçamento
- Recálculo automático dos totais

### 🔧 **Tecnologias e Padrões**

#### **Backend (Laravel)**
- **Models**: Relacionamentos bem definidos entre Orçamento, ItemOrcamento, Cliente, Serviço, etc.
- **Controllers**: Seguindo padrão Resource com métodos RESTful
- **Requests**: Validação robusta com mensagens customizadas
- **Observers**: Cálculo automático de totais através de eventos do modelo

#### **Frontend**
- **Views Blade**: Estrutura modular e reutilizável
- **JavaScript Vanilla**: Interatividade sem dependências externas
- **Bootstrap + Tabler**: Interface moderna e responsiva
- **AJAX**: Carregamento dinâmico de serviços e itens

#### **API Endpoints**
- `GET /orcamentos/api/servicos` - Lista serviços ativos
- `GET /orcamentos/servicos/{id}/itens` - Itens de um serviço específico
- `GET /orcamentos/api/unidades` - Lista unidades disponíveis
- `POST /orcamentos/{id}/status` - Atualização de status via AJAX

## 🚀 **Como Usar**

### **Criando um Novo Orçamento**

1. **Acesse** o menu "Orçamentos" → "Novo Orçamento"

2. **Etapa 1 - Dados Básicos:**
   - Selecione o cliente (obrigatório)
   - Defina validade se necessário
   - Configure desconto se aplicável
   - Adicione observações gerais
   - Clique em "Continuar para Itens"

3. **Etapa 2 - Adicionando Itens:**
   
   **Para itens de serviço:**
   - Clique em "Adicionar Serviço"
   - Selecione o serviço desejado
   - Marque os itens que deseja incluir
   - Ajuste quantidades, unidades e preços
   - Clique em "Adicionar Itens Selecionados"
   
   **Para itens manuais:**
   - Clique em "Item Manual"
   - Preencha descrição, quantidade e preço
   - Selecione unidade se necessário
   - Clique em "Adicionar Item"

4. **Finalize** clicando em "Salvar Orçamento"

### **Gerenciando Orçamentos**

#### **Status Disponíveis:**
- **Rascunho**: Orçamento em elaboração
- **Enviado**: Orçamento enviado ao cliente
- **Aprovado**: Cliente aprovou o orçamento
- **Rejeitado**: Cliente rejeitou o orçamento
- **Expirado**: Orçamento passou da validade

#### **Alterando Status:**
- Na visualização, use o dropdown "Alterar Status"
- Na listagem, edite o orçamento para alterar status

#### **Filtrando Orçamentos:**
- Use os filtros por cliente, status ou período
- Combine múltiplos filtros para busca específica

## 📋 **Estrutura de Dados**

### **Tabela `orcamentos`**
- `cliente_id`: Referência ao cliente
- `status`: Status atual (draft, sent, approved, rejected, expired)
- `subtotal`, `desconto`, `total`: Valores financeiros
- `validade`: Data limite de validade
- `user_id`: Usuário que criou o orçamento
- `observacoes`: Observações gerais

### **Tabela `itens_orcamento`**
- `orcamento_id`: Referência ao orçamento
- `descricao`: Descrição do item
- `quantidade`, `preco_unitario`, `total`: Dados do item
- `unidade_id`: Unidade de medida (opcional)
- `item_servico_id`: Referência ao item de serviço (se aplicável)

## 🎨 **Interface do Usuário**

### **Design Responsivo**
- Funciona perfeitamente em desktop, tablet e mobile
- Cards expansivos que se adaptam ao conteúdo
- Navegação intuitiva com breadcrumbs

### **Feedback Visual**
- Toasts informativos para ações realizadas
- Loading states durante carregamento de dados
- Badges coloridos para status
- Validação em tempo real

### **Experiência do Usuário**
- Fluxo em etapas reduz complexidade
- Cálculos automáticos evitam erros
- Confirmações para ações destrutivas
- Estados vazios com orientações claras

## 🔐 **Segurança e Validação**

### **Validações Backend**
- Cliente obrigatório e existente
- Quantidades e preços positivos
- Datas de validade futuras para novos orçamentos
- Sanitização de todos os inputs

### **Validações Frontend**
- Campos obrigatórios destacados
- Validação em tempo real
- Prevenção de submissão com dados inválidos

## 📈 **Próximas Melhorias Sugeridas**

### **Funcionalidades**
- [ ] Geração de PDF dos orçamentos
- [ ] Sistema de aprovação por email
- [ ] Histórico de alterações
- [ ] Duplicação de orçamentos
- [ ] Templates de orçamento
- [ ] Integração com sistema de estoque

### **Relatórios**
- [ ] Dashboard com métricas de orçamentos
- [ ] Relatório de conversão (enviado → aprovado)
- [ ] Análise de itens mais vendidos
- [ ] Relatório financeiro por período

### **Integrações**
- [ ] API para sistemas externos
- [ ] Webhooks para eventos de status
- [ ] Sincronização com sistemas de pagamento

## 🛠️ **Manutenção**

### **Logs e Monitoramento**
- Todos os eventos importantes são logados
- Erros de validação são registrados
- Performance de queries otimizada

### **Backup de Dados**
- Soft deletes implementados para segurança
- Relacionamentos preservados
- Histórico de alterações mantido

---

**Desenvolvido seguindo as melhores práticas do Laravel e princípios de UX/UI moderno.**
