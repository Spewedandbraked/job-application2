<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Arr;
use Symfony\Component\HttpFoundation\Request;

class FirstTask extends Controller
{
    private $defaultTaskData;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        /**
         * Оригинальный набор данных из ТЗ
         */
        $this->defaultTaskData = array(
            array(
                "id" => 1,
                "title" =>  "Обувь",
                'children' => array(
                    array(
                        'id' => 2,
                        'title' => 'Ботинки',
                        'children' => array(
                            array('id' => 3, 'title' => 'Кожа'),
                            array('id' => 4, 'title' => 'Текстиль'),
                        ),
                    ),
                    array('id' => 5, 'title' => 'Кроссовки',),
                )
            ),
            array(
                "id" => 6,
                "title" =>  "Спорт",
                'children' => array(
                    array(
                        'id' => 7,
                        'title' => 'Мячи'
                    )
                )
            ),
        );
    }

    public function searchCategory($data = null)
    {
        if (!isset($data)) {
            $data = $this->defaultTaskData;
        }

        if (!$find = $this->request->query->get('id')) {
            return $this->view('home/404');
        }


        $foundCategory = Arr::recursiveSearch(
            array: $data,
            searchField: 'id',
            recursiveKey: 'children',
            searchable: $find
        );

        $this->view('task/1', $foundCategory);
    }
}
