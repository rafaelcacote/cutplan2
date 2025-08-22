# Guia para Criação de CRUDs no Projeto

Este documento serve como um guia para a criação de novas funcionalidades de CRUD (Create, Read, Update, Delete) no sistema, garantindo consistência visual e de código. O CRUD de **Clientes** é a nossa referência principal.

## 1. Estrutura do Controller

O controller deve seguir o padrão de resource do Laravel, contendo os seguintes métodos:

-   **`index(Request $request)`**:
    -   Responsável pela listagem e filtragem dos registros.
    -   Utilizar paginação (ex: `$query->paginate(10)`).
    -   Implementar filtros de busca que são aplicados à query.
    -   Manter os parâmetros de busca na paginação com `$items->appends($request->query())`.

-   **`create()`**:
    -   Apenas retorna a view de criação.
    -   Se necessário, carrega dados para selects (ex: `Estado::all()`).
    -   Para selects dependentes (como Municípios por Estado), carregar todos os dados e agrupar, para que o JavaScript no frontend possa filtrá-los.

-   **`store(StoreRequest $request)`**:
    -   Utilizar uma classe de `FormRequest` (ex: `StoreClienteRequest`) para validação.
    -   Criar os registros no banco de dados.
    -   Se houver relacionamentos (como Endereço), criar o registro relacionado primeiro.
    -   Redirecionar para a `index` com uma mensagem de sucesso na sessão: `->with('success', 'Item criado com sucesso!')`.

-   **`show(Model $model)`**:
    -   Retorna a view de visualização com os dados do modelo.

-   **`edit(Model $model)`**:
    -   Retorna a view de edição, passando o modelo e dados para selects.

-   **`update(UpdateRequest $request, Model $model)`**:
    -   Utilizar uma classe de `FormRequest` (ex: `UpdateClienteRequest`) para validação.
    -   Atualizar o registro principal e seus relacionamentos.
    -   Redirecionar para a `index` com uma mensagem de sucesso: `->with('success', 'Item atualizado com sucesso!')`.

-   **`destroy(Model $model)`**:
    -   Excluir o registro.
    -   Redirecionar para a `index` com uma mensagem de sucesso: `->with('success', 'Item excluído com sucesso!')`.

---

## 2. Estrutura das Views (Blade)

Todas as views devem estender o layout principal `@extends('layouts.app')`.

### 2.1. `index.blade.php` (Página de Listagem)

-   **Cabeçalho (`page-header`)**:
    -   Título da página com um ícone do Font Awesome.
    -   Botão "Novo Item" (`btn-primary`) no canto direito.

-   **Corpo (`page-body`)**:
    -   **Toast de Notificação**: Incluir `@include('components.toast')` e o script para dispará-lo com base na sessão `success`.
    -   **Card de Filtros**: Um `<div class="card">` contendo o formulário de pesquisa com os campos de filtro.
        -   Botão "Pesquisar" (`btn-primary`) e "Limpar" (`btn-outline-secondary`).
    -   **Card da Tabela**:
        -   Título "Lista de Itens" e contador de registros.
        -   Tabela responsiva (`<div class="table-responsive">`).
        -   Usar a classe `table-vcenter card-table` para alinhamento vertical.
        -   **Ações da Tabela**: Na última coluna, incluir um grupo de botões (`btn-list flex-nowrap`) para:
            -   **Visualizar**: `<a href="..." class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye"></i></a>`
            -   **Editar**: `<a href="..." class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen"></i></a>`
            -   **Excluir**: `<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-excluir-{{ $item->id }}">...</button>`
        -   **Modal de Exclusão**: Para cada item, criar um modal de confirmação.
            -   Usar as classes `modal modal-blur fade`.
            -   O formulário de exclusão (`method('DELETE')`) deve estar dentro do modal.
    -   **Paginação**: No rodapé do card (`card-footer`), renderizar os links de paginação: `{{ $items->links() }}`.
    -   **Estado Vazio**: Usar `@forelse` e na seção `@empty`, mostrar uma mensagem amigável com uma imagem e um botão para criar o primeiro item.

### 2.2. `create.blade.php` e `edit.blade.php` (Formulários)

-   **Cabeçalho (`page-header`)**:
    -   Título da página (ex: "Novo Item" ou "Editar Item") com ícone.
    -   Link de "Voltar" para a `index` (`btn-outline-secondary`).

-   **Corpo (`page-body`)**:
    -   O formulário deve estar dentro de um `<div class="card">`.
    -   **Campos do Formulário**:
        -   Organizar os campos usando o sistema de grid do Bootstrap (`<div class="row">` e `<div class="col-lg-...">`).
        -   Para campos obrigatórios, adicionar a classe `required` na `<label>`.
        -   Exibir erros de validação abaixo de cada campo usando a diretiva `@error('nome_do_campo')`.
        -   Usar `input-group` para adicionar ícones aos campos.
    -   **Rodapé do Card (`card-footer`)**:
        -   Botão "Voltar" (`btn-outline-secondary`) alinhado à esquerda.
        -   Botão "Salvar" (`btn-primary ms-auto`) alinhado à direita.

### 2.3. `show.blade.php` (Página de Visualização)

-   **Layout**: Geralmente dividido em duas colunas (`col-lg-4` e `col-lg-8`).
-   **Coluna Esquerda**:
    -   Card de perfil com avatar, nome e informações principais.
    -   Card de "Informações do Sistema" (cadastrado por, data de cadastro, etc.).
-   **Coluna Direita**:
    -   Cards agrupando informações (ex: "Dados Pessoais", "Endereço").
    -   Usar a classe `form-control-plaintext` para exibir os dados, dentro de uma estrutura de `label` e `div`.

---

## 3. JavaScript e Componentes

-   **Toast de Notificação**:
    -   O componente `components.toast` deve ser incluído nas views `index`, `create` e `edit`.
    -   O script para exibir o toast com a mensagem de sucesso da sessão deve ser adicionado na view `index`.
    -   Um script de toast customizado (com CSS e JS) está disponível nos formulários para interações como a busca de CEP.

-   **Máscaras de Input**:
    -   Usar JavaScript para aplicar máscaras a campos como Telefone, CPF e CEP. O código de exemplo está em `clientes/create.blade.php`.

-   **Busca de Endereço por CEP**:
    -   Utilizar a API do ViaCEP (`https://viacep.com.br`).
    -   O script deve ser acionado no `blur` ou ao pressionar `Enter` no campo CEP.
    -   Ele deve preencher automaticamente os campos de endereço, estado e município.
    -   Deve fornecer feedback ao usuário com toasts de sucesso ou erro.

-   **Selects Dependentes (Estado/Município)**:
    -   Carregar todos os municípios no controller, agrupados por `estado_id`.
    -   Passar essa coleção para a view via JSON (`@json($municipios)`).
    -   No JavaScript, adicionar um listener ao `change` do select de estado para popular o select de município dinamicamente.

---

## 4. Rotas

Utilize rotas de recurso no arquivo `routes/web.php` para definir todas as rotas do CRUD de uma vez:

```php
Route::resource('nome-do-recurso', NomeDoController::class);
```
