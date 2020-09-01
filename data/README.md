# Стена сообщений

## :fire: Как развернуть проект

- На локальной машине открываем терминал, и (например) в домашней директории разворачиваем проект, после чего переходим в его директорию:

```bash
$ git clone https://github.com/oleg3190/avtocod-php-developer-test-tas
$ cd $_
```

- Устанавливаем требуемые пакеты с помощью команды:

```bash
composer update
```

# Для запуска проекта в docker

- Переходим в директорию data env.docker переименовываем в .env

- переходим в директорию laradock в корневой папке проекта.

- открываем консоль и пишем команду docker-compose up -d

- пишем docker-compose exec workspace bash
- php artisan migrate
- переходим в браузер и открываем localhost:60

# Для запуска проекта локально

- Переходим в директорию data env.local переименовываем в .env

- Выполняем команды:

```bash
php artisan migrate
```

- Для работы приложения понадобится redis:

```bash
ссылка для windows
https://github.com/microsoftarchive/redis/releases/tag/win-3.2.100
```

- После установки необходимо запустить файл redis-cli.exe из директории redis и проверить его работу командой ping. В ответ должно прийти pong

- Далее выполнить комманды

```bash
php artisan queue:work
laravel-echo-server start
```

- Для запуска проекта:

```bash
php artisan serve
```

- Для тестов

```bash
vendor\bin\phpunit
```
