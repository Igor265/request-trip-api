## Executar o Projeto Usando o Laravel Sail

1. Certifique-se de ter o Docker instalado e em execução em sua máquina.

2. Clone o repositório do projeto:
    ```sh
    git clone https://github.com/Igor265/request-trip-api
    cd request-trip-api
    ```

3. Inicie o Laravel Sail (isso irá construir os containers e instalar as dependências):
    ```sh
    ./vendor/bin/sail up
    ```

4. Execute as migrações e seeders do banco de dados:
    ```sh
    ./vendor/bin/sail artisan migrate
    ```
   ```sh
    ./vendor/bin/sail artisan db:seed
    ```

## Executar os Testes

1. Para executar os testes, use o seguinte comando:
    ```sh
    ./vendor/bin/sail artisan test
    ```

## Informações Adicionais

- Para mais informações sobre o Laravel Sail, consulte a [documentação oficial](https://laravel.com/docs/11.x/sail).

## Endpoints da API

### Autenticação

#### Registrar Usuário
- **URL:** `/register`
- **Método:** `POST`
- **Descrição:** Registra um novo usuário.
- **Cabeçalho:** `Accept: application/json`
- **Corpo da Requisição:**
    ```json
    {
        "name": "Nome do Usuário",
        "email": "email@exemplo.com",
        "password": "senha"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "data": {
            "user": {
              "id": 1,
              "name": "Nome do Usuário",
              "email": "email@exemplo.com",
              "created_at": "data",
              "updated_at": "data"
          },
          "token": "token_de_acesso"
        }
    }
    ```

#### Login
- **URL:** `/login`
- **Método:** `POST`
- **Descrição:** Autentica um usuário.
- **Cabeçalho:** `Accept: application/json`
- **Corpo da Requisição:**
    ```json
    {
        "email": "email@exemplo.com",
        "password": "senha"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "data": {
            "user": {
              "id": 1,
              "name": "Nome do Usuário",
              "email": "email@exemplo.com",
              "created_at": "data",
              "updated_at": "data"
          },
          "token": "token_de_acesso"
        }
    }
    ```

#### Logout
- **URL:** `/logout`
- **Método:** `POST`
- **Descrição:** Encerra a sessão do usuário autenticado.
- **Cabeçalho:** `Authorization: Bearer {token}`, `Accept: application/json`
- **Resposta de Sucesso:**
    ```json
    {
        "message": "Logout realizado com sucesso."
    }
    ```

### Pedido de Viagem

#### Criar Pedido de Viagem
- **URL:** `/request-trip`
- **Método:** `POST`
- **Descrição:** Cria um novo pedido de viagem.
- **Cabeçalho:** `Authorization: Bearer {token}`, `Accept: application/json`
- **Corpo da Requisição:**
    ```json
    {
      "nome_solicitante": "John Doe",
      "email_solicitante": "test@test.com",
      "destino": "São Paulo",
      "data_ida": "2024-12-01",
      "data_volta": "2024-12-10",
      "status": "solicitado"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "message": "Viagem solicitada com sucesso.",
        "data": {
          "id": 1,
          "requester_name": "John Doe",
          "destination": "São Paulo",
          "departure_date": "2024-12-01T00:00:00.000000Z",
          "return_date": "2024-12-10T00:00:00.000000Z",
          "travel_status": "solicitado"
        }
    }
    ```

#### Listar Pedidos de Viagem
- **URL:** `/request-trip`
- **Método:** `GET`
- **Descrição:** Lista todos os pedidos de viagem do usuário autenticado.
- **Cabeçalho:** `Authorization: Bearer {token}`, `Accept: application/json`
- **Parâmetros de Consulta (Query Parameters):**
    - `status`: Filtra os pedidos de viagem pelo status (ex: `solicitado`, `aprovado`, `cancelado`).
    - `destino`: Filtra os pedidos de viagem pelo destino.
    - `data_ida_inicio`: Filtra os pedidos de viagem com data de ida a partir desta data (formato: `YYYY-MM-DD`).
    - `data_ida_fim`: Filtra os pedidos de viagem com data de ida até esta data (formato: `YYYY-MM-DD`).
    - `data_volta_inicio`: Filtra os pedidos de viagem com data de volta a partir desta data (formato: `YYYY-MM-DD`).
    - `data_volta_fim`: Filtra os pedidos de viagem com data de volta até esta data (formato: `YYYY-MM-DD`).
- **Resposta de Sucesso:**
    ```json
    {
      "data": [
          {
              "id": 1,
              "requester_name": "John Doe",
              "destination": "New York",
              "departure_date": "2024-12-01T00:00:00.000000Z",
              "return_date": "2024-12-10T00:00:00.000000Z",
              "travel_status": "solicitado"
          }
      ]
    }
    ```

#### Obter Detalhes do Pedido de Viagem
- **URL:** `/request-trip/{id}`
- **Método:** `GET`
- **Descrição:** Retorna os detalhes de um pedido de viagem específico.
- **Cabeçalho:** `Authorization: Bearer {token}`, `Accept: application/json`
- **Resposta de Sucesso:**
    ```json
    {
      "data": {
        "id": 1,
        "requester_name": "John Doe",
        "destination": "New York",
        "departure_date": "2024-12-01T00:00:00.000000Z",
        "return_date": "2024-12-10T00:00:00.000000Z",
        "travel_status": "cancelado"
      }
    }
  ```

#### Atualizar Status do Pedido de Viagem
- **URL:** `/request-trip/{id}/status`
- **Método:** `PUT`
- **Descrição:** Atualiza o status de um pedido de viagem.
- **Cabeçalho:** `Authorization: Bearer {token}`, `Accept: application/json`
- **Corpo da Requisição:**
    ```json
    {
        "status": "novo_status"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
      "message": "Status atualizado com sucesso.",
      "data": {
        "id": 1,
        "requester_name": "John Doe",
        "destination": "New York",
        "departure_date": "2024-12-01T00:00:00.000000Z",
        "return_date": "2024-12-10T00:00:00.000000Z",
        "travel_status": "aprovado"
      }
    }
    ```
