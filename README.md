# Mini CMS

Простая CMS для управления постами, построенная на Laravel.

## Установка

1. Установите зависимости:
```bash
composer install
npm install
```

2. Настройте окружение:
```bash
cp .env.example .env
php artisan key:generate
```

3. Запустите MySQL через Docker:
```bash
docker-compose up -d
```

4. Выполните миграции и заполните базу тестовыми данными:
```bash
php artisan migrate
php artisan db:seed
```

5. Соберите фронтенд:
```bash
npm run dev
```

6. Запустите сервер:
```bash
php artisan serve
```

Приложение будет доступно по адресу `http://localhost:8000`

## Учетные данные

После выполнения `php artisan db:seed` создается администратор:
- Email: `test@example.com`
- Пароль: `secret`

## Основные маршруты

- `/` - Главная страница
- `/posts` - Список постов
- `/admin` - Админ-панель (требуется роль admin)
- `/login` - Вход
- `/register` - Регистрация
- `/profile` - Профиль пользователя

## Разработка

Для разработки запустите в двух терминалах:
```bash
# Терминал 1 - Laravel сервер
php artisan serve

# Терминал 2 - Vite с hot reload
npm run dev
```

## Технологии

Laravel, MySQL, Tailwind CSS, Vite
