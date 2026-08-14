# 📈 Sistema de Gestão de Investimentos

Este sistema foi projetado para ajudar usuários a gerenciar seus investimentos, acompanhar rendimentos, monitorar metas financeiras e receber alertas personalizados. Com suporte à estruturação de carteiras de ativos e análises detalhadas, o sistema oferece funcionalidades completas para investidores de diferentes perfis.

---mysql

## 🧱 Arquitetura

O backend é desenvolvido em **Laravel**, seguindo os princípios da **Arquitetura DDD (Domain-Driven Design)**. Toda a comunicação com o sistema é feita via **API REST**, separando completamente backend e frontend.

### 🗂️ Estrutura de Diretórios (DDD)

app/
├── Application/  
│ └── Services/  
│
├── Domain/  
│ ├── Entities/  
│ ├── Repositories/  
│ └── Services/  
│
├── Infrastructure/  
│ └── Persistence/  
│ └── Models/  
│
├── Http/  
│ ├── Controllers/
│ │ └── API/  
│ └── Requests/  
│
├── Providers/  
│
└── Exceptions/

---

## ⚙️ Funcionalidades Principais

-   Cadastro e login de usuários
-   Criação e gerenciamento de carteiras de investimento
-   Controle de ativos (ações, ETFs, FIIs, tesouro, etc.)
-   Registro de transações e dividendos
-   Estabelecimento de metas financeiras
-   Geração de alertas personalizados
-   Relatórios periódicos
-   Perfil de investidor e recomendações personalizadas

---

## 🔐 Configuração de Autenticação JWT

Este projeto utiliza o pacote **tymon/jwt-auth** para implementar autenticação via JWT (JSON Web Tokens), garantindo segurança e controle de acesso nas APIs.

### Passos para configurar o JWT no projeto:

1. **Instalação do pacote**

```bash
composer require tymon/jwt-auth
```
2. **Publicar arquivo de configuração**

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
3. **Gerar a chave secreta JWT**

```bash
php artisan jwt:secret
```
Este comando cria a chave JWT_SECRET no arquivo .env.

4. **Publicar arquivo de configuração**

No arquivo config/auth.php, ajuste o guard api para usar o driver jwt:
```bash
'guards' => [
    // ...
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
        'hash' => false,
    ],
],
```

---

## 🧑‍💼 Entidades Principais

### 1. Usuário

-   `email`, `senha`, `nome`, `saldo`, `idade`, `perfil_investidor`
-   Possui uma carteira e vários alertas

### 2. Carteira

-   Consolidado de ativos por tipo

-   Campos: `id`, `usuario_id`, `nome`, `descricao`, `created_at`, `updated_at`

-   Exemplo de nome: Aposentadoria, Crescimento, Renda Passiva

-   Relacionamentos: ligada a usuário, ativos, metas, rendimentos, alertas e relatórios

### 3. Ativo

-   id, carteira_id, categoria_id, nome, tipo, quantidade, preco, preco_medio, valor
-   Relacionamentos: pertence a uma carteira e a uma categoria, possui transações e dividendos

### 4. Transação

-   Tipo (compra, venda, ajuste), quantidade, valor, data

### 5. Dividendo

-   Data e valor recebido

### 6. Meta

-   Nome, descrição, valor-alvo, data limite

### 7. Alerta

-   Tipo (dividendo, preço, meta), mensagem, data

### 8. Categoria

-   Nome e descrição (ex.: Renda Fixa, Renda Variável)

### 9. Rendimento

-   Tipo (dividendo, valorização), valor, período

### 10. Relatório

-   Tipo (mensal, anual), data de geração

---

## 🗄️ Tabelas do Banco (Resumo)

### Usuario

| Campo             | Tipo     | Descrição                        |
| ----------------- | -------- | -------------------------------- |
| id                | INT (PK) | Identificador único              |
| email             | VARCHAR  | E-mail de login                  |
| senha             | VARCHAR  | Hash da senha                    |
| nome              | VARCHAR  | Nome completo                    |
| saldo             | DECIMAL  | Saldo disponível                 |
| idade             | INT      | Idade do usuário                 |
| perfil_investidor | ENUM     | conservador, moderado, agressivo |

