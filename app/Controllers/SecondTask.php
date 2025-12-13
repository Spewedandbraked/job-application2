<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class SecondTask extends Controller
{
    public function querry()
    {
        // Запрос 1: Отделы с 5+ сотрудников
        $query1 = "
            SELECT d.name
            FROM department d
            INNER JOIN worker w ON d.id = w.department_id
            GROUP BY d.id, d.name
            HAVING COUNT(w.id) >= 5
            ORDER BY d.name
        ";
        $result1 = Database::executeQuery($query1)->fetchAllAssociative();
        $json1 = json_encode($result1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // Запрос 2: Отделы с ID сотрудников через запятую
        $query2 = "
            SELECT d.name as department_name,
            GROUP_CONCAT(w.id ORDER BY w.id ASC SEPARATOR ', ') as worker_ids
            FROM department d
            LEFT JOIN worker w ON d.id = w.department_id
            GROUP BY d.id, d.name
            ORDER BY d.name;
        ";
        $result2 = Database::executeQuery($query2)->fetchAllAssociative();
        $json2 = json_encode($result2, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $this->view('task/2', [$json1, $json2]);
    }

    public function querryBuilder()
    {
        // Запрос 1: Отделы с 5+ сотрудников
        $qb = Database::query();
        $query1 = $qb
            ->select('d.name')
            ->from('department', 'd')
            ->innerJoin('d', 'worker', 'w', 'd.id = w.department_id')
            ->groupBy('d.id, d.name')
            ->having('COUNT(w.id) >= 5')
            ->orderBy('d.name');

        $result1 = $query1->executeQuery()->fetchAllAssociative();
        $json1 = json_encode($result1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

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

        $result2 = $query2->executeQuery()->fetchAllAssociative();
        $json2 = json_encode($result2, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $this->view('task/2', [$json1, $json2]);
    }
}
