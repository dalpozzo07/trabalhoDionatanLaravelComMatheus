# Sistema de Gerenciamento de Produtos

Sistema web desenvolvido como projeto final da disciplina de desenvolvimento com Laravel. A aplicação foi criada com foco em **cadastro e gerenciamento de produtos**, autenticação de usuários e **controle de acesso baseado em três níveis de permissão**.

O projeto foi pensado para ser simples, organizado e funcional, demonstrando na prática os principais conceitos estudados durante o bimestre: MVC, migrations, seeders, rotas, Blade, CRUD, Eloquent, autenticação com Laravel Breeze, middleware, policies, Form Requests e controle de acesso.

---

##  Integrantes

- **Matheus** — desenvolvimento e implementação das funcionalidades realizadas nesta etapa do projeto.
- **Eduardo** — desenvolvimento da base inicial do sistema e funcionalidades que já estavam implementadas antes da etapa realizada neste chat.

> A divisão acima descreve a participação de cada integrante conforme o histórico de desenvolvimento do projeto. O repositório GitHub deve manter os commits de cada integrante para registrar a participação individual.

---

##  Sobre o projeto

O sistema permite gerenciar produtos cadastrados na aplicação e controlar o acesso às funcionalidades de acordo com o papel do usuário.

A aplicação possui três níveis de acesso:

| Papel | Permissões principais |
|---|---|
| **Administrador** | Visualizar, cadastrar, editar e excluir produtos; gerenciar usuários e alterar seus papéis |
| **Gerente** | Visualizar e editar produtos |
| **Cliente** | Visualizar produtos |

Além do CRUD de produtos, o sistema possui autenticação, validação de formulários, autorização por Policy, Middlewares específicos para controle de acesso e relacionamento entre usuários e produtos.

---

##  Tecnologias utilizadas

- **PHP 8.5+**
- **Laravel 13**
- **PostgreSQL**
- **Laravel Breeze** — autenticação
- **Blade** — views das funcionalidades principais
- **Vue.js 3 + Inertia.js** — interface de autenticação/dashboard e página inicial
- **Vite** — build dos arquivos frontend
- **Eloquent ORM** — acesso e relacionamento com o banco de dados
- **Git e GitHub** — versionamento do projeto

---

#  Requisitos do projeto

## 4.1 — Arquitetura MVC

O projeto utiliza a arquitetura **Model-View-Controller (MVC)**.

- **Models** representam as entidades e o acesso aos dados, como `User` e `Product`.
- **Controllers** controlam o fluxo das requisições, como `ProductController` e `UserController`.
- **Views** apresentam os dados ao usuário, utilizando principalmente Blade nas funcionalidades do sistema.

A lógica foi distribuída entre Models, Controllers, Requests, Policies, Middleware e Views, evitando concentrar o funcionamento do sistema em um único arquivo.

---

## 5 — Banco de dados e Migrations

O banco de dados utiliza **PostgreSQL** e é estruturado por meio das migrations do Laravel.

Entre as principais estruturas estão:

- `users`
- `products`
- `cache`
- `jobs`

A tabela `products` possui campos como:

- `id`
- `name`
- `description`
- `price`
- `stock`
- `is_active`
- `user_id`
- `created_at`
- `updated_at`

O campo `user_id` funciona como chave estrangeira para `users`, relacionando cada produto ao usuário responsável pelo cadastro.

O banco pode ser completamente recriado utilizando:

```bash
php artisan migrate:fresh --seed
```

Esse processo foi testado durante o desenvolvimento e reconstrói as tabelas e os dados iniciais corretamente.

---

## 6 — Seeders

O projeto possui Seeders para permitir a reconstrução do ambiente com dados de teste.

O `DatabaseSeeder` cria três usuários com diferentes papéis:

- Administrador
- Gerente
- Cliente

O `ProductSeeder` cria produtos de exemplo e os associa ao usuário administrador por meio do campo `user_id`.

Com isso, o comando abaixo reconstrói o banco e deixa o sistema pronto para testes:

