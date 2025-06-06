<?php
session_start();
require_once 'db_connection.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Если не авторизован, перенаправляем на вход
    exit();
}

$stmt = $pdo->query("
    SELECT l.lang_name, COUNT(ul.user_id) as user_count
    FROM langs l
    LEFT JOIN users_languages1 ul ON l.lang_id = ul.lang_id
    GROUP BY l.lang_id
");
$lang_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];    //Массив для названий ЯП
$data = [];      //Массив для количества пользователей
foreach ($lang_stats as $row) {
    $labels[] = $row['lang_name'];
    $data[] = $row['user_count'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика ЯП</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        canvas {
            max-width: 700px;
            margin: auto;
        }
        #langChart {
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Статистика по языкам программирования</h2>
    <canvas id="langChart"></canvas>

    <script>
        const ctx = document.getElementById('langChart').getContext('2d');
        const langChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>, // Подписи языков
                datasets: [{
                    label: 'Количество пользователей',
                    data: <?= json_encode($data) ?>, // Данные
                    backgroundColor: 'rgba(174, 137, 211)',
                    borderColor: 'rgba(60, 32, 87)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <a href="adminpage.php">Назад к странице администратора</a>
</body>
</html>
