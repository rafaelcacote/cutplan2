# 🚀 Projeto Base Laravel

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Templates-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

**Um projeto Laravel completo e pronto para uso com sistema de permissões robusto**

</div>

---

## 📋 Sobre o Projeto

Este é um **projeto base Laravel** desenvolvido com muito carinho para a comunidade de desenvolvedores. Meu objetivo é fornecer uma base sólida e bem estruturada que possa ser utilizada como ponto de partida para diversos tipos de aplicações web.

O projeto foi criado pensando em **economizar tempo** e **facilitar o desenvolvimento** de novas aplicações, oferecendo uma estrutura robusta com as melhores práticas do mercado já implementadas.

### 💡 Por que este projeto existe?

- **Para a comunidade**: Acredito no poder do código aberto e na importância de compartilhar conhecimento
- **Acelerar desenvolvimento**: Evite recriar a roda em cada novo projeto
- **Boas práticas**: Estrutura já validada e testada em projetos reais
- **Aprendizado**: Código limpo e bem documentado para estudos

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

### Funcionalidades
- **Spatie/Permission** - Sistema completo de permissões e roles
- **Sistema de Autenticação** - Login, registro e recuperação de senha
- **Dashboard Responsivo** - Interface administrativa moderna
- **Validação de CPF** - Regra customizada para validação
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
git clone https://github.com/rafaelcacote/projeto-base.git
cd projeto-base
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
DB_DATABASE=seu_banco_de_dados
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
projeto-base/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   ├── Rules/               # Regras de validação customizadas
│   └── Providers/           # Provedores de serviços
├── database/
│   ├── migrations/          # Migrações do banco
│   ├── seeders/            # Seeders para popular dados
│   └── factories/          # Factories para testes
├── resources/
│   ├── views/              # Templates Blade
│   ├── css/                # Estilos CSS
│   └── js/                 # JavaScript
├── routes/
│   ├── web.php             # Rotas web
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
