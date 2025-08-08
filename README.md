# Fallout Burguer API

Plataforma integrada para hamburguerias com login seguro, gerenciamento de produtos e estoque, pagamentos online via Mercado Pago e comunicação automatizada por e-mail e SMS, proporcionando eficiência e melhor experiência ao cliente.

## Instalação

Clone o projeto

```bash
git clone git@github.com:CaioColli/FalloutBurguerAPI.git
```

Entre no diretório do projeto

```bash
cd FalloutBurguerAPI
```

Instale as dependências

```bash
composer install
```
## Rodando aplicação

### Crie um arquivo **.env** e copie e cole o conteudo do arquivo **.env.example**

#### Configurando banco de dados

```bash
DB_CONNECTION=DB
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=DBName
DB_USERNAME=UserName
DB_PASSWORD=PasswordDB
```

Após fazer a conexão com o banco de dados rode a migration

```bash
php artisan migrate
```

#### Configurando e-mail para disparo

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME='Nome'
MAIL_PASSWORD='SenhaEmail | SenhaDeAPP'
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS='SeuEmail'
```

#### Configurando chave para API

```bash
API_KEY=SenhaAPI
```

#### Inicie o servidor

```bash
php artisan serve
```


## Documentação da API

#### Cabeçalho das requisições

| Parâmetro   | Tipo       | Valor | Descrição                           |
| :---------- | :--------- | ------ |:---------------------------------- |
| `x-api-key` | `string` | `Token` |**Obrigatório**. A chave da API |
| `Accept` | `string` | `application/json` |**Obrigatório**. Identifica formato dos dados.|
| `Authorization` | `string` | `Token` |**Obrigatório em rotas autenticadas**.|

#### EndPoints

| EndPoint   | Método       | Descrição  | Obs |
| :---------- | :--------- | :--------------------- | :-- |
| `/api/auth/register`   | `post` | Cadastro de novo usuário | `null` |
| `/api/auth/login` |`post`| Login de usuário | `null` |
| `/api/auth/logout` | `post` | Logout do usuário | **Token de autenticação necessário** |
| `/api/auth/forgot-password` | `post` | Requisita mudança de senha | `null` |
| `/api/auth/reset-password` | `post` | Redefine senha do usuário | `null` |
| `/api/products` | `get` | Exibe produtos cadastrados | **Token de autenticação necessário** |
| `/api/products` | `post` | Cria um novo produto | **Token de autenticação necessário** |
| `/api/products/{id}` | `get` | Exibe produto | **Token de autenticação necessário** |
| `/api/products/{id}/update` | `get` | Edita produto | **Token de autenticação necessário** |
| `/api/products/{id}/delete` | `delete` | Deleta produto | **Token de autenticação necessário** |
| `/api/stock/` | `get` | Exibe itens do estoque cadastrado | **Token de autenticação necessário** |
| `/api/stock/` | `post` | Cria um novo item no estoque | **Token de autenticação necessário** |
| `/api/stock/{id}` | `get` | Exibe item do estoque | **Token de autenticação necessário** |
| `/api/stock/{id}/update` | `post` | Edita item do estoque | **Token de autenticação necessário** |
| `/api/stock/{id}/delete` | `delete` | Deleta item do estoque | **Token de autenticação necessário** |
| `/api/ingredients/{id}` | `get` | Exibe ingredientes do produto | **Token de autenticação necessário** |
| `/api/ingredients/{id}/update` | `post` | Edita ingredientes do produto | **Token de autenticação necessário** |
| `/api/ingredients/{id}/delete` | `delete` | Deleta ingredientes do produto | **Token de autenticação necessário** |



## Autores

- [@GitHub - Caio Colli](https://github.com/CaioColli)
- [@Linkedin - Caio Colli](https://www.linkedin.com/in/caiocolli/)


## Stack utilizada

**Back-end:** PHP, Laravel 12

**Banco de dados** PostgreSQL
