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
    <link rel="stylesheet" href="styles/main_page.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
    <div class="container">
        <div class="gameShow">
            <iframe width="500" height="330" src="https://www.youtube.com/embed/gMseXXSrbOE" frameborder="1"></iframe>
        </div>
        <h1 id="training">Training:</h1>
        <div class="game-box rea" onclick="window.location.href='reaction.php'">
            <h2>Reaction</h2>
        </div>
        <div class="game-box tra" onclick="window.location.href='tracker.php'">
            <h2>Tracking</h2>
        </div>
        <div class="game-box pre" onclick="window.location.href='precision.php'">
            <h2>Precision</h2>
        </div>
    </div>

    <div id="leaderboard">
        <ul>
            <li><a href="leaderboardReaction.php">Leaderboard</a></li>
            <li><a href="leaderboardTracker.php">Leaderboard</a></li>
            <li><a href="leaderboardPrecision.php">Leaderboard</a></li>
        </ul>
    </div>

    <div id="linha1"></div>

    <div id="mainText">
        <h1>Aim Trainer CS</h1>
        <p>
            Aim Trainer CS is a free web-based game developed with the specific purpose of enhancing a player's aiming skills in
            various First-Person Shooter games, such as Fortnite, Counter-Strike: GO, and Call of Duty.
            With a singular focus on improving individual aim, Aim Trainer provides a wide range of customization options
            and diverse challenges meticulously designed to enhance different aspects of aiming. It serves as a tailored
            tool to assist players in becoming more proficient in games like Rainbow Six Siege, Overwatch, PUBG, and other
            First-Person Shooters.
        </p>
    </div>

    <div id="improve">
        <img src="images/logos.png" alt="logos">
        <h1>Improve Your FPS Skills</h1>
        <p>
            The objective of Aim Trainer is to enhance the player's aiming proficiency and various other facets of First-Person Shooter Games.
            Although each game possesses unique qualities, FPS titles such as Fortnite, Counter-Strike:
            GO, Apex Legends, and Rainbow Six Siege share comparable mechanics, resulting in similar skill demands.
            Aim Trainer serves as a valuable tool for players to refine these skills and elevate their performance in these games.
        </p>
    </div>

    <div id="pros">
        <img src="images/proplayer.jpg" alt="pro">
        <h1>Practice Like the Pros</h1>
        <p>
            Aim Trainer CS, along with practice, helps improve accuracy and aiming.
            It's a proven training method used by top eSports players in FPS games
            like Overwatch, PUBG, Fortnite, Call of Duty, and others. Embrace this approach to achieve exceptional performance.
        </p>
    </div>

    <div id="challenges">
        <img src="images/key.jpg" alt="challenges">
        <h1>Different Challenges</h1>
        <p>
            Aim Trainer CS offers specialized challenges designed to enhance specific aspects of aiming.
            With dedicated game modes focused on reflexes, accuracy, and multitarget shooting, the goal is to improve
            the player's performance in FPS games.
        </p>
    </div>

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
                window.location.href = 'admin.php'; // Redireciona para a página de admin
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
</body>

</html>