### Carteira

| Campo       | Tipo     | Descrição                                  |
| ----------- | -------- | ------------------------------------------ |
| id (PK)     | INT      | Identificador único                        |
| usuario\_id | INT (FK) | Referência para o usuário dono da carteira |
| nome        | VARCHAR  | Nome da carteira (*Aposentadoria*, etc.)   |
| descricao   | TEXT     | Descrição ou objetivo da carteira          |
| created\_at | DATETIME | Data de criação                            |
| updated\_at | DATETIME | Data de atualização                        |

### Categoria

| Campo     | Tipo    | Descrição                               |
| --------- | ------- | --------------------------------------- |
| id (PK)   | INT     | Identificador único                     |
| nome      | VARCHAR | Nome da categoria (*Ação*, *ETF*, etc.) |
| descricao | TEXT    | Detalhes sobre a categoria              |



### Ativo

| Campo         | Tipo     | Descrição                                     |
| ------------- | -------- | --------------------------------------------- |
| id (PK)       | INT      | Identificador único                           |
| carteira\_id  | INT (FK) | Referência para a carteira que possui o ativo |
| categoria\_id | INT (FK) | Referência para a categoria do ativo          |
| nome          | VARCHAR  | Nome do ativo                                 |
| tipo          | VARCHAR  | Tipo específico (ex.: `ON`, `PN`, `BDR`)      |
| quantidade    | INT      | Quantidade de unidades                        |
| preco         | DECIMAL  | Preço atual                                   |
| preco\_medio  | DECIMAL  | Preço médio de compra                         |
| valor         | DECIMAL  | Valor total investido                         |
| created\_at   | DATETIME | Data de criação                               |
| updated\_at   | DATETIME | Data de atualização                           |

### Transação

| Campo      | Tipo     | Descrição                   |
| ---------- | -------- | --------------------------- |
| id (PK)    | INT      | Identificador único         |
| ativo\_id  | INT (FK) | Referência para o ativo     |
| tipo       | ENUM     | `compra`, `venda`, `ajuste` |
| quantidade | INT      | Quantidade negociada        |
| valor      | DECIMAL  | Valor total da transação    |
| data       | DATE     | Data da transação           |

### Meta

| Campo        | Tipo     | Descrição                  |
| ------------ | -------- | -------------------------- |
| id (PK)      | INT      | Identificador único        |
| carteira\_id | INT (FK) | Referência para a carteira |
| nome         | VARCHAR  | Nome da meta               |
| descricao    | TEXT     | Descrição da meta          |
| valor        | DECIMAL  | Valor-alvo                 |
| data\_limite | DATE     | Data limite                |


### Alerta 

| Campo        | Tipo     | Descrição                    |
| ------------ | -------- | ---------------------------- |
| id (PK)      | INT      | Identificador único          |
| carteira\_id | INT (FK) | Referência para a carteira   |
| tipo         | ENUM     | `dividendo`, `preço`, `meta` |
| mensagem     | TEXT     | Mensagem do alerta           |
| data         | DATE     | Data do evento               |


### Rendimento

| Campo        | Tipo     | Descrição                  |
| ------------ | -------- | -------------------------- |
| id (PK)      | INT      | Identificador único        |
| carteira\_id | INT (FK) | Referência para a carteira |
| tipo         | ENUM     | `dividendo`, `valorização` |
| valor        | DECIMAL  | Valor do rendimento        |
| periodo\_ini | DATE     | Início do período          |
| periodo\_fim | DATE     | Fim do período             |


### Relatório

| Campo         | Tipo     | Descrição                  |
| ------------- | -------- | -------------------------- |
| id (PK)       | INT      | Identificador único        |
| carteira\_id  | INT (FK) | Referência para a carteira |
| tipo          | ENUM     | `mensal`, `anual`          |
| data\_geracao | DATE     | Data da geração            |


---

## ▲ Deploy na Vercel