```bash
php artisan migrate:fresh --seed
```

---

## 7 — Rotas

As funcionalidades são acessadas por rotas do Laravel organizadas em `routes/web.php` e `routes/auth.php`.

Principais rotas:

| Rota | Função |
|---|---|
| `/` | Página inicial do sistema |
| `/dashboard` | Dashboard protegido |
| `/products` | Lista de produtos |
| `/products/{product}` | Visualização de um produto |
| `/products/create` | Cadastro de produto — administrador |
| `/products/{product}/edit` | Edição de produto — administrador/gerente |
| `/users` | Gerenciamento de usuários — administrador |
| `/users/{user}/edit` | Edição do papel de um usuário — administrador |
| `/login` | Login |
| `/register` | Cadastro de usuário |
| `/profile` | Perfil do usuário autenticado |

As rotas protegidas utilizam `auth`, `admin` e `manager` conforme a funcionalidade.

---

## 8 — Views

As funcionalidades de gerenciamento utilizam **Blade**, incluindo:

- Listagem de produtos;
- Visualização individual de produtos;
- Formulário de cadastro;
- Formulário de edição;
- Mensagens de sucesso;
- Mensagens de erro/validação;
- Listagem de usuários;
- Formulário de alteração de papel do usuário;
- Links de navegação entre funcionalidades.

Foram utilizados recursos do Blade como:

```blade
{{ $product->name }}
```

```blade
@if(...)
    ...
@endif
```

```blade
@foreach(...)
    ...
@endforeach
```

A página inicial, autenticação e dashboard utilizam a camada Vue/Inertia do projeto Breeze, enquanto o gerenciamento principal de produtos e usuários utiliza Blade.

---

## 9 — CRUD de Produtos

A entidade principal do sistema é **Produto**, que possui CRUD completo.

### Create

O administrador pode cadastrar produtos informando:

- Nome;
- Descrição;
- Preço;
- Estoque;
- Status ativo/inativo.

### Read

Os usuários autenticados podem visualizar a lista de produtos e abrir a tela com os detalhes de um produto.

### Update

Administradores e gerentes podem editar os dados dos produtos.

### Delete

Somente administradores podem excluir produtos.

Fluxo principal:

```text
Produtos
├── Listar
├── Visualizar
├── Cadastrar
├── Editar
└── Excluir
```

---

## 10 — Relacionamento Eloquent

O projeto possui um relacionamento entre **usuários e produtos**.

Um usuário pode cadastrar vários produtos:

```text
User
  │
  └── hasMany()
          ↓
       Product
```

E cada produto pertence a um usuário:

```text
Product
   │
   └── belongsTo()
           ↓
         User
```

No model `User`:

```php
public function products()
{
    return $this->hasMany(Product::class);
}
```

No model `Product`:

