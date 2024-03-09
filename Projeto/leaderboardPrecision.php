<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="/Projeto/styles/leaderboard.css">
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

    <h1>Precision</h1>
    <table>
        <thead>
            <tr>
                <th>Posição</th>
                <th>Nome</th>
                <th>Hits</th>
            </tr>
        </thead>

        <?php
        $pos = 0;
        // Faz uma requisição para obter os usuários
        $url = "http://localhost:8888/Projeto/top.php?precision=1&leader=1";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        $users = json_decode($curl_response, true);

        // Verifica se existem usuários
        if ($users) {
            // Percorre os usuários e cria as linhas da tabela
            foreach ($users as $user) {
                $pos = $pos + 1; 
                $nome = $user['nome'];
                $hits = $user['hits'];

                echo "<tr>";
                echo "<td>$pos</td>";
                echo "<td>$nome</td>";
                echo "<td>$hits</td>";
                echo "</tr>";
            }
        }
        ?>

    </table>
</body>

</html>