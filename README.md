---

# README.md

```markdown
# Мясофактура API

Простой REST API для управления заказами в приложении «Мясофактура» на Laravel 11.

---

## Требования

- PHP 8.1+
- Composer
- MariaDB или MySQL
- Laravel 11
- Расширения PHP: mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath и др.

---

## Быстрый старт

### 1. Клонировать репозиторий

```bash
git clone https://github.com/yourusername/meatfactory-api.git
cd meatfactory-api
```

### 2. Установить зависимости

```bash
composer install
```

### 3. Создать файл окружения

```bash
cp .env.example .env
```

### 4. Настроить `.env`

Открой `.env` и укажи параметры подключения к базе данных:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meatfactory
DB_USERNAME=root
DB_PASSWORD=your_password
```

Настрой также другие переменные, если нужно.

### 5. Сгенерировать ключ приложения

```bash
php artisan key:generate
```

### 6. Запустить миграции и сидеры

```bash
php artisan migrate --seed
```

Это создаст таблицы и заполнит базу тестовыми продуктами и пользователями.

### 7. Запустить сервер разработки

```bash
php artisan serve
```

По умолчанию API будет доступен по адресу:

```
http://127.0.0.1:8000
```

---

## Использование API

- Регистрация: `POST /api/register`
- Авторизация: `POST /api/login`
- Получение списка продуктов: `GET /api/products`
- Оформление заказа: `POST /api/orders` (требует авторизации)
- Получение заказов пользователя: `GET /api/orders` (требует авторизации)

---

## Аутентификация

API использует Laravel Sanctum с токенами.

Перед запросами, требующими авторизации, получите токен через `/api/login`, затем передавайте его в заголовке:

```
Authorization: Bearer {your_token}
```

---

## Документация API

Swagger-документация доступна по адресу:

```
http://127.0.0.1:8000/api/documentation
```
