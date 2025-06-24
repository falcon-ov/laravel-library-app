# API Документация: Управление книгами (для Postman)

## Общая информация
API предоставляет доступ к управлению книгами в системе библиотеки. Все запросы выполняются через базовый URL `/api`. Защищенные endpoints требуют аутентификации с использованием JWT-токена. Документация оптимизирована для работы с **Postman**, включая коллекцию запросов для удобного тестирования.

### Настройка Postman
1. **Создайте окружение**:
   - Откройте Postman и создайте новую окружение (Environment) с именем, например, `Library API`.
   - Добавьте следующие переменные:
     - `base_url`: `http://localhost:8000` (или ваш сервер).
     - `token`: Оставьте пустым (будет заполняться после аутентификации).
   - Пример конфигурации окружения:
     ```json
     {
       "name": "Library API",
       "values": [
         { "key": "base_url", "value": "http://localhost:8000", "enabled": true },
         { "key": "token", "value": "", "enabled": true }
       ]
     }
     ```

2. **Импортируйте коллекцию**:
   - Скопируйте JSON-код коллекции ниже и импортируйте его в Postman через `File > Import`.
   - Коллекция включает все endpoints для книг и аутентификации.

3. **Аутентификация**:
   - Используйте запрос `Login` из коллекции, чтобы получить JWT-токен.
   - Токен автоматически сохраняется в переменной `token` окружения через скрипт в Postman.
   - Для всех защищенных запросов в коллекции настроен заголовок `Authorization: Bearer {{token}}`.

### Коллекция Postman
Сохраните следующий JSON как `LibraryBooksAPI.postman_collection.json` и импортируйте в Postman:

```json
{
  "info": {
    "name": "Library Books API",
    "_postman_id": "a4f3b2c1-7d8e-4a9b-b1c2-d3e4f5a6b7c8",
    "description": "API для управления книгами в библиотеке.",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "item": [
    {
      "name": "Auth",
      "item": [
        {
          "name": "Login",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Content-Type", "value": "application/json" }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\"email\":\"user@example.com\",\"password\":\"password123\"}"
            },
            "url": "{{base_url}}/api/login"
          },
          "response": [],
          "event": [
            {
              "listen": "test",
              "script": {
                "type": "text/javascript",
                "exec": [
                  "const response = pm.response.json();",
                  "if (response.access_token) {",
                  "    pm.environment.set('token', response.access_token);",
                  "}"
                ]
              }
            }
          ]
        },
        {
          "name": "Register",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Content-Type", "value": "application/json" }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\"name\":\"John Doe\",\"email\":\"user@example.com\",\"password\":\"password123\",\"password_confirmation\":\"password123\",\"role\":\"user\"}"
            },
            "url": "{{base_url}}/api/register"
          },
          "response": []
        },
        {
          "name": "Refresh Token",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Authorization", "value": "Bearer {{token}}" }
            ],
            "url": "{{base_url}}/api/refresh"
          },
          "response": [],
          "event": [
            {
              "listen": "test",
              "script": {
                "type": "text/javascript",
                "exec": [
                  "const response = pm.response.json();",
                  "if (response.access_token) {",
                  "    pm.environment.set('token', response.access_token);",
                  "}"
                ]
              }
            }
          ]
        }
      ]
    },
    {
      "name": "Books",
      "item": [
        {
          "name": "List Books",
          "request": {
            "method": "GET",
            "header": [
              { "key": "Authorization", "value": "Bearer {{token}}" }
            ],
            "url": {
              "raw": "{{base_url}}/api/books?title=Test&author_id=1",
              "query": [
                { "key": "title", "value": "Test" },
                { "key": "author_id", "value": "1" }
              ]
            }
          },
          "response": []
        },
        {
          "name": "Get Book",
          "request": {
            "method": "GET",
            "header": [
              { "key": "Authorization", "value": "Bearer {{token}}" }
            ],
            "url": "{{base_url}}/api/books/1"
          },
          "response": []
        },
        {
          "name": "Create Book",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Authorization", "value": "Bearer {{token}}" },
              { "key": "Content-Type", "value": "application/json" }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\"title\":\"New Book\",\"isbn\":\"9876543210987\",\"year\":2023,\"author_id\":1,\"category_id\":1}"
            },
            "url": "{{base_url}}/api/books"
          },
          "response": []
        },
        {
          "name": "Update Book",
          "request": {
            "method": "PUT",
            "header": [
              { "key": "Authorization", "value": "Bearer {{token}}" },
              { "key": "Content-Type", "value": "application/json" }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\"title\":\"Updated Book\",\"year\":2024}"
            },
            "url": "{{base_url}}/api/books/1"
          },
          "response": []
        },
        {
          "name": "Delete Book",
          "request": {
            "method": "DELETE",
            "header": [
              { "key": "Authorization", "value": "Bearer {{token}}" }
            ],
            "url": "{{base_url}}/api/books/1"
          },
          "response": []
        }
      ]
    }
  ]
}
```

