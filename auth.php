<?php
if (isset($_POST['login']) && $_POST['login'] != '') {
    try {
        $sql = 'SELECT * FROM d_users WHERE email = (:login)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':login', $_POST['login']);
        $stmt->execute();
    } catch (PDOException $error) {
        $msg = 'Ошибка аутентификации: ' . $error->getMessage();
    }

    if ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        if (md5($_POST['password']) != $row['md_5password']) {
            $msg = 'Неправильный пароль!';
        } else {
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

if (isset($_GET['logout'])) {
    $_SESSION = null;
    $_SESSION['msg'] = 'Вы успешно вышли из системы';
    header('Location: /');
    exit();
}
?>
