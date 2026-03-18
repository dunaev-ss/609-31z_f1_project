<h1>F1_project — Чемпионат Формулы 1</h1>

<?php
// SQL‑запрос для расчёта текущего положения пилотов в чемпионате
// Объединяются данные из нескольких таблиц:
// - t_standings (результаты гонок)
// - t_drivers (информация о пилотах)
// - d_countries (страны пилотов)
// - t_transfers (трансферы пилотов между командами)
// - t_teams (команды)
// - d_countries (страны команд)
//
// Логика:
// 1. Суммируем очки (PTS) для каждого пилота за указанный период.
// 2. Связываем пилота с его текущей командой через таблицу трансферов (учитываем даты начала/окончания).
// 3. Получаем названия стран и их аббревиатуры для пилотов и команд.
$result = $conn->query(
    "SELECT
        t_drivers.ID AS ID_DRIVER,
        t_drivers.DRIVER AS driver,
        t_drivers.DRIVER_ABBR AS driver_abbr,
        SUM(t_standings.PTS) AS standings,
        d_countries_driver.COUNTRY AS driver_country,
        d_countries_driver.COUNTRY_ABBR AS driver_country_abbr,
        t_teams.TEAM AS team,
        d_countries_team.COUNTRY AS team_country,
        d_countries_team.COUNTRY_ABBR AS team_country_abbr
    FROM
        t_standings
    INNER JOIN
        t_drivers ON t_standings.ID_DRIVER = t_drivers.ID
    INNER JOIN
        d_countries d_countries_driver ON t_drivers.ID_COUNTRY = d_countries_driver.ID
    INNER JOIN
        t_transfers ON t_standings.ID_DRIVER = t_transfers.ID_DRIVER
        AND t_standings.EVENT_DATE >= t_transfers.START_DATE
        AND (t_transfers.END_DATE IS NULL OR t_standings.EVENT_DATE <= t_transfers.END_DATE)
    INNER JOIN
        t_teams ON t_transfers.ID_TEAM = t_teams.ID
    INNER JOIN
        d_countries d_countries_team ON t_teams.ID_COUNTRY = d_countries_team.ID
    WHERE
        t_standings.EVENT_DATE >= '2024-01-01'
        AND t_standings.EVENT_DATE <= '2024-12-31'
    GROUP BY
        t_standings.ID_DRIVER,
        d_countries_driver.COUNTRY,
        d_countries_driver.COUNTRY_ABBR,
        t_teams.TEAM,
        d_countries_team.COUNTRY,
        d_countries_team.COUNTRY_ABBR
    ORDER BY
        SUM(t_standings.PTS) DESC;"
);

// Проверяем, что запрос выполнен успешно и вернул хотя бы одну строку
if ($result && $result->rowCount() > 0) {
    // Выводим адаптивную таблицу с результатами
    echo '<div class="table-responsive mt-4">';
    echo '<table class="table table-striped table-hover">';

    // Шапка таблицы с заголовками столбцов
    echo '<thead class="table-dark">';
    echo '<tr>';
    echo '<th scope="col">#</th>';
    echo '<th scope="col">Пилот</th>';
    echo '<th scope="col">Фото</th>';
    echo '<th scope="col">Страна</th>';
    echo '<th scope="col">Флаг</th>';
    echo '<th scope="col">Команда</th>';
    echo '<th scope="col">Логотип</th>';
    echo '<th scope="col">Страна</th>';
    echo '<th scope="col">Флаг</th>';
    echo '<th scope="col">Очки</th>';
    echo '</tr>';
    echo '</thead>';

    // Тело таблицы — строки с данными
    echo '<tbody>';
    $place = 1; // Номер позиции в чемпионате (начинается с 1)

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';

        // Позиция в чемпионате (жирным шрифтом)
        echo '<td><strong>' . $place . '</strong></td>';

        // Имя пилота (с экранированием для безопасности)
        echo '<td>' . htmlspecialchars($row['driver']) . '</td>';

        // Фото пилота: используем аббревиатуру для пути к изображению
        $driverAbbr = htmlspecialchars($row['driver_abbr']);
        $driverImgPath = '/img/drivers/' . $driverAbbr . '.webp';
        echo '<td>';
        echo '<img src="' . $driverImgPath . '" alt="Фото пилота ' . htmlspecialchars($row['driver']) . '" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">';
        echo '</td>';

        // Страна пилота
        echo '<td>' . htmlspecialchars($row['driver_country']) . '</td>';

        // Флаг страны пилота (используем аббревиатуру для пути)
        $driverCountryAbbr = htmlspecialchars($row['driver_country_abbr']);
        $flagImgPath = '/img/countries/' . $driverCountryAbbr . '.svg';
        echo '<td>';
        echo '<img src="' . $flagImgPath . '" alt="Флаг ' . htmlspecialchars($row['driver_country']) . '" style="width: 30px; height: 20px;">';
        echo '</td>';

        // Название команды
        echo '<td>' . htmlspecialchars($row['team']) . '</td>';

        // Логотип команды (используем название команды для пути)
        $teamName = htmlspecialchars($row['team']);
        $logoImgPath = '/img/teams/' . $teamName . '.webp';
        echo '<td>';
        echo '<img src="' . $logoImgPath . '" alt="Логотип команды ' . $teamName . '" style="width: 50px; height: 50px;">';
        echo '</td>';

        // Страна команды
        echo '<td>' . htmlspecialchars($row['team_country']) . '</td>';

        // Флаг команды (используем аббревиатуру страны)
        $teamCountryAbbr = htmlspecialchars($row['team_country_abbr']);
        $teamFlagImgPath = '/img/countries/' . $teamCountryAbbr . '.svg';
        echo '<td>';
        echo '<img src="' . $teamFlagImgPath . '" alt="Флаг команды из ' . htmlspecialchars($row['team_country']) . '" style="width: 30px; height: 20px;">';
        echo '</td>';

        // Очки пилота (в виде бейджа)
        echo '<td><span class="badge bg-info" style="font-size: 16px;">' . htmlspecialchars($row['standings']) . '</span></td>';

        echo '</tr>';
        $place++; // Увеличиваем номер позиции для следующей строки
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    // Если данных нет — выводим информационное сообщение
    echo '<div class="alert alert-info mt-4" role="alert">';
    echo 'Нет данных о результатах пилотов.';
    echo '</div>';
}
?>
