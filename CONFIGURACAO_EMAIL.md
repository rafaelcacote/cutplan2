# 📧 Configuração de Email para Orçamentos

## ⚙️ Configurações Necessárias

### 1. Editar o arquivo `.env`

Substitua as configurações de email no arquivo `.env` com as informações da sua empresa:

```env
# Configurações de Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com        # Para Gmail
MAIL_PORT=587                   # Porta TLS
MAIL_USERNAME=email@empresa.com # Seu email
MAIL_PASSWORD=senha-de-app      # Senha de app (não a senha comum)
MAIL_ENCRYPTION=tls            # Tipo de criptografia
MAIL_FROM_ADDRESS="email@empresa.com"
MAIL_FROM_NAME="Nome da Empresa"
```

### 2. Provedores de Email Comuns

#### 📨 Gmail
```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

#### 🔷 Outlook/Hotmail
```env
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

#### 📧 Yahoo
```env
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

#### 🏢 Servidor SMTP Personalizado
```env
MAIL_HOST=mail.suaempresa.com
MAIL_PORT=587              # ou 465 para SSL
MAIL_ENCRYPTION=tls        # ou ssl
```

### 3. ⚠️ Configuração de Senha para Gmail

Se usar Gmail, você precisa:

1. **Ativar autenticação de 2 fatores** na conta
2. **Gerar uma senha de app** específica:
   - Acesse: [Google Account Settings](https://myaccount.google.com/)
   - Vá em "Segurança" > "Senhas de app"
   - Gere uma senha específica para "Mail"
   - Use essa senha no `.env`, não a senha normal

### 4. 🔧 Como Configurar

1. **Edite o arquivo `.env`** com suas credenciais
2. **Limpe o cache de configuração:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```
3. **Teste o envio** criando um orçamento

### 5. ✅ Exemplo Completo para Gmail

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=contato@minhaempresa.com
MAIL_PASSWORD=abcd1234efgh5678  # Senha de app gerada
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="contato@minhaempresa.com"
MAIL_FROM_NAME="Minha Empresa Ltda"
```

### 6. 🎯 Como Funciona

- **Remetente:** Email configurado em `MAIL_FROM_ADDRESS`
- **Destinatário:** Email do cliente cadastrado no orçamento
- **Anexo:** PDF do orçamento é gerado e anexado automaticamente
- **Conteúdo:** Template profissional com informações do orçamento

### 7. 🔍 Teste de Configuração

Após configurar, você pode testar:

1. Crie um orçamento
2. Clique em "Enviar por Email"
3. Verifique se o email foi enviado
4. Se houver erro, verifique os logs em `storage/logs/laravel.log`

### 8. 🚨 Solução de Problemas

**Erro de autenticação:**
- Verifique se a senha de app está correta
- Confirme que a autenticação de 2 fatores está ativa

**Erro de conexão:**
- Verifique o host e porta SMTP
- Confirme se o firewall permite conexões SMTP

**Email não chega:**
- Verifique a pasta de spam
- Confirme se o email do cliente está correto

### 9. 🛡️ Segurança

- **Nunca** commite o arquivo `.env` com credenciais reais
- Use senhas de app específicas, não senhas principais
- Mantenha as credenciais seguras e atualizadas

## ✨ Pronto!

Após essa configuração, o sistema irá:
- Enviar emails profissionais com o PDF anexado
- Usar o email da empresa como remetente
- Entregar no email do cliente cadastrado
- Atualizar o status do orçamento para "Enviado"