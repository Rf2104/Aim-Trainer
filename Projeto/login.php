<?php
$errorMessage = "";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtém os valores do formulário
    $username = $_POST["user"];
    $password = $_POST["pass"];

    $curl = curl_init("http://localhost:8888/Projeto/api.php?nome=$username&pass=$password&update=1&procurar=1");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($curl_response);

    session_start();

    if ($data && isset($data->success) && $data->success) {

        // Armazenar os detalhes do usuário na sessão
        $_SESSION['nome_usuario'] = $username;

        $_SESSION['is_admin'] = $data->isAdmin;

        header("Location: main_page.php"); // Redirecionar para a página principal
        exit();
    } else {
        $errorMessage = "Nome de usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
    <div class="main">
        <h1>Login</h1>
        <?php if ($errorMessage !== "") {
            echo '<div style="color: white; text-align: center;">' . $errorMessage . '</div>';
        }
        ?>
        <form method="POST">
            <div class="text">
                <input id="user" name="user" class="input" type="text" required>
                <span></span>
                <label for="user">Username</label>
            </div>
            <div class="text">
                <input id="pass" name="pass" class="input" type="password" required>
                <span></span>
                <label for="pass">Password</label>
            </div>
            <input type="submit" value="Login"></input>
            <div id="sIN">
                New account? <a href="register.php">Sign in</a>
            </div>
        </form>
    </div>
</body>

</html>