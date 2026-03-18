<h1>F1_project — Результаты гонок</h1>

<?php
// SQL-запрос для получения данных о результатах гонок
// Объединяем таблицы:
// - t_standings (основные данные о результатах)
// - t_grand_prix (названия Гран‑при)
// - t_drivers (имена пилотов)
// Сортируем:
// 1. по дате события (новые сверху)
// 2. по количеству очков (больше очков — выше)
// 3. по финишной позиции (лучше позиция — выше)
// Ограничиваем вывод 20 последними записями
$result = $conn->query(
    "SELECT
        t_standings.ID AS standing_id,
        t_standings.EVENT_DATE AS event_date,
        t_grand_prix.GRAND_PRIX AS grand_prix,
        t_drivers.DRIVER AS driver,
        t_standings.GRD AS grid_position,
        t_standings.POS AS final_position,
        t_standings.PTS AS points,
        t_standings.PP AS pole_position,
        t_standings.FL AS fastest_lap
    FROM
        t_standings
    INNER JOIN
        t_grand_prix ON t_standings.ID_GRAND_PRIX = t_grand_prix.ID
    INNER JOIN
        t_drivers ON t_standings.ID_DRIVER = t_drivers.ID
    ORDER BY
        t_standings.EVENT_DATE DESC,
        t_standings.PTS DESC,
        t_standings.POS ASC
    LIMIT 20;"
);

// Проверяем, что запрос выполнен успешно и вернул хотя бы одну строку
if ($result && $result->rowCount() > 0) {
    // Выводим адаптивную таблицу с результатами
    echo '<div class="table-responsive mt-4">';
    echo '<table class="table table-striped table-hover">';
    
    // Шапка таблицы с заголовками столбцов
    echo '<thead class="table-dark">';
    echo '<tr>';
    echo '<th scope="col">ID</th>';
    echo '<th scope="col">Дата события</th>';
    echo '<th scope="col">Гран‑при</th>';
    echo '<th scope="col">Пилот</th>';
    echo '<th scope="col">Старт</th>';
    echo '<th scope="col">Финиш</th>';
    echo '<th scope="col">Очки</th>';
    echo '<th scope="col">Поул</th>';
    echo '<th scope="col">Быстрый круг</th>';
    echo '</tr>';
    echo '</thead>';
    
    // Тело таблицы — строки с данными
    echo '<tbody>';
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        // Выводим ID записи
        echo '<td>' . $row['standing_id'] . '</td>';
        // Выводим дату события
        echo '<td>' . $row['event_date'] . '</td>';
        // Выводим название Гран‑при
        echo '<td>' . $row['grand_prix'] . '</td>';
        // Выводим имя пилота
        echo '<td>' . $row['driver'] . '</td>';
        // Позиция на старте
        echo '<td>' . $row['grid_position'] . '</td>';
        // Финишная позиция
        echo '<td>' . $row['final_position'] . '</td>';
        // Набранные очки
        echo '<td>' . $row['points'] . '</td>';
        // Признак поул‑позиции (1 → «Да», 0 → «Нет»)
        echo '<td>' . ($row['pole_position'] ? 'Да' : 'Нет') . '</td>';
        // Признак быстрого круга (1 → «Да», 0 → «Нет»)
        echo '<td>' . ($row['fastest_lap'] ? 'Да' : 'Нет') . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    
    echo '</table>';
    echo '</div>';
} else {
    // Если данных нет — выводим информационное сообщение
    echo '<div class="alert alert-info mt-4" role="alert">';
    echo 'Нет данных о результатах гонок.';
    echo '</div>';
}
?>
