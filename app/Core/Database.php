<?php

namespace App\Core;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Dotenv\Dotenv;

class Database
{
    private static ?Connection $connection = null;
    
    /**
     * Получить соединение с БД
     */
    public static function getConnection(): Connection
    {
        if (self::$connection === null) {
            self::connect();
        }
        
        return self::$connection;
    }
    
    /**
     * Установить соединение
     */
    private static function connect(): void
    {
        // Загружаем .env если не загружен
        if (!isset($_ENV['DB_HOST'])) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
            $dotenv->load();
        }
        
        $config = require dirname(__DIR__, 2) . '/config/database.php';
        $connectionName = $config['default'];
        $connectionConfig = $config['connections'][$connectionName];
        
        self::$connection = DriverManager::getConnection($connectionConfig);
        
        // Проверяем соединение
        try {
            self::$connection->fetchOne('SELECT 1');
        } catch (\Exception $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Создать QueryBuilder
     */
    public static function query(): QueryBuilder
    {
        return self::getConnection()->createQueryBuilder();
    }
    
    /**
     * Выполнить SQL запрос
     */
    public static function executeQuery(string $sql, array $params = []): \Doctrine\DBAL\Result
    {
        return self::getConnection()->executeQuery($sql, $params);
    }
    
    /**
     * Вставить запись
     */
    public static function insert(string $table, array $data): int
    {
        return self::getConnection()->insert($table, $data);
    }
    
    /**
     * Обновить запись
     */
    public static function update(string $table, array $data, array $criteria): int
    {
        return self::getConnection()->update($table, $data, $criteria);
    }
    
    /**
     * Удалить запись
     */
    public static function delete(string $table, array $criteria): int
    {
        return self::getConnection()->delete($table, $criteria);
    }
    
    /**
     * Начать транзакцию
     */
    public static function beginTransaction(): void
    {
        self::getConnection()->beginTransaction();
    }
    
    /**
     * Зафиксировать транзакцию
     */
    public static function commit(): void
    {
        self::getConnection()->commit();
    }
    
    /**
     * Откатить транзакцию
     */
    public static function rollback(): void
    {
        self::getConnection()->rollBack();
    }
    
    /**
     * Проверить существует ли таблица
     */
    public static function tableExists(string $table): bool
    {
        $schemaManager = self::getConnection()->createSchemaManager();
        return $schemaManager->tablesExist([$table]);
    }
    
    /**
     * Создать таблицу
     */
    public static function createTable(string $sql): void
    {
        self::getConnection()->executeStatement($sql);
    }
    
    /**
     * Закрыть соединение
     */
    public static function close(): void
    {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}