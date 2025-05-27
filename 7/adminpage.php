<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

require_once 'db_connection.php';

// Запрос для получения данных пользователей
$stmt = $pdo->prepare("
    SELECT 
        u.user_id, u.login, u.fio, u.phone, u.email, u.dob, u.gender, u.bio,
        GROUP_CONCAT(l.lang_name ORDER BY l.lang_name SEPARATOR ', ') AS langs
    FROM users1 u
    LEFT JOIN users_languages1 ul ON u.user_id = ul.user_id
    LEFT JOIN langs l ON ul.lang_id = l.lang_id
    GROUP BY u.user_id
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Страница администратора</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            background-color:rgb(141, 161, 199);
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        a {
            border: 2px solid rgb(10, 58, 28);
            background-color:rgb(156, 233, 165);
            text-decoration: none;
            color: #0e0e2d;
            padding: 1px;
        }
        button {
            padding: 0;
            border: 2px solid rgb(84, 19, 34);
            background-color:rgb(236, 119, 148);
            padding: 1px;
        }
        .exit {
            position: absolute;
            top: 10px;
            left: 10px;
            border: 2px solid rgb(10, 58, 28);
            padding: 8px;
            border-radius: 30%;
        }
        .langbutton {
            position: absolute;
            top: 10px;
            right: 10px;
            border: 2px solid rgb(83, 16, 141);
            padding: 8px;
            background-color:rgb(207, 180, 245);
            border-radius: 30%;
        }


    </style>
    <script>
        function confirmDelete(userId) {
            if (confirm("Вы уверены, что хотите удалить пользователя?")) {
                window.location.href = 'delete_user.php?user_id=' + userId;
            }
        }
    </script>
</head>
<body>

<h1>Страница администратора</h1>
<a href="mainpage.html" class="exit">Выйти</a>
<a href="stats.php" class="langbutton">Статистика ЯП</a>
<table>
    <tr>
        <th>ID</th>
        <th>Логин</th>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Дата рождения</th>
        <th>Пол</th>
        <th>О себе</th>
        <th>Любимые ЯП</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['login'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['fio'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['dob'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['gender'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['bio'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['langs'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <a href="edit_user.php?user_id=<?php echo htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8'); ?>">Редактировать</a>
                <button onclick="confirmDelete(<?php echo htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8'); ?>)">Удалить</button>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
