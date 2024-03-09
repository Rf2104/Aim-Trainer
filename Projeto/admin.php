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

// Função para enviar a solicitação de exclusão para a API
function deleteUser($userId)
{
    $url = "http://localhost:8888/Projeto/api.php?id=$userId&apagar=1";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    curl_close($curl);
}

// Verifica se o botão de exclusão foi clicado
if (isset($_GET['delete-button']) && isset($_GET['user-ids']) && !empty($_GET['user-ids'])) {
    // Obtém os IDs dos usuários selecionados
    $selectedUserIds = $_GET['user-ids'];

    // Envia a solicitação de exclusão para a API
    foreach ($selectedUserIds as $userId) {
        deleteUser($userId);
    }
}

// Verifica se o botão de edição foi clicado
if (isset($_GET['edit-button']) && isset($_GET['user-ids']) && !empty($_GET['user-ids'])) {
    // Obtém os valores dos campos de edição
    $Usersids = $_GET['user-ids'];
    $newName = $_GET['new-name'];
    $newPassword = $_GET['new-password'];

    foreach ($Usersids as $userId) {
        $url = "http://localhost:8888/Projeto/api.php?id=$userId&nome=$newName&pass=$newPassword";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);;
    }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS AIM TRAINER</title>
    <link rel="stylesheet" href="styles/admin.css">
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
    <br><br><br>
    <form method="get" action="">
        <button id="delete" type="submit" name="delete-button">Excluir Usuários</button>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Senha</th>
                <th>Admin</th>
            </tr>

            <?php
            // Faz uma requisição para obter os usuários
            $url = "http://localhost:8888/Projeto/api.php?todos=1";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            $users = json_decode($curl_response, true);

            // Verifica se existem usuários
            if ($users) {
                // Percorre os usuários e cria as linhas da tabela
                foreach ($users as $user) {
                    $id = $user['id'];
                    $usernome = $user['userNome'];
                    $senha = $user['userSenha'];
                    $isAdmin = $user['isAdmin'];

                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$usernome</td>";
                    echo "<td>$senha</td>";
                    echo "<td>$isAdmin</td>";
                    echo "<td id='check' >";
                    echo "<input type='checkbox' class='user-checkbox' name='user-ids[]' value='$id'>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <br>
        <div id="editar">
            <label for="new-name" style="color: white;">Novo Nome:</label>
            <input type="text" name="new-name" id="new-name">

            <label for="new-password" style="color: white;">Nova Senha:</label>
            <input type="text" name="new-password" id="new-password">

            <button type="submit" name="edit-button">Editar</button>
        </div>
    </form>

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
</body>

</html>