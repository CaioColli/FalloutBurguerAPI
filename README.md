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

#### Cabeçalho da requisição

| Parâmetro   | Tipo       | Valor | Descrição                           |
| :---------- | :--------- | ------ |:---------------------------------- |
| `x-api-key` | `string` | `Token` |**Obrigatório**. A chave da sua API |
| `Accept` | `string` | `application/json` |**Obrigatório**. Identifica formato dos dados.|
| `Authorization` | `string` | `Token` |**Obrigatório em rotas autenticadas**.|

#### EndPoints

| EndPoint   | Método       | Descrição  | Obs |
| :---------- | :--------- | :--------------------- | :-- |
| `/api/auth/register`   | `post` | Cadastro de novo usuário | `null` |
| `/api/auth/login` |`post`| Login de usuário | `null` |
| `/api/auth/logout` | `post` | Logout do usuário | **Token necessário** |
| `/api/auth/forgot-password` | `post` | Requisita mudança de senha | `null` |
| `/api/auth/reset-password` | `post` | Redefine senha do usuário | `null` |



## Autores

- [@GitHub - Caio Colli](https://github.com/CaioColli)
- [@Linkedin - Caio Colli](https://www.linkedin.com/in/caiocolli/)


## Stack utilizada

**Back-end:** PHP, Laravel 12

**Banco de dados** PostgreSQL