### Аутентификация
- **Тип**: Bearer Token (JWT).
- **Процесс**:
  1. Отправьте запрос `Login` из коллекции, указав `email` и `password`.
  2. Токен автоматически сохраняется в переменной `token` окружения.
  3. Все запросы в коллекции используют `Authorization: Bearer {{token}}`.
- **Ошибки**:
  - **401 Unauthorized**: Токен отсутствует или недействителен.
  - **403 Forbidden**: Недостаточно прав (например, роль `admin` для создания/удаления).

### Endpoints для книг

#### 1. Получить список книг
- **Метод**: GET
- **URL**: `{{base_url}}/api/books`
- **Описание**: Возвращает список книг с пагинацией и фильтрами.
- **Аутентификация**: Требуется (роли: `user`, `admin`).
- **Параметры запроса** (опционально):
  - `title` (string): Фильтр по названию (например, `Test`).
  - `author_id` (integer): Фильтр по ID автора.
  - `category_id` (integer): Фильтр по ID категории.
  - `page` (integer): Номер страницы (по умолчанию 1).
- **Postman**:
  - Используйте запрос `List Books` из коллекции.
  - Пример параметров: `title=Test&author_id=1`.
- **Пример ответа** (200 OK):
  ```json
  {
    "data": [
      {
        "id": 1,
        "title": "Test Book",
        "isbn": "1234567890123",
        "year": 2020,
        "author": { "id": 1, "name": "John Doe" },
        "category": { "id": 1, "name": "Fiction" },
        "created_at": "2025-06-24 12:00:00",
        "updated_at": "2025-06-24 12:00:00"
      }
    ],
    "meta": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 10,
      "total": 1
    }
  }
  ```

#### 2. Получить информацию о книге
- **Метод**: GET
- **URL**: `{{base_url}}/api/books/{id}`
- **Описание**: Возвращает данные о книге по ID.
- **Аутентификация**: Требуется (роли: `user`, `admin`).
- **Параметры**:
  - `id` (integer): ID книги.
- **Postman**:
  - Используйте запрос `Get Book`.
  - Укажите ID в URL (например, `/api/books/1`).
- **Пример ответа** (200 OK):
  ```json
  {
    "data": {
      "id": 1,
      "title": "Test Book",
      "isbn": "1234567890123",
      "year": 2020,
      "author": { "id": 1, "name": "John Doe" },
      "category": { "id": 1, "name": "Fiction" },
      "created_at": "2025-06-24 12:00:00",
      "updated_at": "2025-06-24 12:00:00"
    }
  }
  ```
- **Ошибка** (404 Not Found):
  ```json
  { "error": "Не удалось получить книгу." }
  ```

#### 3. Создать книгу
- **Метод**: POST
- **URL**: `{{base_url}}/api/books`
- **Описание**: Создает новую книгу.
- **Аутентификация**: Требуется (роль: `admin`).
- **Тело запроса** (JSON):
  ```json
  {
    "title": "New Book",
    "isbn": "9876543210987",
    "year": 2023,
    "author_id": 1,
    "category_id": 1
  }
  ```
- **Postman**:
  - Используйте запрос `Create Book`.
  - Укажите данные в теле запроса.
- **Пример ответа** (201 Created):
  ```json
  {
    "data": {
      "id": 2,
      "title": "New Book",
      "isbn": "9876543210987",
      "year": 2023,
      "author": { "id": 1, "name": "John Doe" },
      "category": { "id": 1, "name": "Fiction" },
      "created_at": "2025-06-24 12:05:00",
      "updated_at": "2025-06-24 12:05:00"
    },
    "message": "Книга успешно создана."
  }
  ```
