<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Task</title>

    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>

<body>
    <div class="summary">
        <h2>Результаты SQL запросов</h2>
        <div class="stats">
            <div class="stat-item">
                <div class="stat-value">2</div>
                <div>Всего запросов</div>
            </div>
        </div>
    </div>

    <div class="test-container">
        <div class="test-case" style="background-color: #AFF; height:max-content; width:max-content;">
            <div class="test-name">
                Запрос 1: Отделы с 5+ сотрудников
            </div>
            <div class="test-tags" style="max-height:none;">
                <pre><?php print_r($data[0]) ?></pre>
            </div>
        </div>

        <div class="test-case" style="background-color: #FFA; height:max-content; width:max-content;">
            <div class="test-name">
                Запрос 2: Отделы с ID сотрудников через запятую
            </div>
            <div class="test-tags" style="max-height:none;">
                <pre><?php print_r($data[1]) ?></pre>
            </div>
        </div>
    </div>
</body>

</html>