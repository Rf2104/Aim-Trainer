<?php
session_start(); // Inicia a sessão

$isadmin = false;
$loggedIn = false; // Variável de status de autenticação, assume que o usuário não está autenticado
$nome = "";

// Verifica se o usuário está autenticado
if (isset($_SESSION['nome_usuario'])) {
    $loggedIn = true; // Define a variável de status como verdadeira se o usuário estiver autenticado
    $nome = $_SESSION['nome_usuario'];
}

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    $isadmin = true;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS AIM TRAINER</title>
    <link rel="stylesheet" href="styles/reaction.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <div class="menu">
        <h1 id="tit">CS Aim Trainer</h1>
        <img id="logo" src="images/logoalvo.png">
        <ul>
            <li id="user">USER</li>
            <li><a id="home" href="main_page.php">Home</a></li>
            <li><a id="market" href="skinsmarketapi.php">Marketplace</a></li>
            <li id="login">Login</li>
        </ul>
    </div>
    <div id="info">
        <ul>
            <li id="hits">Hits: 0/8&nbsp;&nbsp;</li>
            <li id="avg">Average: 0.00&nbsp;&nbsp;</li>
            <li id="lasthit">Last Hit: 0.00</li>
        </ul>
    </div>
    <div id="divgame">
        <div id="divbox"></div>
        <button id="pgbutton">Play!</button>
    </div>

    <div id="user-name" data-user-name="<?php echo $nome; ?>"></div>

    <div class="footer">
        <a id="ref" href="main_page.php">
            <p>CS AIM TRAINER</p>
        </a>
        <a href="#" class="back-to-top">Voltar ao Topo</a>
    </div>

    <script>
        $(document).ready(function() {
            $(".back-to-top").click(function() {
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                return false;
            });
        });
    </script>

</body>
<script src="scripts/reaction.js"></script>

<script>
    $(document).ready(function() {
        // Verifica o status de autenticação
        var loggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
        var admin = <?php echo $isadmin ? 'true' : 'false'; ?>;
        console.log(admin);
        var userName = $('#user');

        var userlink = $('#user');
        if (admin) {
            console.log("É admin");
            userlink.click(function() {
                window.location.href = 'admin.php'; // Redireciona para a página de logout
            });
        }

        // Atualiza o texto do link e o nome do usuário
        if (loggedIn) {
            console.log("Está");
            userName.text('<?php echo $nome; ?>'); // Atualiza o nome do usuário
            userName.addClass('loggedIn'); // Adiciona uma classe para estilização opcional
        }

        // Verifica se o usuário está autenticado e atualiza o link de login/logout
        var loginLink = $('#login');
        if (loggedIn) {
            loginLink.text('Logout');
            loginLink.click(function() {
                console.log("Logout");
                window.location.href = 'logout.php'; // Redireciona para a página de logout
            });
        } else {
            loginLink.text('Login');
            loginLink.click(function() {
                window.location.href = 'login.php'; // Redireciona para a página de login
            });
        }
    });
</script>

</html>