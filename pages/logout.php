<?php

session_start(); // Начинаем сессию

// Удаляем все переменные сессии
$_SESSION = [];

// Если нужно, уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на главную страницу или страницу входа
header("Location: index.php");
exit();
