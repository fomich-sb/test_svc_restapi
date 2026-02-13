

# Task Management RESTful API

RESTful API для управления списком задач с аутентификацией по токену (Laravel Sanctum).

## Установка
### 1. Клонирование репозитория

```bash
git clone https://github.com/fomich-sb/test_svc_restapi.git
```
### 2. Установка зависимостей
```bash
composer install
```
### 3. Создайте БД
### 4. Настройка окружения
Создайте файл .env из .env.example. Отредактируйте файл .env и укажите параметры подключения к базе данных и настройки почты для уведомлений:

```env
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
```

### 5. Генерация ключа приложения
```bash
php artisan key:generate
```
### 6. Запуск миграций
```bash
php artisan migrate
```
### 7. Создание тестового пользователя (test@example.com, пароль test@example.com)
```bash
php artisan db:seed
```

## Запуск сервера
```bash
php artisan serve  
```
API будет доступно по адресу: http://localhost:8000

## Запуск планировщика задач
Для автоматической проверки просроченных задач и отправки уведомлений необходимо настроить планировщик.  
  
Вариант 1: Для разработки (запуск в терминале)  
```bash
php artisan schedule:work  
```
Вариант 2: Для продакшена (настройка cron)  
```bash
php artisan tasks:check-overdue
```

## Запуск обработчика очереди
```bash
php artisan queue:work
```
