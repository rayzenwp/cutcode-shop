# Steps creation

- composer install
- npm install
    Зависимости верстки
    npm install -D tailwindcss postcss autoprefixer
    npx tailwindcss init -p
    npm install sass @tailwindcss/line-clamp

- php artisan storage:link
- php artisan telescope:install
- php artisan migrate

# Instalation
    - composer install
    - npm install
    - php app:install

# Deploy


# Info from course
https://livewire.cutcode.ru/roadmap
https://tz.cutcode.ru/tasks/1
# первый этап
## Логирование


## Rate limit
Можно например ограничить отправку смс 1 в минуту. Либо количество попыток вход, отправка емейлов на почту.
Глобальный рейл лимит, помогает от парсинга. В большинста магазинов нет защиты и есть только бан по айпи или клоудфлар подключен.
429 ответ - слишком много запросов

# Второй этап
https://github.com/lee-to/laravel-naming-conventions#terms


Репозитории для Eloquent моделей
https://kongulov.dev/blog/repository-pattern-in-laravel-php-design-pattern
Нужны или нет
Скорее всего нет если сразу хранилище не будет менятся

php artisan make:model Brand -mf  // migration and factory

## Larastan

# CI/CD

Телескоп на проде отключать? Как?