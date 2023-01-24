# Instalation

- composer install
- npm install
    Зависимости верстки
    npm install -D tailwindcss postcss autoprefixer
    npx tailwindcss init -p
    npm install sass @tailwindcss/line-clamp

- php artisan storage:link
- php artisan telescope:install
- php artisan migrate

    
# Deploy


# Info from course 
## Rate limit
Можно например ограничить отправку смс 1 в минуту. Либо количество попыток вход, отправка емейлов на почту.
Глобальный рейл лимит, помогает от парсинга. В большинста магазинов нет защиты и есть только бан по айпи или клоудфлар подключен.
429 ответ - слишком много запросов