- **Ошибка** (422 Unprocessable Entity):
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "title": ["Название книги обязательно."],
      "isbn": ["Этот ISBN уже используется."]
    }
  }
  ```

#### 4. Обновить книгу
- **Метод**: PUT
- **URL**: `{{base_url}}/api/books/{id}`
- **Описание**: Обновляет данные книги.
- **Аутентификация**: Требуется (роль: `admin`).
- **Параметры**:
  - `id` (integer): ID книги.
- **Тело запроса** (JSON, частичное обновление):
  ```json
  {
    "title": "Updated Book",
    "year": 2024
  }
  ```
- **Postman**:
  - Используйте запрос `Update Book`.
  - Укажите ID в URL и данные в теле.
- **Пример ответа** (200 OK):
  ```json
  {
    "data": {
      "id": 1,
      "title": "Updated Book",
      "isbn": "1234567890123",
      "year": 2024,
      "author": { "id": 1, "name": "John Doe" },
      "category": { "id": 1, "name": "Fiction" },
      "created_at": "2025-06-24 12:00:00",
      "updated_at": "2025-06-24 12:10:00"
    },
    "message": "Книга успешно обновлена."
  }
  ```
- **Ошибка** (422 Unprocessable Entity):
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "year": ["Год издания не может быть позже текущего года."]
    }
  }
  ```

#### 5. Удалить книгу
- **Метод**: DELETE
- **URL**: `{{base_url}}/api/books/{id}`
- **Описание**: Удаляет книгу (мягкое удаление).
- **Аутентификация**: Требуется (роль: `admin`).
- **Параметры**:
  - `id` (integer): ID книги.
- **Postman**:
  - Используйте запрос `Delete Book`.
  - Укажите ID в URL.
- **Пример ответа** (200 OK):
  ```json
  {
    "message": "Книга успешно удалена."
  }
  ```
- **Ошибка** (404 Not Found):
  ```json
  { "error": "Не удалось удалить книгу." }
  ```

### Аутентификационные endpoints

#### 1. Вход
- **Метод**: POST
- **URL**: `{{base_url}}/api/login`
- **Описание**: Аутентифицирует пользователя и возвращает JWT-токен.
- **Тело запроса** (JSON):
  ```json
  {
    "email": "user@example.com",
    "password": "password123"
  }
  ```
- **Postman**:
  - Используйте запрос `Login`.
  - Токен сохраняется в `token` через скрипт.
- **Пример ответа** (200 OK):
  ```json
  {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600
  }
  ```

#### 2. Регистрация
- **Метод**: POST
- **URL**: `{{base_url}}/api/register`
- **Описание**: Создает нового пользователя и возвращает JWT-токен.
- **Тело запроса** (JSON):
  ```json
  {
    "name": "John Doe",
    "email": "user@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "user"
  }
  ```
- **Postman**:
  - Используйте запрос `Register`.
- **Пример ответа** (201 Created):
  ```json
  {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com",
      "role": "user"
    }
  }
  ```

#### 3. Обновление токена
- **Метод**: POST
- **URL**: `{{base_url}}/api/refresh`
- **Описание**: Обновляет JWT-токен.
- **Аутентификация**: Требуется.
- **Postman**:
  - Используйте запрос `Refresh Token`.
  - Новый токен сохраняется в `token`.
- **Пример ответа** (200 OK):
  ```json
  {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600
  }
  ```

### Примечания
- Убедитесь, что сервер запущен (`php artisan serve`).
- Пагинация: 10 записей на страницу.
- Роли: `admin` для создания/обновления/удаления, `user` или `admin` для просмотра.
- Формат даты: `YYYY-MM-DD HH:MM:SS`.
- Для ошибок валидации (422) проверяйте поле `errors` в ответе.

### Тестирование в Postman
1. Импортируйте коллекцию и настройте окружение.
2. Выполните `Login` для получения токена.
3. Тестируйте запросы к книгам (`List Books`, `Create Book`, и т.д.).
4. При необходимости обновляйте токен через `Refresh Token`.

## Контакты
Для вопросов по API свяжитесь с разработчиком проекта.