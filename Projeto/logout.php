<?php
session_start();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login
header("Location: main_page.php");
exit();
