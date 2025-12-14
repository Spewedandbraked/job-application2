<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Html;
use Symfony\Component\HttpFoundation\Request;

class FourthTask extends Controller
{

    private $defaultTaskData;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->defaultTaskData = [
            '<a>',
            '<div>',
            '</div>',
            '</a>',
            '<span>',
            '</span>'
        ];
    }
    public function isHtmlStructureValid()
    {
        $testCases = [
            'Корректный пример 1'   => $this->defaultTaskData,
            'Некорректный пример 2' => ['<a>', '<div>', '</a>'],
            'Корректный вложенный'  => ['<div>', '<p>', '<span>', '</span>', '</p>', '</div>'],
            'Некорректный порядок'  => ['<div>', '<p>', '</div>', '</p>'],
            'Одинарные теги'        => ['<br>', '<hr>', '<img>'],
            'С атрибутами'          => ['<a href="#">', '<div class="test">', '</div>', '</a>'],
            'Пустой'                => [],
            'Только закрывающие'    => ['</div>', '</p>'],
            'Только открывающие'    => ['<div>', '<p>', '<span>'],
            'Самозакрывающиеся'     => ['<div>', '<br/>', '<img src="test.jpg"/>', '</div>'],
        ];

        $results = [];
        foreach ($testCases as $name => $tags) {
            $results[] = [
                'name' => $name,
                'tags' => $tags,
                'isValid' => Html::isHtmlStructureValid($tags)
            ];
        }

        $this->view('task/4', ['testResults' => $results]);
    }
}
