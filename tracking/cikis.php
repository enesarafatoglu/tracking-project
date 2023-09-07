<?php
// Önceki sayfada başlatılan oturumu devam ettir
session_start();

// Oturumu sonlandır
session_unset();
session_destroy();

// Giriş sayfasına yönlendir
header("Location: index.html");
exit();
?>
