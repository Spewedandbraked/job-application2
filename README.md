# Решение технического задания

## О проекте

Проект представляет собой реализацию тестового задания без использования готовых фреймворков, с минимальным набором зависимостей. Основная цель — продемонстрировать понимание принципов разработки, умение работать с абстракциями и решать задачи различной сложности.

### Архитектурные решения

- **Минималистичный роутер и система контроллеров** — реализованы для организации структуры приложения
- **Класс-хелпер `Arr`** — содержит вспомогательные методы для работы с массивами
- **Database Abstraction Layer** — использован Doctrine DBAL для безопасной работы с БД
- **Система миграций** — реализована через Phinx для управления структурой базы данных
- **HTTP-фундамент** — использован Symfony HttpFoundation для работы с HTTP-запросами

## Задачи и решения

### Задача 1: Поиск категории по ID

**Постановка:** Написать функцию `searchCategory($categories, $id)`, которая по идентификатору категории возвращает название категории.

**Решение:** Реализована рекурсивная функция поиска в многомерном массиве.

**Код:**
```php
/**
 * Рекурсивный поиск в многомерном массиве
 * 
 * @param array $array Многомерный массив для поиска
 * @param string $searchField Поле, в котором осуществляется поиск
 * @param string $recursiveKey Ключ для рекурсивного обхода
 * @param mixed $searchable Значение для поиска
 * @param bool $strict Использовать строгое сравнение
 * @return array|null Найденный элемент массива или null если не найден
 */
public static function recursiveSearch(
    array $array,
    string $searchField,
    string $recursiveKey,
    mixed $searchable,
    bool $strict = false
): ?array {
    foreach ($array as $item) {
        // Проверка наличия $searchable в искомом
        if (isset($item[$searchField])) {
            if (
                ($strict && $item[$searchField] === $searchable)
                || (!$strict && $item[$searchField] == $searchable)
            ) {
                return $item;
            }
        }

        // Поиск внутри вложенных элементов
        if (isset($item[$recursiveKey]) && is_array($item[$recursiveKey])) {
            $result = self::recursiveSearch(
                $item[$recursiveKey],
                $searchField,
                $recursiveKey,
                $searchable,
                $strict
            );

            if ($result !== null) {
                return $result;
            }
        }
    }

    return null;
}
```

**Особенности реализации:**
- Функция размещена в классе-хелпере `App\Helpers\Arr`
- Для тестирования создана минимальная MVC-структура
- Использован `symfony/http-foundation` для безопасной работы с HTTP-запросами

---

### Задача 2: SQL-запросы

**Постановка:** Составить два SQL-запроса для работы с отделами и сотрудниками.

**Решение 1: Прямые SQL-запросы**
```sql
-- Запрос 1: Отделы с 5+ сотрудников
SELECT d.name
FROM department d
INNER JOIN worker w ON d.id = w.department_id
GROUP BY d.id, d.name
HAVING COUNT(w.id) >= 5
ORDER BY d.name;

-- Запрос 2: Отделы с ID сотрудников через запятую
SELECT d.name as department_name,
       GROUP_CONCAT(w.id ORDER BY w.id ASC SEPARATOR ', ') as worker_ids
FROM department d
LEFT JOIN worker w ON d.id = w.department_id
GROUP BY d.id, d.name
ORDER BY d.name;
```

**Решение 2: Использование Doctrine DBAL (рекомендуемый подход)**
```php
// Запрос 1: Отделы с 5+ сотрудников
$qb = Database::query();
$query1 = $qb
    ->select('d.name')
    ->from('department', 'd')
    ->innerJoin('d', 'worker', 'w', 'd.id = w.department_id')
    ->groupBy('d.id, d.name')
    ->having('COUNT(w.id) >= 5')
    ->orderBy('d.name');

// Запрос 2: Отделы с ID сотрудников через запятую
$qb = Database::query();
$query2 = $qb
    ->select(
        'd.name as department_name',
        'GROUP_CONCAT(w.id ORDER BY w.id ASC SEPARATOR \', \') as worker_ids'
    )
    ->from('department', 'd')
    ->leftJoin('d', 'worker', 'w', 'd.id = w.department_id')
    ->groupBy('d.id, d.name')
    ->orderBy('d.name');
```

**Обоснование:** В боевой среде рекомендуется использовать абстракции для работы с БД (Doctrine DBAL) для безопасности и переносимости кода.

---

