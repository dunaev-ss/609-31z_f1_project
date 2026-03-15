<?php
session_start();

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}

date_default_timezone_set('Asia/Yekaterinburg');

require 'dbconnect.php';
require 'auth.php';
require 'menu.php';

echo '<main class="container" style="margin-top: 100px">';

// if (isset($_GET['page'])) {
//     switch ($_GET['page']) {
//         case 'c':
//             if (isset($_SESSION['login'])) {
//                 require 'categories.php';
//             } else {
//                 $msg = 'Войдите в систему для просмотра и создания категорий';
//             }
//             break;

//         case 't':
//             if (isset($_SESSION['login'])) {
//                 require 'tasks.php';
//                 require 'taskform.php';
//             } else {
//                 $msg = 'Войдите в систему для просмотра и создания задач';
//             }
//             break;
//     }
// }

// echo '</main>';

// if ((isset($_SESSION['msg']) && $_SESSION['msg'] != '') || isset($msg)) {
//     require 'message.php';
//     $_SESSION['msg'] = '';
//     unset($msg);
// }

// require 'footer.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Project — Чемпионат Формулы 1</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }    
    </style>
</head>
<body>
    <h1>F1_project — Чемпионат Формулы 1</h1>
    <div style="margin: 66px 0; text-align: justify;">
        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h3>
    </div>

    <?php
    echo "<h2>Таблица Grand Prix</h2>";

    $result = $conn->query("SELECT ID, GRAND_PRIX, GP_ABBR, ID_COUNTRY FROM t_grand_prix");

    if ($result->rowCount() > 0) {
        echo '<table>';
        echo '<thead><tr><th>ID</th><th>GRAND_PRIX</th><th>GP_ABBR</th><th>ID_COUNTRY</th></tr></thead>';
        echo '<tbody>';

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
            echo '<td>' . htmlspecialchars($row['GRAND_PRIX']) . '</td>';
            echo '<td>' . htmlspecialchars($row['GP_ABBR']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ID_COUNTRY']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>Нет данных в таблице t_grand_prix.</p>';
    }
    ?>

</body>
</html>
