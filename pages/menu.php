<?php
session_start();


class MenuItem
{
  private $class;
  private $href;
  private $name;
  function __construct($href, $name, $active = "")
  {

    $this->class = "nav-link $active";
    $this->href = $href;
    $this->name = $name;
  }
  function Create()
  {
    echo "<li class='nav-item'>";
    echo "<a class='$this->class' href='$this->href'>$this->name</a>";
    echo "</li>";
  }
}
// Обработка входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Здесь должна быть проверка логина и пароля
  // Для примера, просто проверим, что они не пустые
  if ($username && $password) {
    // Сохраняем имя пользователя в сессии
    $_SESSION['username'] = $username;
    header("Location: index.php"); // Перенаправляем на главную страницу после входа
    exit();
  }
}
?>

<ul class="nav nav-tabs">
  <?php
  $active = "";
  if (isset($_GET['page'])) {
    $active = $_GET["page"];
  }


  $admin = new MenuItem("index.php?page=admin", "Admin", $active == "admin" ? "active" : "");
  $cart = new MenuItem("index.php?page=cart", "Cart", $active == "cart" ? "active" : "");
  $registration = new MenuItem("index.php?page=reg", "Registration", $active == "reg" ? "active" : "");
  $report = new MenuItem("index.php?page=report", "Report", $active == "report" ? "active" : "");
  $catalog = new MenuItem("index.php?page=catalog", "Catalog", $active == "catalog" ? "active" : "");
  $login = new MenuItem("index.php?page=login", "Вход", $active == "login" ? "active" : "");
  $logout = new MenuItem("index.php?page=logout", "Выход", $active == "logout" ? "active" : "");


  $registration->Create();
  $cart->Create();
  $report->Create();
  $catalog->Create();

  if (isset($_SESSION['username'])) {
    if ($_SESSION['username'] != "admin") { // Например, 1 - это роль покупателя
      echo "<li class='nav-item'><span class='nav-link'>Покупатель: " . htmlspecialchars($_SESSION['username']) . "</span></li>";
    } else { // Например, 2 - это роль администратора
      echo "<li class='nav-item'><span class='nav-link'>Админ: " . htmlspecialchars($_SESSION['username']) . "</span></li>";
      $admin->Create(); // Показываем ссылку на админку
    }
    echo "<li class='nav-item'>" . $logout->Create() . "</li>";
  } else {
    $login->Create();
  }
  ?>


</ul>