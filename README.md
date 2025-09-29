# 🏗️ CutPlan2 - Sistema de Planejamento e Orçamentos

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Templates-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

**Sistema completo de planejamento e orçamentos para projetos**

</div>

---

## 📋 Sobre o Projeto

O **CutPlan2** é um sistema completo de planejamento e orçamentos desenvolvido em Laravel, projetado para auxiliar na gestão de projetos, materiais, equipes e orçamentos de forma integrada e eficiente.

O sistema oferece uma solução robusta para empresas que precisam gerenciar múltiplos projetos, controlar custos, organizar equipes e gerar orçamentos detalhados de forma profissional.

### 💡 Principais Características

- **Gestão de Projetos**: Controle completo de projetos e seus itens
- **Orçamentos Inteligentes**: Sistema avançado de orçamentação com materiais e serviços
- **Gestão de Equipes**: Organização de membros, cargos e permissões
- **Controle de Materiais**: Catálogo completo com integração Promob
- **Multi-tenant**: Sistema preparado para múltiplos clientes
- **Relatórios Avançados**: Geração de relatórios e contratos em PDF

---

## 🛠️ Stack Tecnológica

### Backend
- **Laravel 12** - Framework PHP robusto e elegante
- **PHP 8.2+** - Linguagem de programação moderna
- **MySQL 8.0+** - Banco de dados relacional confiável

### Frontend
- **Blade Templates** - Sistema de templates nativo do Laravel
- **Tabler UI** - Interface moderna e responsiva
- **Tailwind CSS** - Framework CSS utilitário
- **Vite** - Build tool rápido e moderno

### Funcionalidades Específicas
- **Gestão de Clientes e Fornecedores** - Cadastro completo com endereços
- **Sistema de Projetos** - Criação e acompanhamento de projetos
- **Orçamentos Detalhados** - Criação de orçamentos com materiais e serviços
- **Integração Promob** - Importação de dados XML do Promob
- **Contratos Automáticos** - Geração de contratos em PDF
- **Sistema Multi-tenant** - Suporte a múltiplas empresas
- **Validação de CPF/CNPJ** - Regras customizadas para documentos brasileiros
- **Spatie/Permission** - Sistema completo de permissões e roles
- **Testes Automatizados** - PHPUnit configurado

---

## 🚀 Instalação e Configuração

### Pré-requisitos

Certifique-se de ter instalado em sua máquina:
- PHP 8.2 ou superior
- Composer
- Node.js e NPM
- MySQL 8.0 ou superior
- Git

### Passo a Passo

1. **Clone o repositório**
```bash
git clone https://github.com/seu-usuario/cutplan2.git
cd cutplan2
```

2. **Instale as dependências do PHP**
```bash
composer update
```

3. **Instale as dependências do Node.js**
```bash
npm install
```

4. **Configure o arquivo de ambiente**
```bash
cp .env.example .env
```

5. **Gere a chave da aplicação**
```bash
php artisan key:generate
```

6. **Configure o banco de dados**
Edite o arquivo `.env` com suas credenciais do MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cutplan2
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

7. **Execute as migrações**
```bash
php artisan migrate
```

8. **Popule o banco com dados iniciais**
```bash
php artisan db:seed
```

9. **Compile os assets**
```bash
npm run build
```

10. **Inicie o servidor de desenvolvimento**
```bash
php artisan serve
```

🎉 **Pronto!** Acesse `http://localhost:8000` e comece a usar sua aplicação.

---

## 📁 Estrutura do Projeto

```
cutplan2/
├── app/
│   ├── Http/Controllers/     # Controladores (Clientes, Projetos, Orçamentos, etc.)
│   ├── Models/              # Modelos (Cliente, Projeto, Material, Orçamento, etc.)
│   ├── Rules/               # Regras de validação (CPF, CNPJ)
│   ├── Services/            # Serviços (Importação Promob, etc.)
│   └── Providers/           # Provedores de serviços
├── database/
│   ├── migrations/          # Migrações do banco de dados
│   ├── seeders/            # Seeders (Estados, Municípios, Tipos, etc.)
│   └── factories/          # Factories para testes
├── resources/
│   ├── views/              # Templates Blade organizados por módulo
│   ├── css/                # Estilos CSS customizados
│   ├── js/                 # JavaScript (endereços, etc.)
│   └── templates/          # Templates de contratos
├── routes/
│   ├── web.php             # Rotas principais do sistema
│   └── auth.php            # Rotas de autenticação
└── tests/                  # Testes automatizados
```

---

## 🔐 Sistema de Permissões

O projeto inclui um sistema completo de permissões usando **Spatie/Permission**:

### Funcionalidades
- ✅ **Roles (Papéis)**: Agrupe permissões por função
- ✅ **Permissions (Permissões)**: Controle granular de acesso
- ✅ **Middleware**: Proteção de rotas automática
- ✅ **Interface Administrativa**: Gerencie permissões via web

### Uso Básico
```php
// Verificar permissão
if (auth()->user()->can('edit users')) {
    // Usuário pode editar usuários
}

// Verificar role
if (auth()->user()->hasRole('admin')) {
    // Usuário é administrador
}
```

---

## 🎨 Interface (Tabler UI)

O projeto utiliza o **Tabler UI**, um template moderno e responsivo que oferece:

- 📱 **Design Responsivo**: Funciona perfeitamente em todos os dispositivos
- 🎨 **Componentes Ricos**: Botões, formulários, tabelas e muito mais
- 📊 **Dashboard Moderno**: Interface administrativa profissional
- ⚡ **Performance**: Carregamento rápido e otimizado

---

## 🧪 Testes

Execute os testes automatizados:

```bash
# Todos os testes
php artisan test

# Testes específicos
php artisan test --filter=ExampleTest
```

---

## 🤝 Contribuindo

Contribuições são sempre bem-vindas! Para contribuir:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## 👨‍💻 Autor

**Rafael Barbosa**
- GitHub: [@rafaelcacote](https://github.com/rafaelcacote)
- LinkedIn: [Rafael Barbosa](https://linkedin.com/in/rafaelcacote)

---

## 💝 Agradecimentos

- À comunidade Laravel por criar um framework incrível
- Ao time do Spatie pelos pacotes fantásticos
- À equipe do Tabler UI pelo template elegante
- A todos os desenvolvedores que contribuem para o ecossistema open source

---

<div align="center">

**⭐ Se este projeto te ajudou, não esqueça de dar uma estrela!**

**🚀 Bora codar juntos e fazer a diferença na comunidade!**

</div>
