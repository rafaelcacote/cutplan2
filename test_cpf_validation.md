# Teste de Validação de CPF

## Implementação realizada:

### 1. Regra de validação customizada (CpfRule)
- Valida o formato do CPF (11 dígitos)
- Verifica os dígitos verificadores
- Rejeita sequências inválidas (ex: 11111111111)
- Remove automaticamente caracteres não numéricos

### 2. Form Requests criados:
- **StoreUserRequest**: Para criação de usuários
- **UpdateUserRequest**: Para edição de usuários

### 3. Validações implementadas:
- **CPF único**: Não permite CPF duplicado no banco
- **CPF válido**: Valida algoritmo dos dígitos verificadores
- **Mensagens em português**: Todas as mensagens de erro em português
- **Exibição de erros**: Erros aparecem em vermelho abaixo dos inputs

### 4. Melhorias na interface:
- **Máscara de CPF**: Aplica automaticamente a formatação (000.000.000-00)
- **Formatação na listagem**: CPF exibido com pontos e traço
- **Validação visual**: Classes Bootstrap para indicar erros

## CPFs para teste:

### CPFs válidos para testar:
- 11144477735
- 12345678909
- 98765432100
- 04488146010

### CPFs inválidos para testar:
- 11111111111 (sequência)
- 12345678901 (dígito inválido)
- 123456789 (muito curto)
- 123456789012 (muito longo)

## Como testar:

1. Acesse a página de criar usuário
2. Tente inserir um CPF inválido
3. Tente inserir um CPF que já existe no banco
4. Veja as mensagens de erro aparecerem em vermelho abaixo do campo
5. Insira um CPF válido para ver a máscara funcionando

## Validações implementadas:

- ✅ CPF deve ser válido (algoritmo de dígitos verificadores)
- ✅ CPF deve ser único no banco de dados
- ✅ Nome é obrigatório
- ✅ Email é obrigatório e deve ser único
- ✅ Senha deve ter pelo menos 6 caracteres
- ✅ Confirmação de senha deve conferir
- ✅ Mensagens de erro em português
- ✅ Erros exibidos abaixo dos campos em vermelho
