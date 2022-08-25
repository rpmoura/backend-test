
## Desafio Back-end

### Como testar
Para executar os testes basta executar os seguintes passos:

    $ git clone https://github.com/rpmoura/backend-test.git <sua-pasta>
    $ cd <sua-pasta>/backend-test && docker-compose --env-file ./docker/.env up -d --build
    $ docker exec picpay-api /bin/bash -c "composer install && ./vendor/bin/phpunit --testdox"

Para definição das variáveis de ambiente:

    $ docker exec picpay-api /bin/bash -c "cp .env.example .env"

Para criar a estrutura de banco de dados basta executa o seguinte comando:

    $ docker exec picpay-api php artisan migrate --seed

