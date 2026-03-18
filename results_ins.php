<?php

// Подключение файла с настройками соединения к базе данных
require 'dbconnect.php';

// Очистка сообщения в сессии перед обработкой формы
$_SESSION['msg'] = '';

// Проверка наличия и заполненности обязательных полей формы
// Используем isset() и empty() для защиты от пустых/непереданных значений
if (
    isset($_POST['id_grand_prix'], $_POST['event_date'], $_POST['id_driver'], $_POST['grd'], $_POST['pos'], $_POST['pts']) &&
    !empty($_POST['id_grand_prix']) &&
    !empty($_POST['event_date']) &&
    !empty($_POST['id_driver']) &&
    !empty($_POST['grd']) &&
    !empty($_POST['pos']) &&
    !empty($_POST['pts'])
) {
    try {
        // SQL-запрос на добавление новой записи в таблицу t_standings
        $sql = 'INSERT INTO t_standings (
                    ID_GRAND_PRIX,
                    EVENT_DATE,
                    ID_DRIVER,
                    GRD,
                    POS,
                    PTS,
                    PP,
                    FL
                ) VALUES (
                    :id_grand_prix,
                    :event_date,
                    :id_driver,
                    :grd,
                    :pos,
                    :pts,
                    :pp,
                    :fl
                )';

        // Подготовка запроса к выполнению
        $stmt = $conn->prepare($sql);

        // Привязка значений из POST-запроса к параметрам запроса
        $stmt->bindValue(':id_grand_prix', $_POST['id_grand_prix'], PDO::PARAM_INT);
        $stmt->bindValue(':event_date', $_POST['event_date']);
        $stmt->bindValue(':id_driver', $_POST['id_driver'], PDO::PARAM_INT);
        $stmt->bindValue(':grd', $_POST['grd'], PDO::PARAM_INT);
        $stmt->bindValue(':pos', $_POST['pos'], PDO::PARAM_STR);
        $stmt->bindValue(':pts', $_POST['pts'], PDO::PARAM_INT);

        // Обработка чекбоксов PP и FL: если не отмечены — передаём 0, иначе 1
        $stmt->bindValue(':pp', isset($_POST['pp']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':fl', isset($_POST['fl']) ? 1 : 0, PDO::PARAM_INT);


        // Выполнение запроса
        $stmt->execute();

        // Установка сообщения об успешном добавлении записи
        $_SESSION['msg'] = 'Запись успешно добавлена';

    } catch (PDOException $error) {
        // Обработка ошибок выполнения запроса
        // Сохранение сообщения об ошибке в сессии для отображения пользователю
        $_SESSION['msg'] = 'Ошибка при добавлении записи: ' . $error->getMessage();
    }
} else {
    // Если обязательные поля не заполнены — выводим сообщение об ошибке
    $_SESSION['msg'] = 'Ошибка: заполните все обязательные поля (Гран‑при, дата, пилот, старт, финиш, очки).';
}

// Перенаправление пользователя на страницу с результатами
header('Location: http://localhost/index.php?page=results');

exit();

?>