```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

O relacionamento é armazenado no banco através da chave estrangeira `products.user_id`.

Durante o desenvolvimento, o relacionamento foi testado utilizando o Laravel Tinker, confirmando que o usuário administrador recupera os produtos associados e que cada produto referencia corretamente seu usuário.

---

## 11 — Autenticação com Laravel Breeze

A autenticação foi implementada utilizando **Laravel Breeze**.

O sistema permite:

- Criar uma conta;
- Fazer login;
- Fazer logout;
- Acessar páginas protegidas;
- Editar o perfil do usuário autenticado.

As áreas que precisam de autenticação são protegidas pelo middleware `auth`.

### Cadastro público

Novos usuários cadastrados pela tela de registro recebem automaticamente o papel:

```text
cliente
```

A alteração dos papéis administrativos fica restrita ao administrador através da área de gerenciamento de usuários.

---

## 12 — Três tipos de usuários

O campo `role` da tabela `users` define o nível de acesso de cada usuário.

Os três papéis utilizados são:

- `admin`
- `gerente`
- `cliente`

Esses papéis são utilizados efetivamente no controle das rotas e permissões do sistema.

---

## 13 — Middleware

Foram implementados Middlewares específicos para controle de acesso:

### `AdminMiddleware`

Permite o acesso somente a usuários cujo papel seja `admin`.

É utilizado nas funcionalidades administrativas, como:

- Cadastro de produtos;
- Exclusão de produtos;
- Gerenciamento de usuários.

### `ManagerMiddleware`

Permite o acesso a usuários `gerente` e `admin`.

É utilizado nas funcionalidades de edição de produtos.

Os Middlewares são registrados como aliases no `bootstrap/app.php` e aplicados diretamente às rotas.

---

## 14 — Policies

O projeto possui uma **ProductPolicy**, utilizada efetivamente para controlar ações sobre produtos.

As regras implementadas são:

- `admin` pode editar e excluir;
- `gerente` pode editar;
- `cliente` não pode editar nem excluir.

A Policy é utilizada no `ProductController` através de:

```php
Gate::authorize('update', $product);
```

E:

```php
Gate::authorize('delete', $product);
```

Assim, a autorização não depende apenas da interface: o servidor também verifica a permissão antes de executar a ação.

---

## 15 — Form Request

O projeto possui o Form Request:

```text
app/Http/Requests/StoreProductRequest.php
```

Ele é utilizado no cadastro de produtos para validar os dados recebidos.

Exemplos de regras:

```php
'name' => 'required|string|min:3|max:255',
'price' => 'required|numeric|min:0',
'stock' => 'required|integer|min:0',
```

Também são validados descrição e status do produto.

Quando os dados são inválidos, o formulário retorna os erros para a View e apresenta as mensagens ao usuário.

---

## 16 — Controle de acesso

As permissões foram definidas de forma diferente para os três papéis:

| Funcionalidade | Admin | Gerente | Cliente |
|---|:---:|:---:|:---:|
| Visualizar produtos | ✅ | ✅ | ✅ |
| Cadastrar produtos | ✅ | ❌ | ❌ |
| Editar produtos | ✅ | ✅ | ❌ |
| Excluir produtos | ✅ | ❌ | ❌ |
| Gerenciar usuários | ✅ | ❌ | ❌ |
| Alterar papel de usuário | ✅ | ❌ | ❌ |

Além da interface, as permissões são verificadas no backend através de Middleware e Policy.

---

# ⭐ Funcionalidades extras

Além dos requisitos mínimos, o projeto recebeu algumas funcionalidades adicionais para deixar o sistema mais completo e demonstrar melhor o controle de acesso.

## Gerenciamento de usuários

Foi criada uma área administrativa acessível somente por administradores.

Nela é possível:

- Visualizar todos os usuários cadastrados;
- Visualizar nome, e-mail e papel de cada usuário;
- Alterar o papel entre `admin`, `gerente` e `cliente`.

O fluxo ficou:

```text
Administrador
      ↓
Gerenciar usuários
      ↓
Selecionar usuário
      ↓
Alterar role
      ↓