### Задача 3: Создание базы данных

**Постановка:** Создать базу данных с таблицами persons, phones и связью many-to-many.

**Решение:** Использована система миграций Phinx.

**Код миграции:**
```php
public function change(): void
{
    $table = $this->table('persons');
    $table->addColumn('name', 'string')
        ->addColumn('surname', 'string')
        ->addColumn('lastname', 'string')
        ->create();

    $table = $this->table('phones');
    $table->addColumn('number', 'string')
        ->addIndex('number', [
            'unique' => true,
            'name' => 'idx_number_unique'
        ])
        ->create();

    $table = $this->table('persons_phones');
    $table->addColumn('person_id', 'integer', ['null' => false, 'signed' => false])
        ->addColumn('phone_id', 'integer', ['null' => false, 'signed' => false])
        ->addForeignKey('person_id', 'persons', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ])
        ->addForeignKey('phone_id', 'phones', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ])
        ->addIndex(['person_id', 'phone_id'], [
            'unique' => true,
            'name' => 'idx_person_phone_unique'
        ])
        ->create();
}
```

**Особенности:**
- Использован Phinx вместо Doctrine Migrations из-за проблем совместимости
- Реализованы каскадные операции удаления и обновления
- Добавлены уникальные индексы для обеспечения целостности данных

---

### Задача 4: Валидация HTML-структуры

**Постановка:** Проверить корректность вложенности HTML-тегов.

**Решение:** Использован встроенный механизм XML-парсинга PHP.

**Код:**
```php
public static function isHtmlStructureValid($tags): bool
{
    $xmlString = '<root>' . implode("\n", $tags) . '</root>';

    libxml_use_internal_errors(true);
    libxml_clear_errors();

    $result = simplexml_load_string($xmlString);
    $errors = libxml_get_errors();
    libxml_clear_errors();

    return $result !== false && empty($errors);
}
```

**Принцип работы:** 
1. Объединяем теги в XML-структуру
2. Используем `simplexml_load_string()` для парсинга
3. Проверяем наличие ошибок парсинга

---

## Установка и запуск

### Требования
- PHP 8.0 или выше
- Docker и Docker Compose
- Composer

### Установка и запуск

1. **Клонировать репозиторий:**
   ```bash
   git clone <url-репозитория>
   cd <папка-проекта>
   ```

2. **Установить зависимости PHP:**
   ```bash
   composer install
   ```

3. **Настроить окружение:**
   ```bash
   cp .env.example .env
   ```
   Отредактируйте файл `.env` при необходимости.

4. **Запустить контейнеры Docker:**
   ```bash
   docker-compose up -d
   ```
   Эта команда создаст и запустит:
   - Базу данных MySQL
   - PhpMyAdmin для управления БД

5. **Проверить соответствие параметров:**
   Убедитесь, что параметры подключения к базе данных в файле `.env` соответствуют настройкам в `docker-compose.yml`.

6. **Запустить встроенный PHP-сервер:**
   ```bash
   php -S localhost:8000 -t public
   ```

### Docker-сервисы

После запуска `docker-compose up -d` будут доступны:

- **MySQL:** `localhost:3306`
  - Пользователь: `root` (или как указано в `.env`)
  - Пароль: `secret` (или как указано в `.env`)
  - База данных: `test_db` (или как указано в `.env`)

- **PhpMyAdmin:** `http://localhost:8080`
  - Для входа используйте те же учетные данные, что и для MySQL

### Остановка сервисов

Для остановки Docker-контейнеров выполните:
```bash
docker-compose down
```

Для остановки с удалением томов (данные БД будут удалены):
```bash
docker-compose down -v
```

## Зависимости

Основные используемые пакеты:

- **symfony/http-foundation** — работа с HTTP-запросами и ответами
- **doctrine/dbal** — абстракция для работы с базой данных
- **robmorgan/phinx** — система миграций базы данных

## Структура проекта

```
├── app/
│   ├── Controllers/
│   ├── Helpers/
│   │   └── Arr.php
│   └── Core/
├── config/
├── mysql/
│   └── migrations/
├── public/
├── resources/
├── vendor/
└── README.md
```

## Заключение

Проект демонстрирует:
- Умение решать задачи без готовых фреймворков
- Понимание принципов безопасной разработки
- Опыт работы с системами миграций
- Знание современных подходов к веб-разработке
- Способность выбирать оптимальные инструменты для решения конкретных задач