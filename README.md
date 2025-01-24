# Sistema simplificado de transferências 
<p>
<a href="https://github.com/waanvieira/simplified_payment_platform/blob/main/LICENSE"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sobre o projeto
Projeto simplificado de transferências entre contas que utiliza o padrão Saga, sistema distribuido com comunicação assíncrona entre os sistemas fila (RabbitMQ).

# Tecnologias utilizadas
- PHP 8.2
- Laravel 11.7.0
- MYSQL 8
- Redis 7.4

# Como executar o projeto

## Pré-requisitos
Docker
https://www.docker.com/get-started/

```bash
# clonar repositório
git clone https://github.com/waanvieira/test_log.git

# entrar na pasta do projeto back end
cd test_log

# executar o comando
./entrypoint.sh

# Executar testes

docker-compose exec app php artisan test

```
# Rotas do sistema

Pode encontrar as request das rotas na pasta "requestshttp"

* Checar se o app está no ar <br>
  http://127.0.1.1:9003/api/v1/health <br>  

* Os usuários são criados a partir de um endpoint externo, os usuários estão sendo criados por um comando executado a cada 5 minutos (para funcionar, por favor, fazer o agendamento no cron) <br>
   php artisan app:register-users-by-external-end-point

* Listar usuários

Para reallizar transferências é obrigatório que tenha criado contas válidas e com saldo positivo para realizar a transferência

curl  -X GET 'http://localhost:9003/api/v1/users' \
  --header 'Accept: application/json' \
  {
  }

# Autor

Wanderson Alves Vieira

https://www.linkedin.com/in/wanderson-alves-vieira-59b832148
