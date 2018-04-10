# Пример консольного приложения для работы с шлюзом B2B на PHP

Конннектор соединяет с одной стороны данные из базы РАЭК, с другой стороны шлюзовую базу данных B2B (MySQL).
Приложение реализует логику работы с шлюзом B2B.

В примере содержится три команды. Но для ваших нужд можно добавить еще неограниченное число команд. Например синхронизация цен и остатков.

## Установка

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Примеры команд

Обновление товаров из базы РАЭК, измененных за прошедшие сутки:
```bash
/path/to/app/console.php connector:product --days-from=1
```

Синхронизация разделов каталога:
```bash
/path/to/app/console.php connector:catalog-section
```

Синхронизация брендов:
```bash
/path/to/app/console.php connector:brand
```

## Помощь

```
B2B connector Command Line Interface v0.2.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  help               Displays help for a command
  list               Lists commands
 connector
  connector:brand    Обновление списка брендов
  connector:catalog-section    Синхронизация разделов каталога
  connector:product  Обновление товаров
```