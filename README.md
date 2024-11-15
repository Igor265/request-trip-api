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
