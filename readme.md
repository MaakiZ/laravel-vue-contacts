<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

# Projeto Prático de Laravel + VueJs Agenda de Contatos

## Baixar o projeto
Clonar o projeto:
``` bash
# Clonar
git clone https://github.com/carlosfgti/laravel-com-vue-exemplo.git

# Acessar
cd contacts_projet
```

## Configuração - Backend

``` bash
# Dependências do projeto
composer install

# Configurar banco no arquivo .env
cp .env.example .env

# Gerar a app key
php artisan key:generate

# Gear a jwt key
php artisan jwt:secret

# Migrations (tabelas e Seeders)
php artisan migrate --seed

# Link simbólico storage/app/public para public/storage/
php artisan storage:link
```

## Acesso do admin
O usuário de teste é:
```
email:    admin@gmail.com
password: 123456
```

## Frontend da aplicação
``` bash

# Este projeto é compatível com node 8.12.0 - Para mais detalhes sobre nvm: https://tecadmin.net/install-nodejs-with-nvm/
nvm install 8.12.0
nvm list
nvm use 8.12.0

# Atualizar dependências
npm install

# Rodar em local localhost:8080
npm run dev

```