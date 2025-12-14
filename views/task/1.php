<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>

<body>
    <div class="summary">
        <h2>Результат обработки массива</h2>
    </div>

    <div class="test-container">
        <div class="test-case" style="background-color: #AFF;">
            <div class="test-name">
                Title:
            </div>
            <div class="test-tags" style="max-height:none;">
                <pre><?php echo htmlspecialchars($data['title']) ?></pre>
            </div>
        </div>
    </div>

</body>

</html>