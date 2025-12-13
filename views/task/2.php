<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Task</title>
</head>

<body style="display: flex;">
    <div style="background-color: #AFF; padding:6px;height:min-content;">
        Запрос 1: Отделы с 5+ сотрудников:
        <pre><?php print_r($data[0]) ?></pre>
    </div>
    <div style="background-color: #FFA; padding:6px;height:min-content;">
        Запрос 2: Отделы с ID сотрудников через запятую:
        <pre><?php print_r($data[1]) ?></pre>
    </div>
</body>

</html>