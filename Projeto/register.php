<?php

// Inicializar a variável de erro
$errorMessage = "";

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    // Validar se as senhas correspondem
    if (strlen($password) < 6) {
        $errorMessage = "Passwords must be at least 6 characters";
    } else {
        if ($password !== $confirm) {
            $errorMessage = "As senhas não correspondem";
        } else {
            // Inserir o usuário no banco de dados
            $url = "http://localhost:8888/Projeto/api.php?nome=$username&pass=$password&update=1&isAdmin=0";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_response = curl_exec($curl);
            curl_close($curl);

            header("Location: login.php"); // Redirecionar para a página de login
            exit(); // Certificar-se de que o script pare de ser executado após o redirecionamento
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="styles/register.css">
    </head>

    <body>
        <div class="main">
            <h1>Register</h1>
            <?php if ($errorMessage !== "") { ?>
            <div style="color: white; text-align: center;">
                <?php echo $errorMessage; ?>
            </div>
            <?php } ?>
            <form method="POST">
                <div class="text">
                    <input id="user" name="username" class="input" type="text" required>
                    <span></span>
                    <label for="user">Username</label>
                </div>
                <div class="text">
                    <input id="pass" name="password" class="input" type="password" required>
                    <span></span>
                    <label for="pass">Password</label>
                </div>
                <div class="text">
                    <input name="confirm" class="input" type="password" required>
                    <span></span>
                    <label for="pass">Confirm Password</label>
                </div>
                <input id="reg" type="submit" value="Register"></input>
                <div id="sIN">
                    Already registered? <a href="login.php">Login</a>
                </div>
            </form>
        </div>
    </body>

</html>
