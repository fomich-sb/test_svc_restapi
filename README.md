# Task Management RESTful API

RESTful API для управления списком задач с аутентификацией по токену (Laravel Sanctum).

## Установка
### 1. Клонирование репозитория
git clone 
cd test_svc_restapi
### 2. Установка зависимостей
composer install
### 3. Настройка окружения
Создайте файл .env из примера:
cp .env.example .env
Отредактируйте файл .env и укажите параметры подключения к базе данных и настройки почты для уведомлений:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

### 4. Генерация ключа приложения
php artisan key:generate
### 5. Запуск миграций
php artisan migrate
### 6. Создание тестового пользователя (test@example.com, пароль test@example.com)
php artisan db:seed
### 7. Запуск сервера
php artisan serve
API будет доступно по адресу: http://localhost:8000

## Запуск планировщика задач
Для автоматической проверки просроченных задач и отправки уведомлений необходимо настроить планировщик.

Вариант 1: Для разработки (запуск в терминале)
php artisan schedule:work
Вариант 2: Для продакшена (настройка cron)
php artisan tasks:check-overdue

## Запуск обработчика очереди
php artisan queue:work