A Vercel não roda containers Docker nem processos PHP-FPM persistentes — o app é
servido como função serverless via runtime de comunidade [`vercel-php`](https://github.com/vercel-community/php)
(arquivos [vercel.json](vercel.json) e [api/index.php](api/index.php)). Isso implica
algumas diferenças em relação ao ambiente Docker local:

-   **Sem worker de fila / scheduler em background.** O `routes/console.php` agenda
    `cotacoes:atualizar` a cada 10 minutos, mas isso depende de um processo `php artisan schedule:work`
    contínuo, que não existe em serverless. Em vez disso, o endpoint
    `GET /api/cron/atualizar-cotacoes` (ver [CronController](app/Http/Controllers/API/CronController.php))
    executa o mesmo comando sob demanda, protegido pela env `CRON_SECRET`. Configure um
    [Vercel Cron Job](https://vercel.com/docs/cron-jobs) apontando pra essa rota — no plano
    Hobby, crons rodam no máximo 1x/dia; frequência maior exige plano Pro ou superior.
-   **Filesystem somente leitura** (exceto `/tmp`). Por isso `LOG_CHANNEL=stderr` e os
    caches de config/rotas/eventos/serviços/views são redirecionados para `/tmp` via
    `vercel.json`. `SESSION_DRIVER`, `CACHE_STORE` e `QUEUE_CONNECTION` já usam o driver
    `database`, então nada disso depende de disco.
-   **Banco de dados** precisa ser externo — a Vercel não hospeda banco. O projeto usa
    MySQL localmente (Docker), mas em produção recomenda-se Postgres via
    [Supabase](https://supabase.com), já suportado em `config/database.php`. Ao usar o
    connection pooler do Supabase (`transaction mode`, porta 6543 — recomendado para
    serverless), mantenha `DB_PGSQL_EMULATE_PREPARES=true` (padrão) para evitar erros de
    *prepared statement* entre conexões pooladas.

### Variáveis de ambiente a configurar no dashboard da Vercel

| Variável | Observação |
| --- | --- |
| `APP_KEY` | gerar localmente com `php artisan key:generate --show` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | domínio da Vercel (ex.: `https://seu-projeto.vercel.app`) |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | dados de conexão do Supabase |
| `DB_SSLMODE` | `require` |
| `JWT_SECRET`, `JWT_TTL`, `JWT_REFRESH_TTL` | mesmos valores usados localmente ou gerados via `php artisan jwt:secret` |
| `AUTH_MODEL` | `App\Infrastructure\Persistence\Models\UserModel` |
| `CORS_ALLOWED_ORIGINS` | domínio(s) do frontend em produção, separados por vírgula |
| `CRON_SECRET` | segredo aleatório; a Vercel injeta esse valor como `Authorization: Bearer` nas chamadas de cron |
| `HGBRASIL_API_KEY`, `BRAPI_API_KEY` | chaves das APIs externas |

### Passos

1. Criar o projeto no Supabase (ou outro Postgres gerenciado) e copiar a connection string.
2. Rodar as migrations contra o banco de produção: `php artisan migrate --force` (com as env vars de produção carregadas localmente, ou via `vercel env pull`).
3. Na Vercel, importar o repositório apontando para a branch `feat/vercel_version` e cadastrar as variáveis acima (Production e Preview).
4. Deploy. O build roda `composer install` automaticamente (runtime `vercel-php`); não é necessário build command customizado.

---

## 🧪 Testes

-   [ ] Testes unitários com PHPUnit
-   [ ] Testes de API com Laravel HTTP Test

---

## 📌 Próximas Etapas

-   [x] Estrutura inicial do projeto
-   [x] Diagrama e modelagem de dados
-   [ ] Implementar CRUD de usuários
-   [ ] Implementar autenticação (Sanctum ou JWT)
-   [ ] CRUD de ativos e transações
-   [ ] Validação de metas
-   [ ] Geração de relatórios
-   [ ] Integração com API externa (opcional)

---

## 💡 Considerações

Este projeto tem grande potencial de expansão, podendo incluir:

-   Integração com corretoras
-   Recomendação de ativos por perfil
-   Gráficos analíticos e dashboards

---

## 🧑‍💻 Desenvolvido por

Andrey Cesar – Projeto de Férias com Laravel + DDD + API REST