Salvar alteração
```

O cadastro público realizado pelo Breeze não permite que o usuário escolha livremente seu próprio papel. Novos cadastros recebem `cliente`, evitando que um usuário comum se torne administrador pelo formulário de registro.

## Página inicial personalizada

A tela inicial padrão do Breeze/Laravel foi substituída por uma página própria do projeto, com identidade visual do sistema e acesso direto às opções de:

- Entrar;
- Criar conta.

## Navegação integrada

Foi adicionada navegação para facilitar o acesso às principais áreas do sistema, incluindo produtos e, quando permitido, gerenciamento de usuários.

---

#  Participação dos integrantes

## Matheus

As funcionalidades e alterações realizadas durante a etapa de desenvolvimento documentada neste projeto incluem:

- Configuração e correção do ambiente do projeto;
- Implementação e ajustes das migrations relacionadas ao sistema final;
- Estruturação e execução dos Seeders;
- Criação e configuração dos Middlewares de acesso;
- Registro dos aliases de Middleware;
- Implementação das regras de acesso para `admin`, `gerente` e `cliente`;
- Implementação e utilização da `ProductPolicy`;
- Ajustes do `ProductController` para autorização com `Gate`;
- Criação do CRUD completo de produtos nas Views e Controller;
- Criação das Views Blade de produtos:
  - listagem;
  - cadastro;
  - visualização;
  - edição;
- Implementação e validação do `StoreProductRequest`;
- Implementação do gerenciamento administrativo de usuários;
- Criação das Views de listagem e edição de usuários;
- Ajuste do cadastro público para novos usuários iniciarem como `cliente`;
- Criação do relacionamento `User hasMany Products`;
- Criação do relacionamento `Product belongsTo User`;
- Inclusão da chave estrangeira `user_id` em `products`;
- Ajuste do `ProductSeeder` para preencher `user_id`;
- Testes do relacionamento utilizando Laravel Tinker;
- Personalização da página inicial do sistema;
- Ajustes de navegação entre dashboard, produtos e usuários;
- Limpeza de funcionalidades que não eram utilizadas no escopo final, como a estrutura de carrinho/pedidos que não fazia parte da versão final do sistema.

## Eduardo

A base do projeto e as funcionalidades que já estavam implementadas antes da etapa documentada acima foram desenvolvidas por **Eduardo**.

Essas partes incluem a estrutura inicial do projeto Laravel, configuração/base da aplicação, recursos que já estavam presentes no código quando a etapa de desenvolvimento de Matheus foi iniciada e demais implementações já existentes no repositório.



---

# Instalação

## Requisitos

Antes de iniciar, é necessário ter instalado:

- PHP 8.5 ou superior;
- Composer;
- Node.js e npm;
- PostgreSQL;
- Git.

## 1. Clonar o projeto

```bash
git clone https://github.com/dalpozzo07/trabalhoDionatanLaravelComMatheus.git
cd trabalhoDionatanLaravelComMatheus
```

## 2. Instalar dependências PHP

```bash
composer install
```

## 3. Instalar dependências JavaScript

```bash
npm install
```

## 4. Configurar o ambiente

No Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Edite o `.env` e configure a conexão com o PostgreSQL, por exemplo:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

## 5. Gerar a chave da aplicação

```bash
php artisan key:generate
```

## 6. Criar as tabelas e dados iniciais

```bash
php artisan migrate:fresh --seed
```

Esse comando recria o banco inteiro e popula os usuários e produtos de teste.

## 7. Gerar os arquivos frontend

Para desenvolvimento:

```bash
npm run dev
```

Ou para gerar uma build:

```bash
npm run build
```

## 8. Iniciar o Laravel

Em outro terminal:

```bash
php artisan serve
```

Acesse:

```text
http://localhost:8000
```

---

#  Usuários para teste

Os seguintes usuários são criados pelos Seeders:

| Papel | E-mail | Senha |
|---|---|---|
| **Administrador** | `admin@email.com` | `12345A` |
| **Gerente** | `gerente@email.com` | `12345G` |
| **Cliente** | `cliente@email.com` | `12345C` |

### Sugestão para testes

**Administrador**

Teste:

- Login;
- Listagem de produtos;
- Cadastro;
- Edição;
- Exclusão;
- Gerenciamento de usuários;
- Alteração de roles.

**Gerente**

Teste:

- Login;
- Visualização de produtos;
- Edição de produtos;
- Tentativa de acessar funcionalidade exclusiva do administrador.

**Cliente**

Teste:

- Login;
- Visualização de produtos;
- Bloqueio de ações administrativas/de edição.

---

#  Estrutura principal

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProductController.php
│   │   └── UserController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── ManagerMiddleware.php
│   └── Requests/
│       └── StoreProductRequest.php
├── Models/
│   ├── Product.php
│   └── User.php
└── Policies/
    └── ProductPolicy.php

database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    └── ProductSeeder.php

resources/
├── js/
│   ├── Pages/
│   └── Layouts/
└── views/
    ├── products/
    └── users/

routes/
├── auth.php
└── web.php
```

---
