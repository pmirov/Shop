<?php
session_start();
//require_once '/pages/Tools.php'; // Убедитесь, что вы подключили необходимые файлы

$users = Customer::GetAll(); // Получаем всех пользователей
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Список пользователей</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Подключите Bootstrap для стилей -->
</head>

<body>
    <div class="container">
        <h2>Список пользователей</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th>Скидка</th>
                    <th>Общая сумма</th>
                    <th>Изображение</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user->id); ?></td>
                        <td><?php echo htmlspecialchars($user->login); ?></td>
                        <td><?php echo htmlspecialchars($user->roleId); ?></td>
                        <td><?php echo htmlspecialchars($user->discount); ?></td>
                        <td><?php echo htmlspecialchars($user->total); ?></td>
                        <td><img src="<?php echo htmlspecialchars($user->imagepath); ?>" alt="User Image" style="width: 50px; height: auto;"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>