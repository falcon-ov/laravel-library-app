
# Library App — Laravel 12 REST API

Library App — это backend-приложение на Laravel 12, разработанное для управления библиотечными ресурсами. В текущей версии реализован **полноценный REST API для управления книгами**, включая CRUD-операции, JWT-аутентификацию, фабрики и сидеры.

---

## Стек технологий

- Laravel 12
- PHP 8.3+
- MySQL / PostgreSQL
- JWT (tymon/jwt-auth)
- Laravel Seeders & Factories
- Postman (для тестирования API)

---

## Установка

```bash
git clone https://github.com/your-username/library-app.git
cd library-app
composer install
cp .env.example .env
php artisan key:generate
```

Настрой `.env` файл:

```env
DB_DATABASE=library
DB_USERNAME=root
DB_PASSWORD=your_password

JWT_SECRET=your_jwt_secret
```

---

##  Миграции и сидеры

```bash
php artisan migrate --seed
```

Сидеры и фабрики автоматически создают:
- пользователей,
- авторов,
- категории,
- книги.

---

##  Аутентификация

Аутентификация реализована через JWT.

Доступные маршруты:

| Метод | Endpoint            | Назначение            |
|-------|---------------------|------------------------|
| POST  | `/api/register`     | регистрация           |
| POST  | `/api/login`        | вход и получение токена|
| POST  | `/api/refresh`      | обновление токена     |

Все защищённые запросы используют заголовок:

```
Authorization: Bearer {token}
```

---

## 📘 API для управления книгами

| Метод | Endpoint              | Описание               | Роль              |
|-------|-----------------------|------------------------|-------------------|
| GET   | `/api/books`          | получить список книг   | user / admin      |
| GET   | `/api/books/{id}`     | получить одну книгу    | user / admin      |
| POST  | `/api/books`          | создать новую книгу    | admin             |
| PUT   | `/api/books/{id}`     | обновить книгу         | admin             |
| DELETE| `/api/books/{id}`     | удалить книгу          | admin             |

Поддерживаются фильтры: `title`, `author_id`, `category_id`, `page`.

---

## 🧪 Тестирование через Postman

Документация в корне проекта /BookApiController.md
Документация содержит готовые примеры всех запросов и автоматические скрипты обновления токена.

---

## 📌 Статус проекта

 Готово:
- API для книг
- JWT-аутентификация
- Сидеры и фабрики

 В планах:
- API для авторов, категорий, издателей
- Управление ролями пользователей
- Админ-панель или SPA-интерфейс
