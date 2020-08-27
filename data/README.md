<p align="center">
  <img alt="avtocod" src="https://avatars1.githubusercontent.com/u/32733112?s=70&v=4" width="70" height="70" />
</p>

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
- Теперь необходимо переименовать .env.example в .env


- После чего выполняем команды:

```bash
php artisan migrate
php artisan db:seed
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

