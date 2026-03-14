<?php
// Подключаем файл с настройками подключения к БД
require "dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Project — Чемпионат Формулы 1</title>
    <style>
        /* Стили для таблицы: */
        table {
            width: 100%;           /* Ширина таблицы — 100% от контейнера */
            border-collapse: collapse; /* Склеиваем границы ячеек */
            margin: 20px 0;      /* Отступы сверху и снизу — 20px */
        }
        th, td {
            border: 1px solid #ddd; /* Тонкая серая граница */
            padding: 8px;         /* Отступы внутри ячеек */
            text-align: left;    /* Выравнивание текста по левому краю */
        }
        th {
            background-color: #f2f2f2; /* Светлый серый фон для заголовков */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Чередующийся фон для строк */
        }
    </style>
</head>
<body>
    <h1>F1_project — Чемпионат Формулы 1</h1>

    <?php
    // Выводим подзаголовок
    echo "<h2>Grand Prix</h2>";

    // Выполняем SQL-запрос к таблице t_grand_prix
    // Явно указываем нужные поля для большей предсказуемости
    $result = $conn->query("SELECT ID, GRAND_PRIX, GP_ABBR, ID_COUNTRY FROM t_grand_prix");

    // Проверяем, вернул ли запрос какие-либо строки
    if ($result->rowCount() > 0) {
        // Если записи есть — начинаем формировать таблицу
        echo '<table>';
        
        // Шапка таблицы (заголовки столбцов)
        echo '<thead><tr><th>ID</th><th>GRAND_PRIX</th><th>GP_ABBR</th><th>ID_COUNTRY</th></tr></thead>';
        
        // Тело таблицы
        echo '<tbody>';

        // Цикл по всем полученным строкам
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>'; // Начинаем новую строку таблицы
            
            // Выводим каждое поле в отдельной ячейке
            // htmlspecialchars() защищает от XSS-атак
            echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
            echo '<td>' . htmlspecialchars($row['GRAND_PRIX']) . '</td>';
            echo '<td>' . htmlspecialchars($row['GP_ABBR']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ID_COUNTRY']) . '</td>';
            
            echo '</tr>'; // Закрываем строку таблицы
        }

        echo '</tbody></table>'; // Закрываем тело и таблицу
    } else {
        // Если записей нет — выводим информативное сообщение
        echo '<p>Нет данных в таблице t_grand_prix.</p>';
    }
    ?>
</body>
</html>
