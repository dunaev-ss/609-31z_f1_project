<?php

// Обработка входа пользователя
if (isset($_POST['login']) && $_POST['login'] !== '') {
    try {
        $sql = 'SELECT * FROM d_users WHERE email = (:login)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':login', $_POST['login']);
        $stmt->execute();

    } catch (PDOException $error) {
        $msg = 'Ошибка аутентификации: ' . $error->getMessage();
    }

    if ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        // Сравнение MD5-хеша пароля
        if (md5($_POST['password']) !== $row['md5_password']) {
            $msg = 'Неправильный пароль!';
        } else {
            // Сохранение данных пользователя в сессии после успешной аутентификации
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['id'] = $row['id'];
            $msg = 'Вы успешно вошли в систему';
        }
    } else {
        $msg = 'Неправильное имя пользователя!';
    }
}

// Обработка выхода пользователя
if (isset($_GET['logout'])) {
    $_SESSION = null;
    $_SESSION['msg'] = 'Вы успешно вышли из системы';
    header('Location: /');
    exit();
}
?>
