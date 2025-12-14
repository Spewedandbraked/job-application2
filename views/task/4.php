<?php

use App\Helpers\ColorGenerator;

$totalTests = count($testResults);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Fourth Task</title>

    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>

<body>
    <div class="summary">
        <h2>Результаты проверки HTML структуры</h2>
        <p>Всего тестов: <?php echo $totalTests; ?></p>
        <div class="stats">
            <?php
            $validCount = 0;
            foreach ($testResults as $result) {
                if ($result['isValid']) $validCount++;
            }
            $invalidCount = $totalTests - $validCount;
            ?>
            <div class="stat-item">
                <div class="stat-value" style="color: green;"><?php echo $validCount; ?></div>
                <div>Корректных</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" style="color: red;"><?php echo $invalidCount; ?></div>
                <div>Некорректных</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo round(($validCount / $totalTests) * 100, 1); ?>%</div>
                <div>Успешных</div>
            </div>
        </div>
    </div>

    <div class="test-container">
        <?php foreach ($testResults as $index => $test): ?>
            <?php
            // Генерируем цвет фона для каждого блока
            // Вариант 1: Простой градиент
            // $backgroundColor = ColorGenerator::generateGradientColor($index, $totalTests);

            // Вариант 2: Сложная схема с буквами
            $backgroundColor = ColorGenerator::generateColor($index);
            ?>
            <div class="test-case" style="background-color: #<?php echo $backgroundColor; ?>;">
                <div class="test-name">
                    Тест #<?php echo ($index + 1); ?>: <?php echo htmlspecialchars($test['name']); ?>
                </div>

                <div class="test-tags">
                    <?php if (empty($test['tags'])): ?>
                        <em>Пустой массив тегов</em>
                    <?php else: ?>
                        <?php foreach ($test['tags'] as $tag): ?>
                            <?php echo htmlspecialchars($tag); ?><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="test-result <?php echo $test['isValid'] ? 'valid' : 'invalid'; ?>">
                    <?php if ($test['isValid']): ?>
                        ✓ КОРРЕКТНО (true)
                    <?php else: ?>
                        ✗ НЕКОРРЕКТНО (false)
                    <?php endif; ?>
                </div>

                <div style="margin-top: 10px; font-size: 12px; color: #666;">
                    Тегов: <?php echo count($test['tags']); ?> |
                    Цвет: #<?php echo $backgroundColor; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>