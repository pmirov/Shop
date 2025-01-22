<?php
session_start(); // Начинаем сессию

// Обработка входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {
        // Получаем пользователя из базы данных
        $connect = Tools::ConnectSQL();
        $query = $connect->prepare("SELECT * FROM Customers WHERE login = :login AND PASSWORD = :password");
        $query->execute(['login' => $username, 'password' => $password]);
        $user = $query->fetch();

        $res = mysql_query($query);
        if ($row = mysql_fetch_array($res, MYSQL_NUM)) {
            // Сохраняем имя пользователя и roleId в сессии
            $_SESSION['username'] = $user['login'];
            $_SESSION['roleId'] = $user['roleId']; // Сохраняем roleId
            header("Location: index.php"); // Перенаправляем на главную страницу после входа
            exit();
        } else {
            echo "Неверный логин или пароль.";
        }
    }
}


?>


<div class="container">
    <h2>Вход</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Логин</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>
<?php if (isset($_SESSION['username'])): ?>
    <li class='nav-item'>
        <span class='nav-link'>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
    </li>
    <li class='nav-item'>
        <a class='nav-link' href='/Shop/pages/logout.php'>Выйти</a>
    </li>
<?php else: ?>
    <li class='nav-item'>
        <a class='nav-link' href='/Shop/pages/login.php'>Вход</a>
    </li>
<?php endif; ?>
</ul>