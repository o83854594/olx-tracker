Скопіювати проект:

git clone https://github.com/o83854594/olx.git


Створити файл змінних оточення:

cp .env.example .env


Запустити проект:

docker compose up --build -d


Встановити залежні пакети:

docker compose exec laravel composer install


Створити необхідні таблиці:

docker compose exec laravel php artisan migrate

Перезапустити контейнери:

docker compose restart

Створення підписки:

curl --location 'http://localhost/api/subscribe' \
--header 'Accept: application/json' \
--form 'url="https://www.olx.ua/d/uk/obyavlenie/velosiped-fort-falcon-26-IDVIU4k.html"' \
--form 'email="first@mail.com"'


Перевірка зміни ціни:

docker compose exec laravel php artisan app:price-change-tracking


Обробка нотифікацій:

docker compose exec laravel php artisan queue:work

Перевірка листів в сервісі Mailpit:

http://localhost:8025/
