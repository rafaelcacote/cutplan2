# Sistema de Importação de Materiais do Promob

## Visão Geral
Esta funcionalidade permite importar automaticamente materiais de um arquivo XML gerado pelo Promob para os itens de projeto no sistema CutPlan2.

## Como Funciona

### 1. Estrutura do Sistema
- **MaterialItemProjeto**: Modelo que armazena os materiais associados a cada item de projeto
- **PromobImportService**: Serviço responsável por processar o XML e importar os materiais
- **PromobImportController**: Controller que gerencia as rotas de upload e importação

### 2. Fluxo de Importação

1. **Acesso à Funcionalidade**: 
   - Na página de detalhes do projeto, clique no botão "Importar Materiais do Promob" ao lado de cada item

2. **Upload do XML**:
   - Selecione o arquivo XML gerado pelo Promob
   - Clique em "Visualizar Materiais" para ver uma prévia dos materiais

3. **Preview**:
   - O sistema mostra quais materiais serão importados
   - Indica se encontrou materiais correspondentes já cadastrados no sistema
   - Mostra o total de materiais a serem importados

4. **Importação**:
   - Clique em "Importar Materiais"
   - Confirme a importação no modal
   - O sistema irá:
     - Remover materiais importados anteriormente do mesmo item
     - Importar os novos materiais do XML
     - Tentar vincular automaticamente aos materiais cadastrados

### 3. Estrutura do XML Esperada

```xml
<?xml version="1.0" encoding="UTF-8"?>
<PromobExport>
    <Informacoes>
        <DataGeracao>2025-09-25</DataGeracao>
        <VersaoPromob>5.68.2.5</VersaoPromob>
    </Informacoes>
    <Materiais>
        <Material>
            <Codigo>MAD001</Codigo>
            <Descricao>MDF 15mm Branco</Descricao>
            <Unidade>M2</Unidade>
            <Quantidade>2.50</Quantidade>
            <Dimensoes>
                <Largura>1220</Largura>
                <Altura>2750</Altura>
                <Profundidade>15</Profundidade>
            </Dimensoes>
            <Familia>MDF</Familia>
            <Grupo>Paineis</Grupo>
        </Material>
        <!-- Mais materiais... -->
    </Materiais>
</PromobExport>
```

### 4. Funcionalidades Adicionais

#### Vinculação de Materiais
- O sistema tenta automaticamente vincular materiais importados aos materiais já cadastrados
- Busca por nome/descrição similar
- Pode-se vincular ou desvincular materiais manualmente

#### Gerenciamento de Materiais Importados
- **Visualizar**: Lista todos os materiais importados com status de vinculação
- **Vincular**: Associa um material importado a um material cadastrado
- **Desvincular**: Remove a associação entre material importado e cadastrado
- **Remover**: Remove um material específico da lista
- **Limpar Importação**: Remove todos os materiais importados do item

### 5. Campos Armazenados

Para cada material importado, o sistema armazena:
- **Descrição**: Nome/descrição do material
- **Código Promob**: Código original do material no Promob
- **Quantidade**: Quantidade necessária
- **Unidade**: Unidade de medida
- **Dimensões**: Largura, altura, profundidade (quando disponível)
- **Família e Grupo**: Categorização do material
- **Material Vinculado**: Referência ao material cadastrado no sistema (se encontrado)
- **Origem**: Identifica se foi importado ou adicionado manualmente

### 6. Rotas Disponíveis

```php
// Página de importação
GET /projetos/itens/{item_projeto}/promob/import

// Preview da importação
POST /projetos/itens/{item_projeto}/promob/preview

// Executar importação
POST /projetos/itens/{item_projeto}/promob/import

// Listar materiais importados
GET /projetos/itens/{item_projeto}/promob/materiais

// Vincular material
PUT /projetos/itens/{item_projeto}/promob/materiais/{material}/vincular

// Desvincular material
DELETE /projetos/itens/{item_projeto}/promob/materiais/{material}/desvincular

// Remover material específico
DELETE /projetos/itens/{item_projeto}/promob/materiais/{material}

// Limpar toda importação
DELETE /projetos/itens/{item_projeto}/promob/limpar
```

### 7. Exemplo de Uso

1. No Promob, gere o XML com a lista de materiais do projeto
2. Acesse o projeto no CutPlan2
3. Para cada item que deseja importar materiais, clique no botão verde de importação
4. Faça upload do arquivo XML
5. Visualize os materiais que serão importados
6. Confirme a importação
7. Revise os materiais importados e faça vinculações manuais se necessário

### 8. Observações Importantes

- **Backup Automático**: Materiais importados anteriormente são substituídos a cada nova importação
- **Materiais Manuais**: Materiais adicionados manualmente não são afetados pela importação
- **Vinculação Inteligente**: O sistema usa algoritmos de busca para encontrar materiais correspondentes
- **Flexibilidade**: Suporta diferentes estruturas de XML do Promob (adaptável)
- **Logs**: Todas as operações são registradas para auditoria

### 9. Solução de Problemas

- **XML Inválido**: Verifique se o arquivo está no formato correto
- **Materiais Não Encontrados**: Use a função de vinculação manual
- **Erro na Importação**: Verifique os logs do sistema para detalhes
- **Performance**: Para grandes quantidades de materiais, a importação pode levar alguns segundos

Esta funcionalidade automatiza significativamente o processo de cadastro de materiais, reduzindo erros manuais e economizando tempo na gestão de projetos.