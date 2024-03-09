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


<?php

$URL2 = 'https://csgobackpack.net/api/GetItemsList/v2/';

$curl2 = curl_init($URL2);
curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
$resultado2 = json_decode(curl_exec($curl2));

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MARKETPLACE</title>
    <link rel="stylesheet" href="/Projeto/styles/market.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>

<body>
    <div class="menu">
        <h1 id="tit">CS Aim Trainer</h1>
        <img id="logo" src="/Projeto/images/logoalvo.png">
        <ul>
            <li id="user">USER</li>
            <li><a id="home" href="main_page.php">Home</a></li>
            <li><a id="market" href="skinsmarketapi.php">Marketplace</a></li>
            <li id="login">Login</li>
        </ul>
    </div>
    <form method="POST">
        <br>
        <h1 style="color: white">Skins de CS GO</h1>
        <select class="selects" style="height: 30px; border-radius: 2px" name="tipo" required>
            <option value="" disabled selected>Tipo</option>
            <?php
            $arArma = array();
            foreach ($resultado2->items_list as $tipo) {
                if (!in_array($tipo->gun_type, $arArma)) {
                    array_push($arArma, $tipo->gun_type);
                    echo "<option value='" . $tipo->gun_type . "'>" . $tipo->gun_type . "</option>";
                }
            }
            ?>
        </select>
        &nbsp
        <select class="selects" style="height: 30px; border-radius: 2px" name="cond" required>
            <option value="" disabled selected>Estado</option>
            <?php
            $arArma = array();
            foreach ($resultado2->items_list as $tipo) {
                if (!in_array($tipo->exterior, $arArma)) {
                    array_push($arArma, $tipo->exterior);
                    echo "<option value='" . $tipo->exterior . "'>" . $tipo->exterior . "</option>";
                }
            }
            ?>
        </select>
        &nbsp
        <select class="selects" style="height: 30px; border-radius: 2px" name="raridade" required>
            <option value="" disabled selected>Raridade</option>
            <?php
            $arArma = ["Consumer Grade", "Industrial Grade", "Mil-Spec Grade", "Restricted", "Classified", "Covert", "Contraband"];
            foreach ($arArma as $rarity) {
                echo "<option value='" . $rarity . "'>" . $rarity . "</option>";
            }
            ?>
        </select>
        <br><br>
        <input id="sub" type="submit" value="Procurar"></input>
    </form>
    <div style="margin-top:2%; padding-bottom: 80px;">
        <?php
        $array = array();
        if (isset($_POST['tipo'], $_POST['cond'], $_POST['raridade'])) {
            foreach ($resultado2->items_list as $item) {
                if (
                    property_exists($item, 'gun_type') && $item->gun_type == $_POST['tipo'] &&
                    property_exists($item, 'exterior') && $item->exterior == $_POST['cond'] &&
                    property_exists($item, 'rarity') && $item->rarity == $_POST['raridade']
                ) {
        ?>
                    <div id="items">
                        <img src="<?php echo "http:\/\/steamcommunity-a.akamaihd.net\/economy\/image\/" . $item->icon_url ?>" alt="Imagem da skin">
                        <p>Name: <?php echo $item->name ?></p>
                        <div id="edit"></div>
                    </div>
            <?php
                    $coisa = "Name: " . $item->name;
                    array_push($array, $coisa);
                }
            }
            ?>
            <script>
                var array = <?php echo json_encode($array) ?>;
            </script>
            <button id="pdfgen" onclick="gerarPDF()">Gerar PDF</button>
        <?php
        }
        ?>
    </div>
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

</html>

<script>
    function gerarPDF() {
        const doc = new jsPDF();
        doc.setFont("helvetica");
        doc.setFontType("bold");
        doc.setFontSize(20);
        doc.text("Skins", 10, 25);
        doc.setFontSize(11);
        for (let index = 0; index < array.length; index++) {
            const element = array[index];
            doc.text(element, 10, (index+4) * 10);

        }
        doc.save('skins.pdf');
    }
</script>